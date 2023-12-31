<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class BinhluanRequest extends Request
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
            'txtContent'  => 'required',
        ];
    }

    public function messages() {
        return [
            'required'   => '<div><strong  style="color: red;">Vui lòng không để trống trường này!</strong></div>',
            'txtEmail.regex'   => '<div><strong  style="color: red;">Email không đúng định dạng!!</strong></div>'
        ];
    }
}
