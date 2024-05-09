<?php
    namespace App\Imports;

    use App\Models\Lista;
    use App\Models\Precio;
    use Maatwebsite\Excel\Concerns\ToModel;
    use Maatwebsite\Excel\Concerns\WithHeadingRow;

    class ListaImport implements ToModel, WithHeadingRow
    {
        protected $contenedor_id;

        public function __construct($contenedor_id)
        {
            $this->contenedor_id = $contenedor_id;
        }

        public function model(array $row)
        {
            // Elimina los valores vacíos del array
            $filteredRow = array_filter($row);

            // Si todos los valores son vacíos, no importa la fila
            if (count($filteredRow) === 0) {
                return null;
            }else{
                $contenedor = Precio::find($this->contenedor_id);
                $busqueda = $contenedor->lista()->where('listas.clave', '=', $row['clave'])->first();

                if(! $busqueda){
                    $lista = new Lista([
                        'clave'         => $row['clave'],
                        'descripcion'   => $row['descripcion'],
                        'tipo'          => $row['tipo_estudio_perfil_imagenologia'],
                        'precio'        => $row['precio'],
                    ]);

                    $contenedor->lista()->save($lista);
                    return $lista;
                }

            }
            
        }
    }
