<?php

namespace App\Http\Controllers;

use App\Models\Agencia;
use App\Models\Chat;
use App\Models\User;
use App\Models\UserVideo;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class UserController extends Controller
{
    public function index(Request $request){
        $users= User::where('id','!=',1)
//            ->where('id','!=',$request->user()->id)
            ->with('permissions')
            ->get();
        return $users;
    }
    public function show($id,Request $request)
    {
        $user_id=$request->user()->id;
        $chats= Chat::whereRaw("(userEnviado_id=$user_id AND userRecibido_id=$id)OR(userEnviado_id=$id AND userRecibido_id=$user_id)")->get();
        return $chats;
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'message'=>'Las credenciales proporcionadas son incorrectas'
            ],401);
        }
        if ($user->active=='No'){
            return response()->json([
                'message'=>'El usuario no esta activo'
            ],401);
        }
        return response()->json([
            'token'=>$user->createToken('web')->plainTextToken,
            'permisos'=>$user->getAllPermissions(),
            'user'=>$user
        ],200);
    }
    public function register(Request $request){
        $request->validate([
            'email'=>'required|unique:users|email',
            'name'=>'required|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user=new User();
        $user->name= ( $request->name);
        $user->email=$request->email;
        $user->password=Hash::make( $request->password);
//        $user->fechaLimite=date('Y-m-d', strtotime(now(). ' + 360 days'));
//        $user->fechaConexion=now();
        $user->save();
        $token=$user->createToken('web')->plainTextToken;
        return response()->json([
            'token'=>$token,
            'user'=>User::find($user->id)
        ],200);
    }
    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required|same:password',
            'tipo' => 'required',
            'fechaLimite' => 'required',
        ]);
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->tipo=$request->tipo;
        $user->password= Hash::make($request->password) ;
        $user->fechaLimite=$request->fechaLimite;
        $user->save();
    }
    public function update(Request $request,User $user){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id
        ]);
        $user->update($request->all());
        $user->syncPermissions($request->permisos);
        foreach ($request->permissions as $permission){
            if ($permission['checked']){
                $user->givePermissionTo($permission['name']);
            }
        }
        return $user;
    }
    public function updateActive(User $user){
        $user->active = $user->active=='Si'?'No':'Si';
        $user->save();
        return $user;
    }

    public function updatePassword(Request $request,User $user){
//        $this->validate($request, [
//            'password' => 'required|confirmed',
//            'password_confirmation' => 'required|same:password',
//        ]);
        $user->update([
            'password'=>Hash::make($request->password)
        ]);
        return $user;
    }
    public function destroy(User $user){
        $user->delete();
    }
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['res'=>'salido exitosamente'],200);
    }
    public function me(Request $request){
        $user=User::where('id',$request->user()->id)->firstOrFail();
        return response()->json([
            'user'=>$user,
            'permisos'=>$user->getAllPermissions()
        ],200);
    }
}
