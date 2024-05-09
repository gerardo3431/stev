$(function() {
	'use strict'
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	

	var estudio = $('#selectEstudio').select2({ 
		placeholder: 'Busca estudio',
		maximumSelectionLength: 1,
        minimumInputLength: 3,
		ajax: {
			url: '/stevlab/catalogo/getEstudios',
			type: 'get',
			delay: '200',
			data: function(params){
				return{
					_token: CSRF_TOKEN,
					q: params.term,
				}
			},
			processResults: function (data) {
				// console.log(data);
				var listEstudios = [];
				data.forEach(function(element, index){
					let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion}`};
					listEstudios.push(est_data);
				});
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: listEstudios
				};
			}
		}
	});
	$('#selectEstudio').on('select2:select', function (e) {
		let data	= e.params.data.id;
        // let data = $(obj).parent().text().split('-')[0].trim();
		let clave = e.params.data.text.split('-')[0];
		// Revisame los analitos que ya esten asignados
		axios.post('/stevlab/catalogo/checkAnalitos', {
			_token: CSRF_TOKEN,
			data: data,
			clave: clave,
		})
		.then(function (response) {
			$('#analitos-list').empty();
			$('#analitos-checklist-list').empty();
			// Para settear los analitos
			response.data.analitos.forEach(function(element, index){
				// Reseteo campo select2 a null 
				$('#selectEstudio').val(null).trigger('change');
	
				let list = '';

				if(element.tipo_resultado === "referencia" || element.tipo_resultado === 'numerico'){
					list =`<li class="list-group-item" onclick="input('${element.clave}')"> 
									<span></span> <strong>${element.clave}</strong> - ${element.descripcion}
									<button  onclick='removeAnalito(this)' type="button" class="text-white float-right btn btn-xs btn-warning btn-icon delete">
										<i class="mdi mdi-delete"></i>
									</button>
								</li>`;
				}else{
					list =`<li class="list-group-item"> 
									<span></span> <strong>${element.clave}</strong> - ${element.descripcion}
									<button  onclick='removeAnalito(this)' type="button" class="text-white float-right btn btn-xs btn-warning btn-icon delete">
										<i class="mdi mdi-delete"></i>
									</button>
								</li>`;
				}
				
				$('#analitos-list').append(list);
			});

			if(response.data.formulas){
				response.data.formulas.forEach(function(formula, key){
					let listFormula =`
						<li class="list-group-item"> 
							${formula.formula}
							<button  onclick='removeTrueFormula(this, ${formula.id})' type="button" class="text-white float-right btn btn-xs btn-warning btn-icon delete">
								<i class="mdi mdi-delete"></i>
							</button>
						</li>
					`;
				$('#analitos-checklist-list').append(listFormula);
				})
			};

			
		})
		.catch(function (error) {
			console.log(error);
		});

		// Para adjuntar el id del estudio
		$('#estudioId').val(clave);
		$('#setAnalito').show();
		$('#calculadora').show();

	});
	
	
	var analito = $('#selectAnalito').select2({
		placeholder: 'Busca analito',
		maximumSelectionLength: 1,
		ajax: {
			url: 'getAnalito',
			type: 'get',
			delay: '200',
			data: function(params){
				return{
					_token: CSRF_TOKEN,
					q: params.term,
				}
			},
			processResults: function (data) {
				var listEstudios = [];
				data.forEach(function(element, index){
					let est_data = {id: element.id, text: `${element.clave} - ${element.descripcion} - tipo: ${element.tipo_resultado}`};
					
					listEstudios.push(est_data);
				});
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: listEstudios
				};
			}
		}
	});
	$('#selectAnalito').on('select2:select', function (e) {
		var data = e.params.data.id;

		const response = axios.post('/stevlab/catalogo/setAnalito', {
			data: data,
		})
		.then(res =>  {
			let list =`
					<li class="list-group-item" onclick="input('${res.data.clave}')"> 
						<span></span> <strong>${res.data.clave}</strong> - ${res.data.descripcion}
						<button onclick='removeThis(this)' type="button" class=" float-right btn btn-xs btn-danger btn-icon delete">
							<i class="mdi mdi-delete"></i>
						</button>
					</li>
				`;
			$('#analitos-list').append(list);

			$('#selectAnalito').val(null).trigger('change');

		}).catch((err) => {
			console.log(err);
		});
	});
	
});
