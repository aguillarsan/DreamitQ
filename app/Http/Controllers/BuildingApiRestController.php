<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;

class BuildingApiRestController extends Controller
{
    //Funcion que retorna todos los edificios registrados
    public function getBuildings()
    {
        $buildings = Building::get();
        return response()->json($buildings);
    }
    //Función para registrar un edificio
    public function store(Request $request)
    {
        //Compruebo si el registro ya existe
        $exists = Building::where('name', $request->name)->count();
        if ($exists != 0) {
            return 'El edificio ya fue creado';
        } else {
            //validamos los datos ingresados
            $validacion = $this->validateDataRequest($request);
            if ($validacion->fails()) {
                //Si los datos no son correctos retornamos mensajes de error
                return response()->json([

                    'Error' => $validacion->errors()->all(),
                ]);
            } else {
                //Si los datos son  correctos realizamos el registro
                Building::create($request->only("name"));

                if (response()->json()->status() === 200) {
                    return 'El edificio fue creado';
                }
            }

        }

    }
    //Funcion que retorna  un  edificio en especifico
    public function show($id)
    {
        $bilding = Building::find($id);
        return response()->json($bilding);
    }
    //Funcion para actualizar un edificio
    public function update(Request $request, $id)
    {
        //buscamos el edifico a actualizar
        $bilding = Building::find($id);

        if (empty($bilding)) {
            //si el arreglo esta vacio retornamos un mensaje
            return 'El edificio no existe';
        } else {
            //si el arreglo no esta vacío validamos los datos ingresados
            $validacion = $this->validateDataRequest($request);
            if ($validacion->fails()) {
                //Si los datos no son correctos retornamos mensajes de error
                return response()->json([

                    'Error' => $validacion->errors()->all(),
                ]);
            } else {
                $bilding->update($request->only("name"));

                if (response()->json()->status() === 200) {
                    return 'El edificio fue actualizado';
                }
            }

        }
    }

    //Eliminar resgistro de un edificio
    public function destroy($id)
    {
        $bilding = Building::find($id);

        if (empty($bilding)) {
            return 'El edificio no existe';
        } else {
            $bilding->delete();
        }

        if (response()->json()->status() === 200) {
            return 'El edificio fue eliminado';
        }
    }
    //Validación de los datos
    protected function validateDataRequest(Request $request)
    {
        //Definimos las reglas de validación
        $rules = [
            'name' => 'required',

        ];
        //Definimos los mensajes de error
        $messages = [
            'name.required' => 'El campo nombre no puede estar vacío',

        ];
        //Realizamos la validación
        $validator = \Validator::make($request->all(), $rules, $messages);
        return $validator;

    }
}
