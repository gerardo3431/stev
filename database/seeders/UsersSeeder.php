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
use App\Models\Precio;
use App\Models\Profile;
use App\Models\Recipiente;
use App\Models\Subsidiary;
use App\Models\Tecnica;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         //Crea usuario
        User::create([
            'name'      => "Laboratorio Biotec",
            'username'  => 'adminbiotec',
            'email'     => "admin@gmail.com",
            'status'    => 'activo',
            'password'  => bcrypt('$tevl4bBiotec')
        ])->assignRole('Quimico jefe');

        // Crea laboratorio
        Laboratory::create([
            'nombre'            =>'BIOTEC',
            'razon_social'      =>'BIOTEC',
            'ciudad'            =>'Jalpa de Méndez',
            'estado'            =>'Tabasco',
            'pais'              =>'Mexico',
            'cp'                => '86200',
            'email'             =>'docbook@gmail.com',
            'telefono'          =>'+9141180434',
            'rfc'               => null,
            'logotipo'          =>'logos_laboratorios/logo_biotec.png',
            'membrete'          =>'membrete_laboratorios/membrete_biotec.png',
        ]);

        // Crea sucursal
        Subsidiary::create([
            'sucursal'=>'BIOTEC - Matriz',
            'direccion'=> 'C. Francisco Indalecio Madero 6, La Guadalupe, 86200 Jalpa de Méndez, Tab.',
            'telefono' => '9141180434'
        ]);

        DB::table('user_has_laboratory')
            ->insert([
                'user_id'       =>1,
                'laboratory_id' =>1,
            ]);

        //Crea relación entre sucursales y laboratorios 
        DB::table('subsidiaries_has_laboratories')
            ->insert([
                'laboratorio_id'    => '1',
                'sucursal_id'       => '1',
            ]);

        // Crea relación entre usuarios, sucursales y el laboratorio.
        DB::table('users_has_laboratories')
            ->insert([
                'user_id'           =>'1',
                'laboratory_id'     =>'1',
                'subsidiary_id'     =>'1',
                'estatus'           =>'activa'

            ]);

        // Usuarios tienen sucursales
        Db::table('subsidiary_has_user')
            ->insert([
                'subsidiary_id' => 1,
                'user_id'       => 1,
            ]);

        
        
    }
}