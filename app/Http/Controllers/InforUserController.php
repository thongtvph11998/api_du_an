<?php

namespace App\Http\Controllers;

use App\Models\InforUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InforUserController extends Controller
{
      public function index(Request $request)
    {
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $gender=$request->input('gender');
        $query=DB::table('infor_users');
        if($keyword){
            $query=$query->where('address','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
        if($gender){
            $query=$query->where('gender','=',$gender);
        }
        $infor=$query->get();
        return response()->json([
                'success'=>true,
                'data'=>$infor
            ]);

    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'pro_id'=>'required',
            'phone'=>'required',
            'address'=>'required|min:5',
            'birthday'=>'required|date',
            'gender'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }

        $data=$request->all();
        $infor=InforUser::create($data);
            return response()->json([
                'success'=>true,
                'data'=>$infor
            ]);
    }


    public function show(InforUser $infor)
    {
        return response()->json([
            'success'=>true,
            'data'=>$infor
        ]);
    }

    public function update(Request $request, InforUser $infor)
    {
        $validator=Validator::make($request->all(),[
            'user_id'=>'required',
            'pro_id'=>'required',
            'phone'=>'required',
            'address'=>'required|min:5',
            'birthday'=>'required|date',
            'gender'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $data=$request->all();
        $infor->update($data);
         return response()->json([
            'success'=>true,
            'data'=>$infor
        ]);
    }


    public function destroy(InforUser $infor)
    {
        $infor->delete();
         return response()->json([
            'success'=>true,
            'data'=>$infor
        ]);
    }
}
