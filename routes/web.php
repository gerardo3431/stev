<?php

use App\Http\Controllers\AdministracionController;
use App\Http\Controllers\AlmacenController;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\EmpresasController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\MaquilaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\RecepcionsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Test de whatsapp
// Route::get('/sms-generate-test', [TestController::class, 'send_resultados'])->name('sms-generate-test');

// Rutas del registro de usuario y del registro de laboratorio
// Route::name('registro.')->prefix('registro')->group(function(){
//     Route::get('/index', [RegisterController::class, 'index'])->name('index');
//     Route::post('/store', [RegisterController::class, 'store'])->name('store');

//     Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function(){
//         Route::get('/regProfesion', [RegisterController::class, 'regProfesion'])->name('regProfesion');
//         Route::post('/regProfesion', [RegisterController::class, 'storeProfesion'])->name('regProfesion');
        
//         Route::get('/regSucursal', [RegisterController::class, 'regSucursal'])->name('regSucursal');
//         Route::post('/regSucursal', [RegisterController::class, 'storeSucursal'])->name('regSucursal');
//     });
// });
// Página principal
Route::get('robots.txt', function () {
    return response("User-agent: *\nDisallow: /", 200)
        ->header('Content-Type', 'text/plain');
});

Route::get('/', [IndexController::class, 'index']);

Route::get('/crip/{hash}', function($hash){
    echo Hash::make($hash);
});

Route::name('resultados.')->prefix('resultados')->group(function(){
    // Descargar resultados usuarios
    Route::get('/index', [IndexController::class, 'resultados' ])->name('index');
    // Ver lista de resultados
    Route::post('/search', [IndexController::class, 'show_resultados'])->name('search');
    // Visualizar resultados del folio
    Route::get('/search/resultado/{id}', [IndexController::class, 'get_resultado'])->name('show');

    // Validar estudios con check de validacion de resultados
    Route::get('/valida/{folio}/{estudio}', [IndexController::class, 'certifica_estudio'])->name('validate');
    
});

// Get de los estados y ciudades para el registro
Route::post('/getStates', [RegisterController::class, 'getStates'])->name('getStates');
Route::post('/getCity', [RegisterController::class, 'getCities'])->name('getCity');

// Todas las rutas (Dashboard) (Caja) (Recepción) (Catalogos) 
// Donde los usuarios esten autenticados
Route::middleware([ 
        'auth:sanctum', 
        config('jetstream.auth_session'), 
        'verified', 
        // 'role.redirect'
    ])->name('stevlab.')->prefix('stevlab')->group(function () {

    // Route::get('/symlink', function () {  
    //     // Artisan::call('storage:link'); 
    //     Artisan::call('cache:clear');
    //     Artisan::call('route:clear');
    // });

    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    // Chart de pacientes ultimos 7 dias
    Route::get('/recover-patients-week', [HomeController::class, 'generate_chart_patient'])->name('recover-patients-week');
    // Chart de solicitudes en el mes
    Route::get('/recover-solicitudes-anual', [HomeController::class, 'generate_chart_solicitudes'])->name('recover-solicitudes-anual');
    // Chart semanal
    Route::get('/recover-ingresos-week', [HomeController::class, 'generate_week_chart'])->name('recover-ingresos-week');
    // Chart periodico
    Route::post('/recover-chart', [HomeController::class, 'generate_chart'])->name('recover-chart');
    // Chart mensual
    Route::get('/recover-chart-month', [HomeController::class, 'generate_month_chart'])->name('recover-chart-month');


    // Recepcion
    Route::name('recepcion.')->prefix('recepcion')->group(function(){
        // Recepcion - nuevo
        Route::get('/index', [RecepcionsController::class, 'index'])->name('index');
        // Buscar estudio
        Route::get('/get_estudios_recepcion', [CatalogoController::class, 'get_all_estudios'])->name('get_estudios_recepcion');
        // Obtener todos los folios
        Route::post('/get-folios', [CatalogoController::class, 'get_folios_recepcion'])->name('get-folios');
        
        // Guardar registro
        Route::post('/guardar', [RecepcionsController::class, 'guardar'])->name('guardar'); 
        // Guarda lista de estudios
        Route::post('/guardarEstudios', [RecepcionsController::class, 'guardar_estudios'])->name('guardarEstudios');
        // Regresa los formatos de existir
        Route::get('/formatos-pdf', [RecepcionsController::class, 'create_formatos_pdf'])->name('formatos-pdf');
        // Guardamos el cobro en caja
        Route::post('/genera-ingreso', [CajaController::class, 'pay'])->name('genera-ingreso');
        // Genera recibo de acuerdo al folio y pago
        Route::get('/make-note', [CajaController::class, 'make_note'])->name('make-note');
        // Route::post('/genera-etiqueta', [RecepcionsController::class, 'genera_etiquetas_laboratorio'])->name('genera-etiqueta');
        Route::get('/genera-etiqueta', [RecepcionsController::class, 'genera_etiquetas_laboratorio'])->name('genera-etiqueta');

        //Recepcion - Editar index
        Route::get('/editar', [RecepcionsController::class, 'recepcion_editar_index'])->name('editar');
        //Recepcion - Editar solicitud
        Route::get('/recepcion-editar/{id}', [RecepcionsController::class, 'recepcion_editar'])->name('recepcion-editar');
        //Recepcion - Editar solicitud - Actualiazar
        Route::post('/recepcion_actualizar/{id}', [RecepcionsController::class, 'recepcion_actualizar'])->name('recepcion_actualizar');
        // Recepcion - editar solicitud -  recupera estudios del folio
        Route::post('/recover-estudios-edit', [RecepcionsController::class, 'recover_estudios_edit'])->name('recover-estudios-edit');
        // Recepcion checkar precio del estudio
        // Route::post('/check-precio-estudio-edit', [RecepcionsController::class, 'recepcion_estudio_edit_precio'])->name('check-precio-estudio-edit');
        // Recepcion checkar precio del perfil
        Route::post('/check-precio-perfil-edit', [RecepcionsController::class, 'recepcion_perfil_edit_precio'])->name('check-precio-perfil-edit');
        // Recepcion eliminar estudio del perfil
        Route::post('/remove-edit-estudio-folio',[RecepcionsController::class, 'recepcion_estudio_edit_remove'])->name('remove-edit-estudio-folio');
        
        // Recepcion eliminar perfil del perfil
        Route::post('/remove-edit-perfil-folio',[RecepcionsController::class, 'recepcion_perfil_edit_remove'])->name('remove-edit-perfil-folio');
        // Recepcion eliminarimagenologia
        Route::post('/remove-edit-img-folio', [RecepcionsController::class, 'recepcion_img_edit_remove'])->name('remove-edit-img-folio');
        
        // Recepcion guardar edicion de folio
        Route::post('/guardar-edit-folio', [RecepcionsController::class, 'recepcion_folio_update'])->name('guardar-edit-folio');
        // Recepcion guardar nueva lista de la edición
        Route::post('/updateEstudiosFolio', [RecepcionsController::class, 'recepcion_folio_update_estudios'])->name('updateEstudiosFolio');
        // Recepcion genera nuevo ticket actualizado
        Route::post('/genera-ingreso-edit', [CajaController::class, 'pay_edit'])->name('genera-ingreso-edit');
        // Recepcion - Reimprimir etiquetas
        // Route::get('/recepcion-re-etiquetas/{id}', [RecepcionsController::class, 'recepcion_re_etiquetas'])->name('recepcion-re-etiquetas');
        // Recepcion - reimprime ultimo ticket generado
        Route::get('/recepcion-re-ticket/{id}', [RecepcionsController::class, 'recepcion_re_ticket'])->name('recepcion-re-ticket');
        // Recepcion - eliminar folio
        Route::get('/recepcion-delete-folio/{id}', [RecepcionsController::class, 'recepcion_delete_folio'])->name('recepcion-delete-folio');

        // Recepcion revisar pagos pendientes
        Route::get('/pendientes', [RecepcionsController::class, 'pendientes_index'])->name('pendientes');
        // Recepcion pendientes pagos
        Route::post('/consulta-folios-pendientes', [RecepcionsController::class, 'pendientes_consulta_folios'])->name('consulta-folios-pendientes');

        //Catalogo - pacientes.guardar - wtf son dos rutas similares, revisar si se pueden reemplazar con la ruta original de catalogo
        Route::post('/paciente_guardar', [RecepcionsController::class, 'paciente_guardar'])->name('paciente_guardar');
        //Catalogo - doctores.guardar - wtf son dos rutas similares, revisar si se pueden reemplazar con la ruta original de catalogo
        Route::post('/doctores_guardar', [RecepcionsController::class, 'doctores_guardar'])->name('doctores_guardar');

        //Recepcion - cotizacion index
        Route::get('/cotizacion', [CotizacionController::class, 'cotizacion_index'])->name('cotizacion');
        //Genera cotización pdf
        Route::post('/cotizar-estudio', [CotizacionController::class, 'cotizacion_pdf'])->name('cotizar-estudio'); 
        // Genera cotización whatsapp
        Route::post('/cotizar-estudio-whatsapp', [CotizacionController::class, 'cotizacion_whatsapp'])->name('cotizar-estudio-whatsapp');
        
        // Recepcion prefolios index
        Route::get('/prefolio', [RecepcionsController::class, 'prefolio_index'])->name('prefolio');
        // Recepcion prefolios get-all-folios
        Route::post('/get-prefolios', [RecepcionsController::class,'prefolio_get_lista'])->name('get-prefolios');
        // Recepcion get prefolio 
        Route::post('/recover-prefolios', [RecepcionsController::class, 'prefolio_recover_data'])->name('recover-prefolios');
        // Send data to recepcion>nuevo
        Route::post('/send-prefolio-recepcion', [RecepcionsController::class, 'prefolio_send_recepcion'])->name('send-prefolio-recepcion');
        // Revisa desde recepcion nuevo la data enviada desde prefolio
        Route::post('/checkDataPrefolio', [RecepcionsController::class, 'check_prefolio_recepcion'])->name('checkDataPrefolio');

        
        // Busca listas de trabajo
        Route::post('/getJobList', [RecepcionsController::class, 'make_reporte_trabajo'])->name('getJobList');

        // Delivery o entrega de resultados
        // Route::get('/delivery', [RecepcionsController::class, 'delivery_index'])->name('delivery');
        // Get data del folio
        Route::get('/get-results-preview', [RecepcionsController::class, 'get_results_preview'])->name('get-results-preview');

        Route::post('/preparing-results', [RecepcionsController::class, 'get_file_complete'])->name('preparing-results');
    

       
        // Importacion del archivo
        Route::post('/import', [RecepcionsController::class, 'file_import'])->name('import');
        // Guarda datos
        Route::post('/store-data', [RecepcionsController::class, 'store_dato'])->name('store-data');
        // Buscar estudios para el folio
        // Route::post('/recover-estudios-imp', [RecepcionsController::class, 'import_estudios'])->name('recover-estudios-imp');
    });

    Route::name('captura.')->prefix('captura')->group(function(){
        // Recepcion buscar data del folio
        Route::post('/get-folios-recepcions', [RecepcionsController::class, 'get_recepcions_folio'])->name('get-folios-recepcions');
        // Return observacion del estudio
        Route::post('/check-observacion-estudio', [RecepcionsController::class, 'get_observacion_folio'])->name('check-observacion-estudio');
        // Recepcion obten delta check del analito
        Route::post('/delta-check', [HistorialController::class, 'delta_check'])->name('delta-check');
        
        // Captura por bloque
        Route::get('/captura-block', [RecepcionsController::class, 'recepcion_captura_block_index'])->name('captura-block');
        // Consulta bloque
        Route::post('/consulta-estudios-block', [RecepcionsController::class, 'recepcion_block_consulta'])->name('consulta-estudios-block');

        // Recepcion -  captura de resultados
        Route::get('/captura', [RecepcionsController::class, 'recepcion_captura_index'])->name('captura');
        // Consulta que estudios estan para anexar segun la busqueda
        Route::post('/consulta-estudios', [RecepcionsController::class, 'recepcion_captura_consulta'])->name('consulta-estudios');
        // Recover estudios
        Route::get('/recover-estudios', [RecepcionsController::class, 'recover_estudios'])->name('recover-estudios');
        // Verifica datos de estudios
        Route::post('/verify-result', [RecepcionsController::class, 'verifica_resultados'])->name('verify-result');
        // Valida los resultados
        Route::post('/validar-estudios', [RecepcionsController::class, 'valida_resultados'])->name('validar-estudios');
        // Invalidad resultados
        Route::post('/invalidar-estudios', [RecepcionsController::class, 'invalida_resultados'])->name('invalidar-estudios');
        Route::post('/invalidar-estudios-img', [RecepcionsController::class, 'invalida_imagenologia'])->name('invalidar-estudios-img');
        // Genera pdf de la sección
        Route::post('/genera-documento-resultados', [RecepcionsController::class, 'genera_documento_resultados'])->name('genera-documento-resultados');
        // Genera todos los resultados de un folio
        Route::post('/generate-all-result', [RecepcionsController::class, 'genera_resultados_todos'])->name('generate-all-result');
        // Genera un documento excel sobre los resultados
        Route::post('/export-to-excel', [RecepcionsController::class, 'export_resultados_todos'])->name('export-to-excel');
        // Recoge correos del folio
        Route::post('/obtainMails', [RecepcionsController::class, 'obtain_mails'])->name('obtainMails');
        // Mail - Genera y envia correo
        Route::post('/mailer-generate-all-result', [RecepcionsController::class, 'mailer_genera_resultados_todos'])->name('mailer-generate-all-result');
        // Mail - Genera y envia a todos correo
        Route::post('/correo-send-multiple', [RecepcionsController::class, 'send_multiple_correo'])->name('correo-send-multiple');
        // Genera y abre el link de whatsapp
        Route::post('/send-message-link', [RecepcionsController::class, 'send_sms_direct'])->name('send-message-link');
        // Envia whatsapp al usuario destino -whatsapp api by twilio
        // Route::post('/sms-generate-all-result', [SendResultController::class, 'send_resultados_sms'])->name('sms-generate-all-result');
        // Busca y trae los valores referenciales correctos por paciente
        Route::post('/verifica-valores-referenciales', [RecepcionsController::class, 'recover_valores_referenciales'])->name('verifica-valores-referenciales');
        // Guarda los resultados
        Route::post('/store-resultados-estudios', [RecepcionsController::class, 'store_resultados_estudios'])->name('store-resultados-estudios');
        // Guarda la imagen
        Route::post('/store-imagen-estudios', [RecepcionsController::class, 'upload_img_resultados'])->name('/store-imagen-estudios');
        Route::post('/store-zip-estudios', [RecepcionsController::class, 'upload_zip_file'])->name('/store-zip-estudios');
        // Verifica si el paciente completo el pago
        Route::post('/verifica-pago-paciente', [RecepcionsController::class, 'verify_pending_pay'])->name('verifica-pago-paciente');

        // Maquila archivo
        Route::post('/maquila-file', [RecepcionsController::class, 'maquila_archivo'])->name('maquila-file');
        Route::post('/maquila-file-img', [RecepcionsController::class, 'maquila_file_img'])->name('maquila-file-img');
        // Delete maquila
        Route::get('/deleteMaquila', [RecepcionsController::class, 'delete_maquila_file'])->name('deleteMaquila');
        
        // Especial para imagenologia
        Route::post('/store-resultados-imagenologia', [RecepcionsController::class, 'store_resultados_imagenelogia'])->name('store-resultados-imagenologia');
        // 
        Route::post('/store-imagen-imagenologia', [RecepcionsController::class, 'upload_img_imagenologia'])->name('store-imagen-imagenologia');
        // 
        Route::post('/validar-estudios-imagenologia', [RecepcionsController::class, 'valida_imagenologia'])->name('validar-estudios-imagenologia');
        // 
        Route::post('/genera-resultados-imagenologia', [RecepcionsController::class, 'generate_report_img_single'])->name('genera-resultados-imagenologia');
        // 
        Route::post('/generate-all-result-imagenologia', [RecepcionsController::class, 'generate_report_img_all'])->name('generate-all-result-imagenologia');
        // 
        Route::post('/mailer-generate-imagenologia', [RecepcionsController::class, 'send_report_imagen'])->name('mailer-generate-imagenologia');
        // 
        Route::post('/get-paciente-folio-img', [RecepcionsController::class, 'generate_sms_whatsapp'])->name('get-paciente-folio-img');


        // Recepcion lista de trabajo
        Route::get('/listas', [RecepcionsController::class, 'lista_trabajo_index'])->name('listas');

         // Importacion de resultados de archivos generados por interfaz
        Route::get('/importacion', [RecepcionsController::class, 'importacion_index'])->name('importacion');
    });

    // Caja
    Route::name('caja.')->prefix('caja')->group(function(){
        // Get para edicion de pago
        Route::post('/calcula-pendiente-pago', [CajaController::class, 'get_pendiente_pago'])->name('calcula-pendiente-pago');
        // Get para pagos pendientes para recepcion pendientes
        Route::post('/calcula-pendiente-pago-total', [CajaController::class, 'get_pago_pendiente'])->name('calcula-pendiente-pago-total');
        // Caja index
        Route::get('/index', [CajaController::class, 'index'])->name('index');
        // Caja guardar monto
        Route::post('/store', [CajaController::class, 'store'])->name('store');
        // Caja cerrar caja y guardar
        Route::get('/cerrar_caja/{id}', [CajaController::class, 'close_caja'])->name('cerrar_caja');

        // Genera retiro de caja
        Route::post('/store-retiro', [CajaController::class, 'store_retiro'])->name('store-retiro');
        // Genera egreso de caja
        Route::post('/egreso-caja', [CajaController::class, 'caja_egreso'])->name('egreso-caja');

        // Caja genera reporte 
        Route::post('/genera-reporte-dia', [CajaController::class, 'genera_reporte_dia'])->name('genera-reporte-dia');
        // Caja genera arqueo pacientes de la caja
        Route::post('/genera-reporte-dia-pacientes', [CajaController::class, 'genera_reporte_arqueo_pacientes'])->name('genera-reporte-dia-pacientes');
        // Caja genera reporte rapido
        Route::post('/genera-reporte-rapido', [CajaController::class, 'genera_reporte_rapido'])->name('genera-reporte-rapido');
        // Caja genera reporte por rango de fechas
        Route::post('/genera-reporte-rango', [CajaController::class, 'genera_reporte_rango'])->name('genera-reporte-rango');
    });

    // Catalogos
    Route::name('catalogo.')->prefix('catalogo')->group(function(){ 
        // Verificacion de valores
        // Catalogo - verifica clave estudio
        Route::post('/verifyKeyEstudio', [CatalogoController::class, 'catalogo_verify_key_estudio'])->name('verifyKeyEstudio');
        // Catalogo - Verifica clave perfil
        Route::post('/verifyKeyPerfil', [CatalogoController::class, 'catalogo_verify_key_profile'])->name('verifyKeyPerfil');
        // Catalogo - verifica clave analito
        Route::post('/verifyKeyAnalito', [CatalogoController::class, 'catalogo_verify_key_analito'])->name('verifyKeyAnalito');
        // Catalogo - verifica clave doctor
        Route::post('/verifyKeyDoctor', [CatalogoController::class, 'catalogo_verify_key_doctor'])->name('verifyKeyDoctor');
        // Catalogo - verifica clave empresa
        Route::post('/verifyKeyEmpresa', [CatalogoController::class, 'catalogo_verify_key_empresa'])->name('verifyKeyEmpresa');
        // Catalogo - verifica clave Pictures
        Route::post('/verifyKeyPicture', [CatalogoController::class, 'catalogo_verify_key_picture'])->name('verifyKeyPicture');

        // Catalogo -analito->formulas - verifica si el estudio puede tener formulas, separando imagenologia
        Route::post('/verify-disponibilidad', [CatalogoController::class, 'catalogo_verify_disponibilidad'])->name('verify-disponibilidad');

        // Catalogo trae todos los estudios
        Route::get('/getOnlyEstudios', [CatalogoController::class, 'get_only_estudios'])->name('getOnlyEstudios');
        
        Route::get('/getAllEstudios', [CatalogoController::class, 'catalogo_get_estudios'])->name('getAllEstudios');
        // Catalogo trae todos los analitos
        Route::get('/getAnalitos', [CatalogoController::class, 'catalogo_get_analitos'])->name('getAnalitos');
        // Catalogo trae todos los pacientes
        // Route::get('/getCatalogoPacientes', [CatalogoController::class, 'catalogo_get_pacientes'])->name('/getCatalogoPacientes');
        // Catalogo trae informaciona cerca del analito
        Route::post('/getKeyAnalito', [CatalogoController::class, 'catalogo_verify_key_analito_show'])->name('getKeyAnalito');
        // Catalogo obtener todos los articulos
        Route::get('/getArticles', [CatalogoController::class, 'catalogo_get_articles'])->name('getArticles');
        // Catalogo obtener articulo
        Route::get('/get-article', [CatalogoController::class, 'catalogo_get_data_article'])->name('get-article');
        // Catalogo obtener pacientes para datatables jquery
        Route::post('/get-patients', [CatalogoController::class, 'get_pacientes_table'])->name('get-patients');


        // Catalogo -analito - settear analito
        Route::post('/setAnalito', [CatalogoController::class, 'set_analito'])->name('setAnalito');
        // Catalogo - analito - eliminar analito
        Route::get('/deleteAnalito', [CatalogoController::class, 'delete_analito'])->name('deleteAnalito');
            
        // Get pacientes select2
        // Get estudios select2
        // Route::get('/get-estudio', [CatalogoController::class, 'get_estudio'])->name('get-estudio');
        // Get perfiles select2
        // Route::get('/get-profile', [CatalogoController::class, 'get_profile'])->name('get-profile');
        // Busqueda para estudios por select2 -analitos-precios-recepcion (creo) - trae estudios y analitos
        Route::get('/getEstudios', [CatalogoController::class, 'get_estudios'])->name('getEstudios'); 
        // Trae data de la empresa si el paciente tiene asignado empresa
        Route::post('/get_empresa_paciente', [CatalogoController::class, 'get_empresa_by_patient'])->name('get_empresa_paciente');
        // Busqueda para paciente por folio
        Route::post('/get-paciente-folio', [CatalogoController::class, 'get_paciente_folio'])->name('get-paciente-folio');
        // Trae todoos los estudios
        Route::get('/get-lista-estudios', [CatalogoController::class, 'get_lista_estudios_all'])->name('get-lista-estudios');
        // Busqueda para recepcion por id
        Route::post('/checkEstudio', [CatalogoController::class, 'get_estudios_recepcion'])->name('checkEstudio');
        // Busqueda para recepcion perfil por id
        Route::post('/checkPerfil', [CatalogoController::class, 'get_perfiles_recepcion'])->name('checkPerfil');
        // Busqueda para recepcion imagenologia por id
        Route::post('/checkImagen', [CatalogoController::class, 'get_imagenologia_recepcion'])->name('checkImagen');
        // Busqueda para catalogo estudio por clave
        Route::post('/get-estudio-clave', [CatalogoController::class, 'get_estudios_clave'])->name('get-estudio-clave');
        // Busqueda para analito por clave
        Route::post('/get-analito-clave', [CatalogoController::class, 'get_analito_clave'])->name('get-analito-clave');
        // Busqueda para valores referenciales por clave de analito
        Route::post('/get-valores-referenciales-clave', [CatalogoController::class, 'get_valores_referenciales_clave'])->name('get-valores-referenciales-clave');
        // Busqueda para la lista de precio especificada
        Route::get('/getPrecio', [CatalogoController::class, 'get_precio'])->name('getPrecio');
        // Busqueda para listas de precios
        Route::get('/get-precios', [CatalogoController::class, 'get_lista_precios'])->name('get-precios');
        // Busqueda para las listas de precios
        Route::post('/get-lista-precio', [CatalogoController::class, 'get_lista_empresa'])->name('get-lista-precio');
        // Obten la existencia de la clave seleccionada en el catalogo de estudios
        Route::post('/verifyStudie', [CatalogoController::class, 'verify_key_studie'])->name('verifyStudie');
         //Catalogo - doctor.buscar
        Route::get('/getMedicos', [DoctoresController::class, 'get_medicos'])->name('getMedicos');  
        // Catalogo - buscar todos los doctores
        Route::get('/getAllMedicos', [DoctoresController::class, 'get_medicos_all'])->name('getAllMedicos');
        // Catalogo - obtener imagenologia
        Route::get('/getPicture', [PictureController::class, 'get_picture_id'])->name('getPicture');
        // 
        Route::get('/getFolios', [CatalogoController::class, 'get_folio_clave'])->name('getFolios');

        // Catalogo - estudios.index
        Route::get('/estudios', [CatalogoController::class, 'catalogo_estudio_index'])->name('estudios');
        // Catalogo - estudios-store
        Route::post('/store-studio', [CatalogoController::class, 'catalogo_estudio_store'])->name('store-studio');
        // Catalogo - estudios-update
        Route::post('/update-estudio', [CatalogoController::class, 'catalogo_estudio_update'])->name('update-estudio');
        // Catallgo - estudios-delete
        Route::post('/delete-estudio-clave', [CatalogoController::class, 'catalogo_estudio_original_delete'])->name('delete-estudio-clave');

        // Catalogo - analitos.index
        Route::get('/analitos', [CatalogoController::class, 'catalogo_analito_index'])->name('analitos');
        // Catalogo - analitos-store
        Route::post('/store-analito', [CatalogoController::class, 'catalogo_analito_store'])->name('store-analito');
        // Catalogo - agrega imagen
        Route::post('/store-imagen-analito', [CatalogoController::class, 'catalogo_store_imagen_referencia'])->name('store-imagen-analito');
        // Catalogo - store-referencias
        Route::post('/store-referencia', [CatalogoController::class, 'catalogo_referencia_store'])->name('store-referencia');
        // Eliminar referencia
        Route::post('/eliminaReferencia', [CatalogoController::class, 'catalogo_referencia_delete'])->name('eliminaReferencia');
        
        // Checa analitos y los asigna 
        Route::post('/checkAnalitos', [CatalogoController::class, 'get_check_analitos'])->name('checkAnalitos');
        // Catalogo  - analito - buscar analito
        Route::get('/getAnalito', [CatalogoController::class, 'get_analitos'])->name('getAnalito');
        // Catalogo - elimina analito que viene con estudio
        Route::post('/eliminaAnalito', [CatalogoController::class, 'delete_analito_estudio'])->name('eliminaAnalito');
        // Catalogo - asignar analitos a estudios
        Route::post('/asignAnalitos', [CatalogoController::class, 'asign_estudio_analitos'])->name('asignAnalitos');
        // Catalogo - editar analitos
        Route::post('/update-analito', [CatalogoController::class, 'catalogo_update_analitos'])->name('update-analito');
        // Catalogo - actualizar imagen
        // Route::post('/update-imagen-analito', [CatalogoController::class, 'catalogo_update_imagen_referencia'])->name('update-imagen-analito');
        
        // Calculadora de formulas -guardar
        Route::post('/save-formulas', [CatalogoController::class, 'save_formulas_estudios'])->name('save-formulas');
        // Elimina formula
        Route::post('/elimina-true-formula', [CatalogoController::class, 'delete_true_formula'])->name('elimina-true-formula');

        // Catalogo - areas.index - Demás areas
        Route::get('/areas', [CatalogoController::class, 'catalogo_area_index'])->name('areas');
        // Catalogo - areas-store
        Route::post('/store-area', [CatalogoController::class, 'catalogo_area_store'])->name('store-area');
        // Catalogo - metodos-store
        Route::post('/store-metodo', [CatalogoController::class, 'catalogo_metodo_store'])->name('store-metodo');
        // Catalogo - recipientes-store
        Route::post('/store-recipiente', [CatalogoController::class, 'catalogo_recipiente_store'])->name('store-recipiente');
        // Catalogo - muestras-store
        Route::post('/store-muestra', [CatalogoController::class, 'catalogo_muestra_store'])->name('store-muestra');
        // Catalogo - tecnicas-store
        Route::post('/store-tecnica', [CatalogoController::class, 'catalogo_tecnica_store'])->name('store-tecnica');
        // Catalogo - delete lo que sea de areas
        Route::get('/delete-component/{zona}/{id}', [CatalogoController::class, 'catalogo_delete_component'])->name('delete-component');
        
        // Catalogo - precios.index
        Route::get('/precios', [CatalogoController::class, 'catalogo_precio_index'])->name('precios');
        // Carga archivo de excel con listas de precios
        Route::post('/upload-list-precios', [CatalogoController::class, 'catalogo_upload_list_precios'])->name('upload-list-precios');
        // Catalogo  - precios-store -Guardar lista
        Route::post('/store-list', [CatalogoController::class, 'catalogo_store_list'])->name('store-list');
        // Catalogo - listas_has_precios
        Route::post("/save-lista", [CatalogoController::class, 'catalogo_list_save'])->name("save-lista");
        // Catalogo - actualizar nombre lista
        Route::post('/update-lista-name', [CatalogoController::class, 'catalogo_list_update_name'])->name('update-lista-name');
        // Catalogo - eliminar lista
        Route::get('/delete-lista/{id}', [CatalogoController::class, 'catalogo_delete_lista'])->name('delete-lista');
        // Catalogo - lista elimna estudio
        Route::post('/elimina-estudio-lista', [CatalogoController::class, 'catalogo_estudio_delete'])->name('elimina-estudio-lista');
        // Catalogo - trae todos los elementos con precios
        Route::post('/get-lista', [CatalogoController::class, 'catalogo_get_lista'])->name('get-lista');

        //////////////////// Catalogo - estudios_has_precios
        // Route::post('/store-precio-estudios', [CatalogoController::class, 'catalogo_precios_estudios'])->name('store-precio-estudios');
        // // Catalogo - profiles has precios
        // Route::post('/store-precio-profiles', [CatalogoController::class, 'catalogo_precios_profiles'])->name('store-precio-profiles');
        // // Catalogo - rellenar tabla para estudios
        // Route::post('/get-estudios-asignados', [CatalogoController::class, 'catalogo_tabla_precios_estudios'])->name('get-estudios-asignados');
        // // Catalogo - rellenar tabla para perfiles
        // Route::post('/get-profiles-asignados', [CatalogoController::class, 'catalogo_tabla_precios_profiles'])->name('get-profiles-asignados');
        // // Eliminar estudios de lista de precios
        // Route::post('/eliminar-estudios-asignados', [CatalogoController::class, 'catalogo_precios_elimina_estudio'])->name('eliminar-estudios-asignados');
        // // Eliminar perfiles de la lista de precios
        // Route::post('/eliminar-profiles-asignados', [CatalogoController::class, 'catalogo_precios_elimina_profile'])->name('eliminar-profiles-asignados');
        // // Settear seleccion para agregar
        // Route::post('/set-estudios-for-precios', [CatalogoController::class, 'catalogo_set_position'])->name('set-estudios-for-precios');
        
        //Catalogo - doctores.index 
        Route::get('/doctores', [DoctoresController::class, 'doctores_index'])->name('doctores');
        //Catalogo - doctores.guardar
        Route::post('/doctores_guardar', [DoctoresController::class, 'doctores_guardar'])->name('doctores_guardar');
        //Catalogo - doctor.editar
        Route::post('/getDoctor', [DoctoresController::class, 'get_doctor_edit'])->name('getDoctor');
        //Catalogo - doctor.actualizar
        Route::post('/doctor_actualizar', [DoctoresController::class, 'doctor_actualizar'])->name('doctor_actualizar');
        //Catalogo - doctor.elimiar
        Route::get('/doctor_eliminar/{id}', [DoctoresController::class, 'doctor_eliminar'])->name('doctor_eliminar');
        // Catalogo - doctor crear usuario
        Route::get('/upload-doctor/{id}', [DoctoresController::class, 'doctor_user_create'])->name('upload-doctor');
        // Catalogo - doctor crear usuario
        Route::post('/doctor-upload-user', [DoctoresController::class, 'doctor_user_store'])->name('doctor-upload-user');
        // Catalogo - doctor editar usuario
        Route::get('/edit-user-doctor/{id}', [DoctoresController::class, 'user_doctor_edit'])->name('edit-user-doctor');
        // Catalogo - doctor update usuario
        Route::post('/doctor-update-user', [DoctoresController::class, 'user_doctor_update'])->name('doctor-update-user');
        
        // Perfiles - perfiles.index
        Route::get('/perfiles', [CatalogoController::class, 'catalogo_perfiles_index'])->name('perfiles');
        // pERFILES - perfiles.store-perfil
        Route::post('/store-perfil', [CatalogoController::class, 'catalogo_store_perfil'])->name('store-perfil');
        // Perfiles - perfiles.associate-studies
        Route::post('/associate-studies', [CatalogoController::class, 'catalogo_perfil_to_estudios'])->name('associate-studies');
        // Recuperar perfil 
        Route::post('/getPerfilesEstudios', [CatalogoController::class, 'catalogo_recuperar_datos_perfil_estudios'])->name('getPerfilesEstudios');
        //Recuperar estudios de perfil
        Route::post('/getEstudiosPerfiles', [CatalogoController::class, 'catalogo_recupera_estudios_to_perfil'])->name('getEstudiosPerfiles');
        // Actualizar cambios en el perfil de estuio
        Route::post('/update-perfil', [CatalogoController::class, 'catalogo_actualizar_datos_perfil_estudios'])->name('update-perfil');
        // Eliminar estudios de perfil
        Route::post('/eliminar-estudio-perfil', [CatalogoController::class, 'catalogo_elimina_estudio_perfil'])->name('eliminar-estudio-perfil');
         // Delete perfile
        Route::get('/delete-profile/{id}', [CatalogoController::class, 'catalogo_perfil_delete'])->name('delete-profile');
        
        //Catalogo - pacientes.index
        Route::get('/pacientes',[PacienteController::class, 'paciente_index'])->name('pacientes');
        //Catalogo - pacientes.guardar
        Route::post('/paciente_guardar', [PacienteController::class, 'paciente_guardar'])->name('paciente_guardar');
        //Catalogo - pacientes.eliminar
        Route::get('/paciente-eliminar/{id}', [PacienteController::class, 'paciente_eliminar'])->name('paciente-eliminar');
        //Catalogo - pacientes.editar
        Route::post('/getPaciente', [PacienteController::class, 'get_paciente_edit'])->name('getPaciente');
        //Catalogo - paciente.actualizar
        Route::post('/paciente_actualizar', [PacienteController::class, 'paciente_actualizar'])->name('paciente_actualizar');
        //Catalogo - pacientes.buscar
        Route::get('/getPacientes', [PacienteController::class, 'get_pacientes'])->name('getPacientes'); 
        Route::get('/getPacientesGeneral', [PacienteController::class, 'get_index_search_patient'])->name('getPacientesGeneral'); 


        //Catalogo - empresas.index
        Route::get('/empresas',[EmpresasController::class, 'empresa_index'])->name('empresas');
        //Catalogo - empresas.guardar
        Route::post('/empresa_guardar', [EmpresasController::class, 'empresa_guardar'])->name('empresa_guardar');
        //Catalogo - empresa.eliminar
        Route::get('/empresa-eliminar/{id}', [EmpresasController::class, 'empresa_eliminar'])->name('empresa-eliminar');
        //Catalogo - empresa.editar
        Route::post('/getEmpresa', [EmpresasController::class, 'get_empresa_edit'])->name('getEmpresa');
        //Catalogo - empresa.actualizar
        Route::post('/empresa_actualizar', [EmpresasController::class, 'empresa_actualizar'])->name('empresa_actualizar');
        //Catalogo - empresa - buscar empresas
        Route::get('/getEmpresas', [EmpresasController::class, 'get_empresas'])->name('getEmpresas'); 
        // Catalogo - empresa - generar usuario
        Route::get('/upload-empresa/{id}', [EmpresasController::class, 'index_create_user'])->name('upload-empresa');
        // Catalogo - empresa - genera usuario
        Route::post('/empresa-upload-user', [EmpresasController::class, 'store_user_factory'])->name('empresa-upload-user');
        // Catalogo - empresa - editar usuario
        Route::get('/edit-user-empresa/{id}', [EmpresasController::class, 'user_empresa_update'])->name('edit-user-empresa');
        // Catalogo - empresa - editar y guardar usuario
        Route::post('/empresa-update-user', [EmpresasController::class, 'user_empresa_store_update'])->name('empresa-update-user');

        // Utils
        // Catalogo- pacientes.guardar desde recepcion
        Route::post('/paciente-guardar-recepcion', [PacienteController::class, 'store_patient_recepcion'])->name('paciente-guardar-recepcion');
        // Catalogo- doctores.guardar desde recepcion
        Route::post('/doctor-guardar-recepcion', [DoctoresController::class, 'store_doctor_recepcion'])->name('doctor-guardar-recepcion');
        // Catalogo - empresas.guardar desde recepcion
        Route::post('/empresa-guardar-recepcion', [EmpresasController::class, 'store_empresa_recepcion'])->name('empresa-guardar-recepcion');

        // Imagenologia
        
        // Imagenologia guardar
        Route::post('/store-imagenologia', [PictureController::class, 'store_imagenologia'])->name('store-imagenologia');
        // Imagenologia actualiza
        Route::post('/update-imagenologia', [PictureController::class, 'update_imagenologia'])->name('update-imagenologia');
        
        // Imagenologia - store areas
        Route::post('/store-area-img', [PictureController::class, 'store_areas'])->name('store-area-img');

    });

    Route::name('imagenologia.')->prefix('imagenologia')->group(function(){
        // Index captura
        Route::get('/captura', [PictureController::class, 'captura_index'])->name('captura');
        // Buscar estudios de imagenologia
        Route::post('/search-pictures', [PictureController::class, 'get_pictures'])->name('search-pictures');
        // Recupera informacion
        // Route::post('recover-estudios', [PictureController::class, 'get_folio'])->name('recover-estudios');
        // Imagenologia
        Route::get('/imagenologia', [PictureController::class, 'index'])->name('imagenologia');

        // Imagenologia - areas
        Route::get('/areas-imagenologia', [PictureController::class, 'areas_index'])->name('areas-imagenologia');
    });

    // Reportes
    Route::name('reportes.')->prefix('reportes')->group(function(){
        // Obtener doctores, empresas y hasta pacientes del arqueo de ventas
        Route::post('/getData', [ReporteController::class, 'get_data_ventas'])->name('getData');

        // Arqueos
        Route::get('/arqueo', [ReporteController::class, 'arqueo_index'])->name('arqueo');
        // make-reporte
        Route::post('/make-reporte', [ReporteController::class, 'make_reporte'])->name('make-reporte');
        // ventas
        // Arqueos
        Route::get('/ventas', [ReporteController::class, 'ventas_index'])->name('ventas');

    });
    
    Route::name('historial.')->prefix('historial')->group(function(){
        // Pacientes historial
        Route::get('/pacientes', [HistorialController::class, 'historial_index'])->name('pacientes');
        // Retorna busquea
        Route::post('/search-folios', [HistorialController::class, 'historial_search'])->name('search-folios');
        Route::post('/search-folios-general', [HistorialController::class, 'historial_search_index'])->name('search-folios-general');
        // Retorna historial del paciente
        Route::get('/generate-report', [HistorialController::class, 'historial_generate'])->name('generate-report');
    });

    Route::name('almacen.')->prefix('almacen')->group(function(){
        // Getter
        Route::get('/getInventories', [AlmacenController::class, 'get_inventories'])->name('getInventories');
        // Get de solicitudes
        Route::get('/getRequests', [AlmacenController::class, 'get_requests'])->name('getRequests');
        // get Solicitu
        Route::get('/getRecepcions', [AlmacenController::class, 'get_recepcions'])->name('getRecepcions');

        // Get solicitud si existe
        // Route::get('/getSolicitudList', [AlmacenController::class, 'get_article_ubicacion'])->name('getSolicitudList');
        // Get de movimientos
        Route::get('/getMovementsRequests', [AlmacenController::class, 'get_movement_request'])->name('getMovementsRequests');


        // getArticlesList
        Route::get('/getArticlesList', [AlmacenController::class, 'get_article_ubicacion'])->name('getArticlesList');
        // Inventario
        Route::get('/inventario', [AlmacenController::class, 'inventario_index'])->name('inventario');
        // Inventario guardar dato
        Route::post('/inventario-store', [AlmacenController::class, 'inventario_store'])->name('inventario-store');

        // // Almacen
        // Route::get('/almacenes', [AlmacenController::class, 'almacen_index'])->name('almacenes');
        // // Store-Almacen
        // Route::post('/store-almacen', [AlmacenController::class, 'almacen_store'])->name('store-almacen');

        // Articulos
        Route::get('/articulos', [AlmacenController::class, 'articulos_index'])->name('articulos');
        // Store articulos
        Route::post('/articulos-store', [AlmacenController::class, 'articulos_store'])->name('articulos-store');

        // Solicitudes de articulos de inventarios
        Route::get('/solicitudes', [AlmacenController::class, 'solicitudes_index'])->name('solicitudes');
        // Store solicitudes
        Route::post('/request-store', [AlmacenController::class, 'solicitudes_store'])->name('request-store');

        // Movimeintos 
        Route::get('/movimientos', [AlmacenController::class, 'movimientos_index'])->name('movimientos');

    });

    Route::name('administracion.')->prefix('administracion')->group(function(){
        // Get usuarios x sucursal
        Route::post('/get_users', [AdministracionController::class, 'get_users_sucursal'])->name('get_users');
        
        // Utils
        // Cambiar de sucursal
        Route::post('/cambiar-sucursal', [AdministracionController::class, 'administracion_change_sucursal'])->name('cambiar-sucursal');
        
        // Administracion usuarios
        Route::get('/usuarios', [AdministracionController::class, 'usuarios_index'])->name('usuarios');
        Route::post('/store-user', [AdministracionController::class, 'usuario_store'])->name('store-user');
        // Administracion editar sucursales
        Route::get('/edit-user-subsidiary/{usuario}', [AdministracionController::class, 'usuario_edit_subsidiary'])->name('edit-user-subsidiary');
        Route::post('/update-user-subsidiaries', [AdministracionController::class, 'update_user_subsidiarie'])->name('update-user-subsidiaries');
        // Roles
        Route::get('/edit-user-rol/{usuario}', [AdministracionController::class, 'usuario_edit_rol'])->name('edit-user-rol');
        Route::post('/update-user-roles', [AdministracionController::class, 'usuario_update_rol'])->name('update-user-roles');
        // Administracion editar usuarios
        Route::get('/edit-permission/{usuario}', [AdministracionController::class, 'usuario_edit_permission'])->name('edit-permission');
        Route::post('/update-permissions', [AdministracionController::class, 'usuario_update_permissions'])->name('update-permissions');
        // Administracion editar datos del usuarios
        Route::get('/edit-user-info/{usuario}', [AdministracionController::class, 'usuario_edit_info'])->name('edit-user-info');
        Route::post('/update-user-info', [AdministracionController::class, 'usuario_edit_update'])->name('update-user-info');


        // Administracion index sucursal
        Route::get('/sucursales', [AdministracionController::class, 'administracion_index'])->name('sucursales');
        // Adminsitracion store sucursal
        Route::post('/store-sucursal', [AdministracionController::class, 'administracion_store_sucursal'])->name('store-sucursal');
        
    });

    Route::name('utils.')->prefix('utils')->group(function(){
        // Query commentarios
        Route::get('/query-comments', [LaboratoryController::class, 'get_comments'])->name('query-comments');
        // Checkear estado de inventario:
        Route::get('/checkInventario', [LaboratoryController::class, 'check_inventario'])->name('checkInventario');
        // Datos del usuario
        Route::get('/user', [PersonalController::class, 'user_index'])->name('user');
        // Update usuario
        Route::post('/user-update', [PersonalController::class, 'user_update'])->name('user-update');

        // Datos del responsable sanitario e imagenologia
        Route::get('/fitosanitario', [PersonalController::class, 'fitosanitario_index'])->name('fitosanitario');
        // Update usuario
        Route::post('/fitosanitario-update', [PersonalController::class, 'fitosanitario_update'])->name('fitosanitario-update');
        // fitosanitario-img-update
        Route::post('/fitosanitario-img-update', [PersonalController::class, 'fitosanitario_img_update'])->name('fitosanitario-img-update');

        // Contraseña
        Route::get('/segurity', [PersonalController::class, 'segurity_index'])->name('segurity');

        // Datos de papeleria - membretes
        // Route::middleware('optimizeImages')->group(function () {
        // });
        Route::get('/papeleria', [PersonalController::class, 'papeleria_index'])->name('papeleria');
        Route::post('/update-membrete', [LaboratoryController::class, 'update_membrete'])->name('update-membrete');
        Route::post('/update-membrete-secondary', [LaboratoryController::class, 'update_membrete_secondary'])->name('update-membrete-secondary');
        Route::post('/update-membrete-terciary', [LaboratoryController::class, 'update_membrete_terciary'])->name('update-membrete-terciary');
        Route::post('/update-membrete-img', [LaboratoryController::class, 'update_membrete_img'])->name('update-membrete-img');
        Route::post('/update-recibo-pago', [LaboratoryController::class, 'update_recibo_pago'])->name('update-recibo-pago');
        Route::post('/update-logotipo', [LaboratoryController::class, 'update_logotipo'])->name('update-logotipo');
        Route::post('/update-cache', [LaboratoryController::class, 'update_cache'])->name('update-cache');
        Route::post('/zelda-stg', [LaboratoryController::class,'link_storage'])->name('zelda-stg');
        


        // Trashed o papeleria de reciclaje
        Route::get('/trashed', [AdministracionController::class, 'trashed_index'])->name('trashed');
        // Restaura folios
        Route::get('/trash-restore-folio/{id}', [AdministracionController::class, 'trash_restore_folio'])->name('trash-restore-folio');
        // Restaurar paciente
        Route::get('/trash-restore-patient/{id}', [AdministracionController::class, 'trash_restore_patient'])->name('trash-restore-patient');
        // Restaurar doctores
        Route::get('/trash-restore-doctor/{id}', [AdministracionController::class, 'trash_restore_doctor'])->name('trash-restore-doctor');
        // Restaurar estudios
        Route::get('/trash-restore-estudio/{id}', [AdministracionController::class, 'trash_restore_estudio'])->name('trash-restore-estudio');
        // Restaurar analito 
        Route::get('/trash-restore-analito/{id}', [AdministracionController::class, 'trash_restore_analito'])->name('trash-restore-analito');
        // Restaurar lsita de precios
        Route::get('/trash-restore-lista/{id}', [AdministracionController::class, 'trash_restore_precio'])->name('trash-restore-lista');
        // trash-restore-analito

         // Historial
        Route::get('/trazabilidad', [AdministracionController::class, 'index_trazabilidad'])->name('trazabilidad');

        // Get trazabilidad
        Route::get('/consulta-trazabilidad', [AdministracionController::class, 'get_trazabilidad'])->name('consulta-trazabilidad');



        // Maquilar
        Route::get('/maquila', [MaquilaController::class, 'index'])->name('maquila');
        Route::post('/load-file', [MaquilaController::class, 'upload_and_change_file'])->name('load-file');

        // Transferir data de tabla recepcions has areas  -> recepcions has estudios
        Route::get('/data', [LaboratoryController::class, 'data_index'])->name('data');
        Route::get('/patch-data-areas', [LaboratoryController::class, 'data_patch'])->name('patch-data-areas');

    
    });

    // Todas las rutas para los doctores

    Route::name('doctor.')->prefix('doctor')->group(function(){
        // Getters 
        Route::get('/get-lista-estudios', [CatalogoController::class, 'getListFromDoctor'])->name('get-lista-estudios');
        // Get pacientes
        Route::get('/getPacientes', [CatalogoController::class, 'getPacientesDoctor'])->name('getPacientes');
        // Get resultados del prefolio si existe
        Route::post('/verifyPrefolio', [DoctoresController::class, 'extract_result_prefolio'])->name('verifyPrefolio');
        // Mostrar pacientes con relacion a la busqueda 
        Route::post('/showPacientes', [DoctoresController::class, 'showPacientesDoctor'])->name('showPacientes');

        // 
        // Index del doctor
        Route::get('/dashboard', [DoctoresController::class, 'index'])->name('dashboard');
        // Index de captura de prefolio
        Route::get('/prefolio', [DoctoresController::class, 'prefolio_index'])->name('prefolio');
        // Guardar prefolio
        Route::post('/store-prefolio', [DoctoresController::class, 'prefolio_store'])->name('store-prefolio');
        // Guardar file
        Route::post('/store-file-prefolio', [DoctoresController::class, 'prefolio_store_file'])->name('store-file-prefolio');
        // Enviar prefolio por whatsapp
        Route::post('/send-prefolio-whatsapp', [DoctoresController::class, 'send_prefolio_msg'])->name('send-prefolio-whatsapp');
        
    });

    // Todas las rutas para las empresas
    Route::name('empresa.')->prefix('empresa')->group(function(){
        // Dashboard
        Route::get('/dashboard', [EmpresasController::class, 'index'])->name('dashboard');
        // Prefolio index
        Route::get('/prefolio', [EmpresasController::class, 'prefolio_index'])->name('prefolio');
        // Guardar prefolio
        Route::post('/store-prefolio', [EmpresasController::class, 'prefolio_store'])->name('store-prefolio');
        // Guardar file
        Route::post('/store-file-prefolio', [EmpresasController::class, 'prefolio_store_file'])->name('store-file-prefolio');
        // Enviar prefolio por whatsapp
        Route::post('/send-prefolio-whatsapp', [EmpresasController::class, 'send_prefolio_msg'])->name('send-prefolio-whatsapp');
    });

    // Route::name('maquila.')->prefix('maquila')->group(function(){
    //     Route::get('index', [MaquilaController::class, 'index'])->name('index');
    // });
});

