<?php

namespace App\Http\Controllers;

use App\Models\InforUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InforUserController extends Controller
{
      public function index()
    {
        $infor=InforUser::all();
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
