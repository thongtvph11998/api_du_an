<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $cates=Category::all();
        $arr_cate_id=[];
        foreach($cates as $c){
            $arr_cate_id[]=$c->id;
        }
        $rule=[
            'cate_id' => [
                'required',
                Rule::in($arr_cate_id)
            ],
            'name' => [
                'required',
            ],
            'image' => 'required',
            'price' => 'required',
            'sale' => 'required',
            'quantity' => 'required',
            'desc_short' => 'required',
            'description' => 'required'
        ];
       if($this->id){
        $rule['name']=[
            'required',
            Rule::unique('products')->ignore($this->id)
        ];
       }else{
        $rule['name']=[
            'required',
            Rule::unique('products')
        ];
       }


        return $rule;
    }
    public function messages()
    {
        return [
            'cate_id',
            'name',
            'image',
            'price',
            'sale',
            'quantity',
            'desc_short',
            'description'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json([
            'message' => 'Invalid data send',
            'details' => $errors->messages(),
        ], 422);
        throw new HttpResponseException($response);
    }
}
