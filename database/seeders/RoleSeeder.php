<?php

namespace Database\Seeders;

use App\Models\Analito;
use App\Models\Area;
use App\Models\Doctores;
use App\Models\Empresas;
use App\Models\Estudio;
use App\Models\Laboratory;
use App\Models\Metodo;
use App\Models\Muestra;
use App\Models\Pacientes;
use App\Models\Profile;
use App\Models\Recipiente;
use App\Models\Subsidiary;
use App\Models\Tecnica;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Roles */
        $role1 = Role::create(['name' => 'Administrador',           'guard_name' => 'web']);
        $role2 = Role::create(['name' => 'Contador',                'guard_name' => 'web']);
        $role3 = Role::create(['name' => 'Quimico principal',       'guard_name' => 'web']);
        $role4 = Role::create(['name' => 'Quimico sucursal',        'guard_name' => 'web']);
        $role5 = Role::create(['name' => 'Quimico',                 'guard_name' => 'web']);
        $role6 = Role::create(['name' => 'Recepcion',               'guard_name' => 'web']);
        $role7 = Role::create(['name' => 'Doctor',                  'guard_name' => 'web']);
        $role8 = Role::create(['name' => 'Empresa',                 'guard_name' => 'web']);
        $role9 = Role::create(['name' => 'Imagenologia',            'guard_name' => 'web']);

        /* Permisos de las opciones menu */
        Permission::create(['name' => 'dashboard',              'description' => 'Ver pagina principal'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6 ]);
            Permission::create(['name' => 'ver_tiles',          'description' => 'Ver información relevante'])->syncRoles([$role1]);
            Permission::create(['name' => 'ver_listas',         'description' => 'Ver top estudios'])->syncRoles([$role1]);
            Permission::create(['name' => 'ver_graficas',       'description' => 'Ver estadisticas'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'recepcion',              'description' => 'Ver recepcion'])->syncRoles([$role1, $role2, $role3, $role4, $role6 ]);
            Permission::create(['name' => 'recepcion_nuevo',    'description' => 'Captura nuevo folio'])->syncRoles([$role1]);
            Permission::create(['name' => 'recepcion_editar',   'description' => 'Editar folio anterior'])->syncRoles([$role1]);
            Permission::create(['name' => 'recepcion_pendiente','description' => 'Revisar pendientes de pago'])->syncRoles([$role1]);
            Permission::create(['name' => 'cotizacion',         'description' => 'Cotizar estudios'])->syncRoles([$role1]);
            Permission::create(['name' => 'prefolio',           'description' => 'Revisar prefolios'])->syncRoles([$role1]);
        
        Permission::create(['name' => 'captura',                'description' => 'Ver captura de resultados'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6 ]);
            Permission::create(['name' => 'captura_resultados', 'description' => 'Capturar resultados'])->syncRoles([$role1, $role2, $role3]);
                Permission::create(['name' => 'valida_resultados',      'description' => 'Validar resultados'])->syncRoles([$role1, $role2, $role3]);
                Permission::create(['name' => 'invalida_resultados',    'description' => 'Invalida resultados'])->syncRoles([$role1, $role2, $role3]);
                Permission::create(['name' => 'entrega_resultados',     'description' => 'Entrega resultados'])->syncRoles([$role1, $role2, $role3]);
            Permission::create(['name' => 'captura_bloques',    'description' => 'Ver y capturar por bloques'])->syncRoles([$role1]);
            Permission::create(['name' => 'lista_trabajo',      'description' => 'Ver listas de trabajo'])->syncRoles([$role1]);
            Permission::create(['name' => 'importacion',        'description' => 'Ver importacion'])->syncRoles([$role1]);


        Permission::create(['name' => 'caja',                   'description' => 'Ver caja'])->syncRoles([$role1, $role2, $role3, $role4,$role5, $role6 ]);
            Permission::create(['name' => 'reporte_fechas',     'description' => 'Generar reporte general de cajas'])->syncRoles([$role1, $role2, $role3]);
            Permission::create(['name' => 'ver_cajas',          'description' => 'Ver cajas anteriores de usuario'])->syncRoles([$role1, $role2, $role3]);

        Permission::create(['name' => 'catalogo',               'description' => 'Ver menú catalogos'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6]);
            Permission::create(['name' => 'estudios',           'description' => 'Ver estudios'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_estudios',         'description' => 'Crear estudios'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_estudios',        'description' => 'Editar estudios'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_estudios',      'description' => 'Eliminar estudios'])->syncRoles([$role1]);
            Permission::create(['name' => 'areas',              'description' => 'Ver areas'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_areas',            'description' => 'Crear areas'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_areas',           'description' => 'Editar areas'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_areas',         'description' => 'Eliminar areas'])->syncRoles([$role1]);
            Permission::create(['name' => 'analitos',           'description' => 'Ver analitos'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_analitos',         'description' => 'Crear analitos'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_analitos',        'description' => 'Editar analitos']);
                Permission::create(['name' => 'organizar_analitos',     'description' => 'Organizar analitos'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_analitos',      'description' => 'Organizar analitos'])->syncRoles([$role1]);
            Permission::create(['name' => 'perfiles',           'description' => 'Ver perfiles'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_perfiles',         'description' => 'Crear perfiles'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_perfiles',        'description' => 'Editar perfiles'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_estudios_perfil', 'description' => 'Editar lista de estudios para perfiles'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_perfiles',      'description' => 'Eliminar perfiles'])->syncRoles([$role1]);
            Permission::create(['name' => 'pacientes',          'description' => 'Ver menu pacientes'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_pacientes',         'description' => 'Crear paciente'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_pacientes',         'description' => 'Editar paciente'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_pacientes',         'description' => 'Eliminar paciente'])->syncRoles([$role1]);
            Permission::create(['name' => 'listas',             'description' => 'Ver listas de precios'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_listas',           'description' => 'Crear listas de precios'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_listas',          'description' => 'Editar nombre lista'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_estudios_lista',  'description' => 'Editar lista de estudios para listas de precios'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_listas',        'description' => 'Eliminar lista de precio'])->syncRoles([$role1]);
            Permission::create(['name' => 'empresas',           'description' => 'Ver empresas'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_empresas',         'description' => 'Crear empresas'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_empresas',        'description' => 'Editar empresa'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_empresas',      'description' => 'Eliminar empresa'])->syncRoles([$role1]);
            Permission::create(['name' => 'doctores',           'description' => 'Ver doctores'])->syncRoles([$role1]);
                Permission::create(['name' => 'crear_doctores',         'description' => 'Crear doctores'])->syncRoles([$role1]);
                Permission::create(['name' => 'editar_doctores',        'description' => 'Editar doctores'])->syncRoles([$role1]);
                Permission::create(['name' => 'eliminar_doctores',      'description' => 'Eliminar doctores'])->syncRoles([$role1]);

        Permission::create(['name' => 'imagenologia',           'description' => 'Ver y capturar imagenologia'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role5, $role6, $role9]);
            Permission::create(['name' => 'captura_img',        'description' => 'Ver captura'])->syncRoles([$role1]);
            Permission::create(['name' => 'catalogo_img',       'description' => 'Ver catalogo'])->syncRoles([$role1]);
            Permission::create(['name' => 'areas_img',          'description' => 'Ver areas'])->syncRoles([$role1]);

        Permission::create(['name' => 'administracion',         'description' => 'Ver administracion'])->syncRoles([$role1, $role2]);
            Permission::create(['name' => 'sucursales',                 'description' => 'Ver sucursales'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'crear_sucursal',         'description' => 'Crear sucursal'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'editar_sucursal',        'description' => 'Editar sucursal'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'eliminar_sucursal',      'description' => 'Eliminar sucursal'])->syncRoles([$role1, $role2]);
            Permission::create(['name' => 'usuarios',                   'description' => 'Ver tabla usuarios'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'ver_lista_usuarios',     'description' => 'Ver lista de todos los usuarios'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'crear_usuarios',         'description' => 'Crear usuarios'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'editar_usuarios',        'description' => 'Editar usuarios'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'eliminar_usuarios',      'description' => 'Eliminar usuarios'])->syncRoles([$role1, $role2]);
            Permission::create(['name' => 'roles',                      'description' => 'Ver roles'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'asignar_rol',            'description' => 'Asignar rol'])->syncRoles([$role1, $role2]);
                Permission::create(['name' => 'asignar_permiso',        'description' => 'Asignar permisos'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'reportes',               'description' => 'Ver reportes'])->syncRoles([$role1, $role2, $role3, $role4]);
            Permission::create(['name' => 'arqueos',            'description' => 'Ver arqueos'])->syncRoles([$role1]);
            Permission::create(['name' => 'ventas',             'description' => 'Ver ventas'])->syncRoles([$role1]);

        Permission::create(['name' => 'historial',              'description' => 'Ver historial'])->syncRoles([$role1, $role2, $role3, $role4]);
            Permission::create(['name' => 'ver_historial',          'description' => 'Ver historial de pacientes'])->syncRoles([$role1]);

        Permission::create(['name' => 'almacen',                'description' => 'Ver almacen'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6]);
            Permission::create(['name' => 'inventarios',        'description' => 'Ver inventarios'])->syncRoles([$role1]);
            Permission::create(['name' => 'articulos',          'description' => 'Ver articulos'])->syncRoles([$role1]);
            Permission::create(['name' => 'solicitud_material', 'description' => 'Ver solicitudes de materiales'])->syncRoles([$role1]);
            Permission::create(['name' => 'movimientos',        'description' => 'Ver movimientos'])->syncRoles([$role1]);

        Permission::create(['name' => 'utilerias',              'description' => 'Ver utilerias'])->syncRoles([$role1, $role2, $role3, $role4]);
            Permission::create(['name' => 'multimembrete',              'description' => 'Ver membretes'])->syncRoles([$role1]);
            Permission::create(['name' => 'papeleria',                  'description' => 'Ver papeleria de reciclaje'])->syncRoles([$role1, $role2, $role3]);
            Permission::create(['name' => 'trazabilidad',               'description' => 'Ver trazabilidad'])->syncRoles([$role1, $role2, $role3]);
            Permission::create(['name' => 'informacion_personal',       'description' => 'Ver información personal'])->syncRoles([$role1]);
            Permission::create(['name' => 'fitosanitario',              'description' => 'Ver información del responsable sanitario'])->syncRoles([$role1]);
            Permission::create(['name' => 'seguridad',                  'description' => 'Ver seguridad'])->syncRoles([$role1]);
            Permission::create(['name' => 'maquila',                    'description' => 'Ver maquila'])->syncRoles([$role1]);
            Permission::create(['name' => 'data',                       'description' => 'Ver data (experimental, no asignar a usuario normal)'])->syncRoles([$role1, $role2]);

        //////////////////////////////////////////////////////
        //          DASHBOARD DOCTORES Y EMPRESAS           //
        //////////////////////////////////////////////////////
        // Permisos de los doctores
        Permission::create(['name'    => 'capturar prefolio',   'description' => 'Capturar prefolio'])->syncRoles([$role7, $role8]);

        /* Seeder */
        // $this->call(UsersSeeder::class);
    }
}
