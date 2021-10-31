<?php

namespace App\Http\Controllers;

use App\Http\Requests\Blog\BlogUpdateRequest;
use App\Http\Requests\Blog\BlogStoreRequest;
use App\Http\Transforms\ApiTransform;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class BlogController extends Controller
{
    public function index(Request $request){
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');

        $query=DB::table('blogs');
        if($keyword){
            $query=$query->where('title','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
        $blog=$query->get();
        return response()->json([
                'success'=>true,
                'data'=>$blog
            ]);
    }
    public function store(BlogStoreRequest $request){
        try {
            $model = new Blog();
            $model->fill($request->all());
            if ($request->hasFile('image')) {
                $newFileName =uniqid() . '-' . $request->image->getClientOriginalName();
                $path = $request->image->storeAs(date('Y').'/'.date('m').'' , $newFileName);
                $model->image = str_replace('public/', '', $path);
            }
            $model->save();

            return ApiTransform::ok($model);
        } catch (\Exception $exception) {
            return ApiTransform::internalServerErrorException($exception);
        }
    }
    public function show($id){
        try {
            $blog = Blog::query()->find($id);
            if (!$blog) {
                return ApiTransform::notFoundException('Blog not found');
            }
            return ApiTransform::ok($blog);
        } catch (\Exception $exception) {
            return ApiTransform::internalServerErrorException($exception);
        }
    }

    public function update(BlogUpdateRequest $request, $id){
        try {
            $blog=Blog::query()->find($id);
            if ($request->hasFile('image')) {
                $newFileName =uniqid() . '-' . $request->image->getClientOriginalName();
                $path = $request->image->storeAs(date('Y').'/'.date('m').'', $newFileName);
                $blog->image = str_replace('public/', '', $path);
            }
            $blog->save();
            return ApiTransform::ok($blog);

        }catch (\Exception $exception){
            return ApiTransform::internalServerErrorException($exception);
        }
    }
    public function destroy($id){

        $blog=Blog::query()->find($id);
        $image_path='uploads/'.$blog->image;
        if(file_exists($image_path)){
            File::delete($image_path);
        }
        $blog->delete();
        return ApiTransform::ok($blog);


    }
}
