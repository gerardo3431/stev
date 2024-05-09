'use strict'
// function send_whatsapp(obj){
//     let membrete = 'si';
//     let estudios = [];
//     let folio = $('#appendComponente').find('.asignEstudio').find('.folioEstudio').val();
//     $('#appendComponente').find('.asignEstudio').each(function(key, value){
//         let clave_estudio = $(this).find('.claveEstudio').text().trim();

//         let analitos=[];

//         $(this).find('.listDato').each(function(llave, valor){
//             let id = $(this).find('.idAnalito').val();

//             analitos.push({
//                 id: id,
//             });
//         });
//         estudios.push({
//             clave: clave_estudio,
//             analitos,

//         });
//     });

//     sendsmsajax(membrete, estudios, folio);
// }


// function sendsmsajax(membrete, estudios, folio){
//     const respuesta = axios.post('/stevlab/sms-generate-all-result',{
//         membrete: membrete,
//         folio: folio,
//         estudios: estudios,
//     }).then(function(response){
//         console.log(response);
//         if(response['data']['msj'] == 'success'){
//             const Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-end',
//                 showConfirmButton: false,
//                 timer: 3000,
//                 timerProgressBar: true,
//             });
            
//             Toast.fire({
//             icon: 'success',
//             title: 'Correo enviado'
//             });

//             // // Reload
//             setTimeout(function(){
//                 window.location.reload();
//             }, 1500);

//         }else if(response['data']['msj'] == 'error'){
//             const Toast = Swal.mixin({
//                 toast: true,
//                 position: 'top-end',
//                 showConfirmButton: false,
//                 timer: 3000,
//                 timerProgressBar: true,
//             });
            
//             Toast.fire({
//             icon: 'error',
//             title: 'Error al enviar correo'
//             });
//         }
//         // window.open(response['data']['pdf']);
//     }).catch(function(error){
//         console.log(error);
//     });
// }