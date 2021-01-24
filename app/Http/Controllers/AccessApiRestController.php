<?php

namespace App\Http\Controllers;

use App\Access_register;
use App\User_access_blocked;
use Illuminate\Http\Request;

class AccessApiRestController extends Controller
{
    //Función que retorna el registro de accesos
    public function getAllRegisterAccess()
    {
        $allAccess = Access_register::get();
        return response()->json($allAccess);
    }

    //Registro del acceso al edificio
    public function registerAccess(Request $request)
    {
        //Buscamos en la tabla User_access_blocked por el id del usuario y el id del edifio
        $validacion = $this->validateDataRequest($request);
        if ($validacion->fails()) {
            //Si los datos no son correctos retornamos mensajes de error
            return response()->json([

                'Error' => $validacion->errors()->all(),
            ]);
        } else {
            $user_state_access = User_access_blocked::where('user_id', $request->user_id)->where('building_id', $request->building_id)->with('building')->select('blocked', 'building_id')->get();

            foreach ($user_state_access as $blocked_status) {
                //Si la variable blocked es verdadera significara que el tiene blockeado el acceso al edificio
                if ($blocked_status->blocked == true) {
                    return 'El usuario tiene bloqueado el acceso al edificio' . ' ' . $blocked_status->building->name;
                } else {
                    //Si la variable blocked es falsa significara que el tiene blockeado el acceso al edificio
                    if ($blocked_status->blocked == false) {
                        
                        Access_register::create($request->only("user_id", "building_id"));

                        if (response()->json()->status() === 200) {
                            return 'Acceso registrado';
                        }
                    }
                }
            }
        }

    }

    //Validación de los datos
    protected function validateDataRequest(Request $request)
    {
        //Definimos las reglas de validación
        $rules = [
            'user_id'     => 'required',
            'building_id' => 'required',

        ];
        //Definimos los mensajes de error
        $messages = [
            'user_id.required'     => 'El campo usario no puede estar vacío',
            'building_id.required' => 'El campo edificio no puede estar vacío',

        ];
        //Realizamos la validación
        $validator = \Validator::make($request->all(), $rules, $messages);
        return $validator;

    }
}
