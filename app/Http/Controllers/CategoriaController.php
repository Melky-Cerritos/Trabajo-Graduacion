<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    //

    //obtener todas las categorias
    public function index()
    {
        return view('admin.categorias');
    }

    //guardar una categoria
    public function store(Request $request)
    {
		//
    }

    //para actualizar una categoria
    public function update(Request $request)
    {
        //
    }

    public function distroy(Request $request)
    {
        //
    }

    public function getAll()
	{
        //
    }
}
