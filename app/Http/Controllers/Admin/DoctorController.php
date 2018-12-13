<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('doctor', true)->get();

        $title = 'Listado de doctores';

        return view('admin/doctors/index')
            ->with('doctors', $doctors)
            ->with('title', $title);
    }

    public function show(User $doctor)
    {
    	return view('/admin/doctors/show')
            ->with('doctor', $doctor);
    }

    public function create()
    {
    	return view('/admin/doctors/create');
    }

    public function edit($id)
    {
    	return "Editando doctor: {$id}";
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

        $user = User::create([
            'name' => request()->name,
            'surname' => request()->surname,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'phone' => request()->phone,
            'doctor' => true,
        ]);

    	return redirect()->route('admin_doctors');
    }
}