<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Models\Imagen;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('admin.inventario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            //creando y llenando el objeto orden
            $inv = new Inventario();
            $inv->descripcion = $request->descripcion;
            $inv->precio = $request->precio;
            $inv->stock = $request->stock;
            $inv->modelo = $request->modelo;
            $inv->idproducto = $request->producto["id"];
            $inv->idmarca = $request->marca["id"];
            //guardamos en inventario
            $inv->save();
            //obtenemos el las imagenes que vienen del frontend
            $imagenes = $request->imagenes;
            if (sizeof($imagenes) > 0) {
                //recorriendo los elementos para guardar en la tabla de imagenes
                foreach ($imagenes as $key => $img) {
                    //creamos el objeto de tipo Imagen
                    $imagen = new Imagen();
                    //llenamos el objeto
                    $imagen->nombre = $img['nombre'];
                    $imagen->idinventario = $img['inventario']['id'];
                    //guardamos en la tabla imagenes
                    $imagen->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    
    public function destroy($id)
    {
        //
    }

    public function getAllOrSearch(Request $request){
        try{
            $search = $request->search;
        if ($search == '') {
            $prods = Inventario::join('productos', 'inventario.idproducto', 'productos.id')
                ->join('categorias', 'productos.idcategoria', 'categorias.id')
                ->join('marcas', 'inventario.idmarca', 'marcas.id')
                ->select(
                    'inventario.id',
                    'inventario.descripcion',
                    'inventario.precio',
                    'inventario.stock',
                    'inventario.modelo',
                    'inventario.idproducto',
                    'inventario.idmarca',
                    'productos.nombre as producto',
                    'productos.idcategoria',
                    'categorias.nombre as categoria',
                    'marcas.nombre as marca'
                )->orderBy('inventario.id', 'DESC')->get();
            return $prods;
        } else {
            $prods = Inventario::join('productos', 'inventario.idproducto', 'productos.id')
                ->join('categorias', 'productos.idcategoria', 'categorias.id')
                ->join('marcas', 'inventario.idmarca', 'marcas.id')
                ->select(
                    'inventario.id',
                    'inventario.descripcion',
                    'inventario.precio',
                    'inventario.stock',
                    'inventario.modelo',
                    'inventario.idproducto',
                    'inventario.idmarca',
                    'productos.nombre as producto',
                    'productos.idcategoria',
                    'categorias.nombre as categoria',
                    'marcas.nombre as marca'
                )
                ->where('productos.nombre', 'like', '%' . $search . '%')
                ->orderBy('inventario.id', 'DESC')->get();
            return $prods;
        }

        }catch(\Exception $r){
            return $r->getMessage();
        }
        

    }


}
