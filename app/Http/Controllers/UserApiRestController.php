<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserApiRestController extends Controller
{
    //Funcion que retorna todos los usuarios registrados
    public function getUsers()
    {
        $users = User::get();
        return response()->json($users);
    }
    //Función para registrar un usuario
    public function store(Request $request)
    {
        //Validación de datos

        $validacion = $this->validateDataRequest($request);

        if ($validacion->fails()) {
            return response()->json([

                'Error' => $validacion->errors()->all(),
            ]);
        } else {
            //Verificamos si el usuario existe
            $user = User::where('rut', $request->rut)->count();
            if ($user != 0) {
                return 'El usuario ya existe en los registros';
            } else {
                //Creación de usuario
                User::create($request->only("name", "last_name", "rut", "email"));

                return 'El usuario fue creado';

            }

        }

    }
    //Funcion que retorna  un  usuario en especifico
    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }
    //Actualizar usuario
    public function update(Request $request, $id)
    {

        //buscamos el usuario que se quiere actualizar
        //Si el usuario no existe retornamos mensaje de error
        $user = User::find($id);

        if (empty($user)) {
            return 'El usuario no existe';
        } else {
            //Validación de datos
            $validacion = $this->validateDataRequest($request);
            if ($validacion->fails()) {
                return response()->json([

                    'Error' => $validacion->errors()->all(),
                ]);
            } else {
                $user->update($request->only("name", "last_name", "rut", "email"));

                return 'El usuario fue actualizado';

            }

        }

    }
    //Eliminar resgistro de usuario
    public function destroy($id)
    {
        $user = User::find($id);

        if (empty($user)) {
            return 'El usuario no existe';
        } else {
            $user->delete();
            if (response()->json()->status() === 200) {
                return 'El usuario fue eliminado';
            }
        }

    }
    //Validacion de formulario
    public function validateDataRequest(Request $request)
    {

        //Definimos las reglas de validación
        $rules = [
            'name'      => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'rut'       => 'required|string|max:12|',
            'email'     => 'required|string|email|max:255',

        ];
        //Definimos los mensajes de error
        $messages = [
            'name.required'      => 'El campo nombre no puede estar vacío',
            'last_name.required' => 'El campo apellido no puede estar vacío',
            'rut.required'       => 'El campo rut no puede estar vacío',
            'email.required'     => 'El campo email no puede estar vacío',

        ];

        $validator = \Validator::make($request->all(), $rules, $messages);
        //Si la validacion falla retornamos mensaje de error
        return $validator;

    }

}
