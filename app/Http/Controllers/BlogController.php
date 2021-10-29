<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index(){
        $blog=Blog::all();
        return response()->json([
                'success'=>true,
                'data'=>$blog
            ]);
    }
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'title'=>'required|min:2|unique:blogs,title',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:500',
            'content'=>'required|min:10'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $model = new Blog();
        $model->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName =uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs(date('Y').'/'.date('m').'' , $newFileName);
            $model->image = str_replace('public/', '', $path);
        }
        $model->save();
        return response()->json([
            'success'=>true,
            'data'=>$model,
        ]);

    }
    public function show(Blog $blog){
        return response()->json([
                    'success'=>true,
                    'data'=>$blog
                ]);
    }

    public function update(Request $request, Blog $blog){

        $validator=Validator::make($request->all(),[
            'title'=>'required|min:2',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:500',
            'content'=>'required|min:10'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()]);
        }
        $blog->fill($request->all());
        if ($request->hasFile('image')) {
            $newFileName =uniqid() . '-' . $request->image->getClientOriginalName();
            $path = $request->image->storeAs(date('Y').'/'.date('m').'', $newFileName);
            $blog->image = str_replace('public/', '', $path);
        }
        $blog->save();
        return response()->json([
                'success'=>true,
                'data'=>$blog
            ]);
    }
    public function destroy(Blog $blog){
        $image_path='uploads/'.$blog->image;
        if(file_exists($image_path)){
            File::delete($image_path);
        }
        $blog->delete();
         return response()->json([
             'success'=>true,
             'data'=>$blog
         ]);


    }
}
