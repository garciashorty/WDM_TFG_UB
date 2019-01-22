<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('doctor', false)->paginate(15);

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

    public function edit(User $user)
    {
    	return view('admin/users/edit')
            ->with('user', $user);
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

    public function update(User $user)
    {
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

        return redirect()->route('admin_show_users', ['user' => $user]);
    }

    public function delete(User $user)
    {
        Query::where('user_id', $user->id)->delete();
        $user->delete();

        return redirect()->route('admin_users');
    }
}
