<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function __invoke()
    {
        //return 'Bienvenido a la Pagina Principal';
        return view('admin.index');
    }
	
	public function index()
    {
        return view('admin.index');
    }
}
