<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FangRequest extends FormRequest
{
    /**
     * 允许验证：
     * @return bool
     */
    public function authorize()
    {
        return true;//需改为true,允许通过
    }
    /**
     * 编写验证规则：
     * @return array
     */
    public function rules()
    {
        return [
            'fang_xiaoqu'=>'required',
        ];
    }
    //验证信息：
    public function message(){
        return [
            'fang_xiaoqu.required'=>'小区名称必填'
        ];
    }
}
