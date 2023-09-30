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
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request){
        $users= User::
//        where('id','!=',1)
//            ->where('id','!=',$request->user()->id)
            with('permissions')
            ->with('roles')
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
        ]);

        $role = Role::find($request->roles[0]['id']);

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password= Hash::make($request->password);
        $user->save();

        $user->assignRole($role);
        foreach ($request->permissions as $permission){
            if ($permission['checked']){
                $user->givePermissionTo($permission['name']);
            }
        }
        return $user;
    }
    public function update(Request $request,User $user){
        // Validación de datos de entrada
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id
        ]);

        // Actualizar datos del usuario
        $user->update($request->all());

        // Obtener y sincronizar roles
        $role = Role::find($request->roles[0]['id']);
        $user->syncRoles($role);

        // Obtener y sincronizar permisos
        $namePermissionArray = [];
        foreach ($request->permissions as $permission) {
            if ($permission['checked']) {
                $namePermissionArray[] = $permission['name'];
            }
        }
        $user->syncPermissions($namePermissionArray);

        // Devolver una respuesta adecuada (si es necesario)
//        //buscamos usuario igual rol
//        $userIgualRol=User::where('id','!=',$user->id)->whereHas('roles',function ($query) use ($role){
//            $query->where('id',$role->id);
//        })->get();
//////        return $userIgualRol;
//        foreach ($userIgualRol as $userIR){
//            $userIR->syncPermissions($request->permissions);
//        }
//
//        foreach ($request->permissions as $permission){
//            if ($permission['checked']){
//                $user->givePermissionTo($permission['name']);
//                $role->givePermissionTo($permission['name']);
//                foreach ($userIgualRol as $userIR){
//                    //damos permisos a los usuarios con el mismo rol
//                    $userIR->givePermissionTo($permission['name']);
//                }
//            }
//        }
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
