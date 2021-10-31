<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
     public function index(Request $request)
    {
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $query=DB::table('users');
        if($keyword){
            $query=$query->where('user_name','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }

       $users=$query->get();
        return response()->json([
                'success'=>true,
                'data'=>$users
     ]);
    }


    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_name' => 'required|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'password'=>'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'avatar'=> 'required|mimes:jpeg,jpg,png,gif|max:500',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $model=new User;
        $model->fill($request->all());
        if($request->hasFile('avatar')){
            $newAvatar=uniqid().'-'.$request->avatar->getClientOriginalName();
            $path=$request->avatar->storeAs(date('Y').'/'.date('m').'',$newAvatar);
            $model->avatar=str_replace('public/','',$path);
        }
        $model->save();
        return response()->json([
            'success'=>true,
            'data'=>$model
        ]);
    }


    public function show(User $user)
    {
            return response()->json([
                'success'=>true,
                'data'=>$user
            ]);
    }


    public function update(Request $request, User $user)
    {
         $validator=Validator::make($request->all(),[
            'user_name' => 'required|min:2|max:255',
            'email' => 'required|email',
            'password'=>'required|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/',
            'avatar'=> 'required|mimes:jpeg,jpg,png,gif|max:500',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $user->fill($request->all());
        if($request->hasFile('avatar')){
            $newAvatar=uniqid().'-'.$request->avatar->getClientOriginalName();
            $path=$request->avatar->storeAs(date('Y').'/'.date('m').'',$newAvatar);
            $user->image=str_replace('public/','',$path);
        }
        $user->save();
        return response()->json([
                'success'=>true,
                'data'=>$user
            ]);

    }
    public function destroy(User $user)
    {
        $image_path='uploads/'.$user->avatar;
        if(file_exists($image_path)){
            File::delete($image_path);
        }
        $user->delete();
        return response()->json([
            'success'=>true,
            'data'=>$user
        ]);
    }
}
