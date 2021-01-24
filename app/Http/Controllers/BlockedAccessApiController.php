<?php

namespace App\Http\Controllers;

use App\User_access_blocked;
use Illuminate\Http\Request;

class BlockedAccessApiController extends Controller
{
    //Función que registra  el acceso de un usuario a un x edificio
    public function store(Request $request)
    {
        
       $validacion = $this->validataData($request);
        //Si la validacion falla retornamos mensaje de error
        if ($validacion->fails()) {
            return response()->json([

                'Error' => $validacion->errors()->all(),
            ]);
        } else {
            //Si la validación es correcta realizamos el registro
            User_access_blocked::create($request->only("user_id", "building_id", "blocked"));

            if (response()->json()->status() === 200) {
                return 'Registro exitoso';
            }
        }

    }
    //Función que actualiza el estado del acceso a un edificio en específico
    public function update(Request $request, $id)
    {

    }
    private function validataData(Request $request){
        //Definimos las reglas de validación
        $rules = [
            'user_id'     => 'required',
            'building_id' => 'required',
            'blocked'     => 'required',
        ];
        //Definimos los mensajes de error
        $messages = [
            'blocked.required' => 'El campo blocked no puede estar vacío',
            'user_id.required' => 'El campo usuario no puede estar vacío',
            'building_id.required' => 'El campo edifio no puede estar vacío',
            
        ];
        //Realizamos la validación
        $validator = \Validator::make($request->all(), $rules,$messages);
        return $validator;
    }

}
