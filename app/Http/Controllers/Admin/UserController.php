<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('doctor', false)->get();

        $title = 'Listado de usuarios';

        return view('/admin/users/index')
            ->with('users', $users)
            ->with('title', $title);
    }

    public function show(User $user)
    {
        return view('/admin/users/show')
            ->with('user', $user);
    }

    public function create()
    {
    	return view('/admin/users/create');
    }

    public function edit($id)
    {
    	return "Editando usuario: {$id}";
    }

    public function store()
    {
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

        User::create([
            'name' => request()->name,
            'surname' => request()->surname,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'phone' => request()->phone,
        ]);

        return redirect()->route('admin_users');
    }
}
