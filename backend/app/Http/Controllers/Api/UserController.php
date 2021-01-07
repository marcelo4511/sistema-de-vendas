<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TypeUser;
use App\User;
use App\UserProfile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('tipo_usuario','profile')->get();

        return response()->json($users,200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try{
            $validate = Validator::make($request->all(),[
                'name' => ['required'],
                'email' => ['required','email','unique:users'],
                'type_user_id' => ['required'],
                'password' => ['required','min:6','confirmed'],
                'password_conformation' => ['required']
            ]);
            if($validate->fails()){
                response()->json(['errors' => $validate->errors()]);
            }
                
                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'type_user_id' => $request->type_user_id,
                'password' => Hash::make($request->password)
                ]);

                $user->profile()->create([
                    'data_nasc' => $request->data_nasc,
                    'gender' => $request->gender,
                    'about' => $request->about,
                    'phone' => $request->phone,
                ]);
                return response()->json(['success' => 'OK'],200);
        }catch(Exception $e) {
            return response()->json(['err' => $e->getMessage()],400);
        }
    }

    public function login(Request $request)
    {
        
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        $user = User::where('email', $request->email)->with('profile')->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }
    
        $token = $user->createToken('my-app-token')->plainTextToken;
    
        $response = [
            'user' => $user,
            'token' => $token
        ];
    
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $perfil = UserProfile::with('user','user.tipo_usuario')
        ->when(Auth::user()->id,function($use){
            $use->whereHas('user',function($query) {
                $query->whereUserId(Auth::id());
            });
        })
        ->get();
        return response()->json($perfil,200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validate = Validator::make($request->all(),[
                'name' => ['required'],
                'email' => ['required','email','unique:users'],
                'password' => ['required','min:6','confirmed'],
                'password_conformation' => ['required']
            ]);
            if($validate->fails()){
                response()->json(['errors' => $validate->errors()]);
            }
                //$data = $request->all();
                
                $user = User::findOrFail($id);
                $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
                ]);
                return response()->json(['success' => 'OK'],200);
        }catch(Exception $e) {
            return response()->json(['err' => $e->getMessage()],400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(['message' => __METHOD__]);
    }

    public function listar()
    {
        $typeuser = TypeUser::select('id','descricao')->whereNotIn('id',[1])->get();
        return response()->json($typeuser,200);
    }
}
