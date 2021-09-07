<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use App\Models\City;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ClientController extends Controller
{
    public function index(Request $request){
        //$ciudades = City::orderBy('name')->pluck('name','id');
        //dd($ciudades);
        $ciudades = City::all();
        return view('client.index', array('ciudades' => $ciudades));
    }

    public function ajax(Request $request){
        $input = request()->all();
        //dd($input);
        if(isset($input['search']) ) {
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $client = DB::table('client as cl')
                ->select('cl.id', 'cl.cod', 'cl.name', 'ci.name as cities.name')
                ->join('cities as ci', 'ci.id', '=', 'cl.cities_id')
                ->where('cl.name', 'LIKE', '%'.$input['search'].'%')
                ->orWhere('ci.name', 'LIKE', '%'.$input['search'].'%');

            $all = $client->count();
            $resultado = $client->skip($pagina)->limit($all)->take($limite)->get();
            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;
            //dd($data);
        }else{
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $client = Client::orderBy('id', 'ASC')->with('cities');
            $all = $client->count();
            //dd($all);
            $resultado = $client->skip($pagina)->limit($all)->take($limite)->get();

            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;
            //dd($data);
        }
        return response()->json($data);
    }

    public function new(){
        $ciudades = City::select('id', 'name')->get();
        return view('client.new',array('ciudades'=> $ciudades));
    }


    public function update(Request $request)
    {
        $client = Client::find($request->request->all()['id']);
        $client->cod = $request->request->all()['codigo'];
        $client->name = $request->request->all()['nombre'];
        $client->cities_id = $request->request->all()['city'];
        $client->update();

        return response()->json($client);
    }

    public function create(Request $request){
        $datos = $request->all();
        $code = $datos['codigo'];
        $name = $datos['nombre'];
        $city_id = $datos['city'];
        $client = new Client();
        $client->cod = $code;
        $client->name = $name;
        $client->cities_id = $city_id;
        $client->save();
        if ( $client->save() ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Cliente creado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema con la creacion del cliente');
        }
        return response()->json($data, 200);
    }


    public function delete(Request $request){
        $datos = $request->all();
        $id = $datos['id'];
        $client = Client::find($id)->delete();
        if ( $client ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Cliente Eliminado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema al eliminar el cliente');
        }
        return response()->json($data, 200);
    }
    public function importador(Request $request){
        //dd($request->file('file'));
        $path = Storage::putFile('documentos', $request->file('file'));
        Excel::import(new ClientsImport(), $path);
        Storage::delete($path);
        return redirect('/')->with('success', 'Importado!');

    }

    public function exportador(Request $request){
        return Excel::download(new ClientsExport(), 'export-clientes.csv');

    }
}
