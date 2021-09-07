<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(Request $request){
        return view('city.index');
    }

    public function ajax(Request $request){
        $input = request()->all();
        //dd($input);
        if(isset($input['search']) ) {
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $city = City::where('id', 'LIKE', $input['search']);
            $all = $city->count();
            $resultado = $city->skip($pagina)->limit($all)->take($limite)->get();
            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;
        }else{
            //dd($input);
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $city = City::orderBy('id', 'ASC');
            $all = $city->count();
            //dd($all);
            $resultado = $city->skip($pagina)->limit($all)->take($limite)->get();
            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;
        }
        return response()->json($data);
    }

    public function new(){
        return view('city.new');
    }

    public function show($id, Request $request){
        $cpcordon = Cpcordon::find($id);
        return view('cpcordon/show', array('cpcordon'=> $cpcordon) );
    }
    public function update(Request $request)
    {
        //dd($request->request->all()['id']);
        $city = City::find($request->request->all()['id']);
        $city->code = $request->request->all()['codigo'];
        $city->name = $request->request->all()['nombre'];
        $city->update();
        return response()->json($city);
    }

    public function create(Request $request){
        $datos = $request->all();
        $code = $datos['codigo'];
        $name = $datos['nombre'];
        $city = new City();
        $city->code = $code;
        $city->name = $name;
        $city->save();
        if ( $city->save() ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Ciudad creado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema con la creacion de la ciudad');
        }
        return response()->json($data, 200);
    }


    public function delete(Request $request){
        $datos = $request->all();
        $id = $datos['id'];
        $city = City::find($id)->delete();
        if ( $city ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Ciudad Eliminado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema al eliminar la ciudad');
        }
        return response()->json($data, 200);
    }
}
