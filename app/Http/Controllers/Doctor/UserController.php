<?php

namespace App\Http\Controllers\Doctor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->doctor) {
            $users = User::where('doctor', false)->paginate(15);

            $title = 'Listado de usuarios';

            return view('/doctor/users/index')
                ->with('users', $users)
                ->with('title', $title);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function show(User $user)
    {
        if (auth()->user()->doctor) {
            return view('/doctor/users/show')
                ->with('user', $user);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function create()
    {
        if (auth()->user()->doctor) {
            return view('/doctor/users/create');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function edit(User $user)
    {
        if (auth()->user()->doctor) {
            return view('doctor/users/edit')
                ->with('user', $user);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function store()
    {
        if (auth()->user()->doctor) {
            //dd(request()->name);
            $data = request()->validate([
                'name' => 'required',
                'surname' => 'required',
                'phone' => 'required',
                'email' => ['required','email', 'unique:users,email'],
                'password' => ['required','between:6,14'],
            ], [
                'name.required' => 'Debe introducir un nombre',
                'surname.required' => 'Debe introducir un apellido',
                'phone.required' => 'Debe introducir un teléfono',
                'email.required' => 'Debe introducir un email',
                'email.email' => 'Debe introducir un email válido',
                'email.unique' => 'El email introducido ya existe',
                'password.required' => 'Debe introducir una contraseña',
                'password.between' => 'La contraseña debe tener entre 6 y 14 carácteres'
            ]);

            //dd('hola que tal');

            User::create([
                'name' => request()->name,
                'surname' => request()->surname,
                'email' => request()->email,
                'password' => bcrypt(request()->password),
                'phone' => request()->phone,
            ]);

            return redirect()->route('doctor_users');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function update(User $user)
    {
        if (auth()->user()->doctor) {
            $data = request()->validate([
                'name' => 'required',
                'surname' => 'required',
                'phone' => 'required',
                'email' => '',
                'password' => ['nullable', 'between:6,14'],
            ], [
                'name.required' => 'Debe introducir un nombre',
                'surname.required' => 'Debe introducir un apellido',
                'phone.required' => 'Debe introducir un teléfono',
                //'email.required' => 'Debe introducir un email',
                //'email.email' => 'Debe introducir un email válido',
                //'email.unique' => 'El email introducido ya existe',
                //'password.required' => 'Debe introducir una contraseña',
                'password.between' => 'La contraseña debe tener entre 6 y 14 carácteres'
            ]);

            $data['email'] = $user->email;

            if ($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = bcrypt($data['password']);
            }

            if ($data['email'] != null) {
                unset($data['email']);
            }

            $user->update($data);

            return redirect()->route('doctor_show_users', ['user' => $user]);
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }

    public function delete(User $user)
    {
        if (auth()->user()->doctor) {
            $user->delete();

            return redirect()->route('doctor_users');
        } else {
            return response()->view('errors/403', [], Response::HTTP_FORBIDDEN); // ERROR 403
        }
    }
}
