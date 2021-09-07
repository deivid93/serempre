<?php

namespace App\Http\Controllers;

use app\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;


class UserController extends Controller
{
    public function index(Request $request){

        return view('user.index');
    }

    public function ajax(Request $request){
        $input = request()->all();
        //dd($input);
        if(isset($input['search']) ) {
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $users = DB::table('users as u')
                ->where('u.name', 'LIKE', '%'.$input['search'].'%');

            $all = $users->count();
            $resultado = $users->skip($pagina)->limit($all)->take($limite)->get();
            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;
            //dd($data);
        }else{
            $pagina = $input['offset'];
            $limite = $input['limit'];
            $users = User::orderBy('id', 'ASC');
            $all = $users->count();
            //dd($all);
            $resultado = $users->skip($pagina)->limit($all)->take($limite)->get();

            $data["total"] = $all;
            $data["totalNotFiltered"] = $all;
            $data["rows"] = $resultado;

        }
        return response()->json($data);
    }

    public function new(){
        $roles = DB::table('roles as r')->select('r.id', 'r.name')->get();
        return view('user.new', ['roles' => $roles]);
    }


    public function update(Request $request)
    {
        $user = User::find($request->request->all()['id']);
        $user->name = $request->request->all()['name'];
        $user->email = $request->request->all()['email'];
        $user->photo = $request->request->all()['photo'];
        $user->update();

        return response()->json($user);
    }

    public function create(Request $request){
        $datos = $request->all();
        $user = new User();
        $user->name = $datos['name'];
        $user->email = $datos['email'];
        $user->password = Hash::make($datos['password']);
        $user->role_id = $datos['role'];
        $user->save();
        if ( $user->save() ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Usuario creado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema con la creacion del Usuario');
        }
        return response()->json($data, 200);
    }


    public function delete(Request $request){
        $datos = $request->all();
        $id = $datos['id'];
        $user = User::find($id)->delete();
        if ( $user ){
            $data = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Usuario Eliminado');
        }else{
            $data = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Hubo un problema al eliminar el Usuario');
        }
        return response()->json($data, 200);
    }

}
