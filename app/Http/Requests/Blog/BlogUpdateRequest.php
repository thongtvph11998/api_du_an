<?php

namespace App\Http\Requests\Blog;

use App\Http\Transforms\ApiTransform;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BlogUpdateRequest extends FormRequest
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
        return [
            'title'=>'required|min:2',
            'image'=>'required|mimes:jpeg,jpg,png,gif|max:500',
            'content'=>'required|min:10'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ApiTransform::badRequestException($validator)
        );
    }
}
