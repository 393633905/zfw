<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;//需改为true,允许通过
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'fang_xiaoqu'=>'required',
        ];
    }

    public function message(){
        return [
            'fang_xiaoqu.required'=>'小区名称必填'
        ];
    }
}
