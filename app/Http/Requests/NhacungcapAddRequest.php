<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class voucherAddRequest extends Request
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
            'txtNCCName'     => 'required|unique:voucher,voucher_ten',
            'txtNCCPhone'    => 'required|max:12|min:10',
            'txtNCCAdress'   => 'required'
        ];
    }
    public function messages() {
        return [
            'required'   => '<div><strong  style="color: red;">Vui lòng không để trống trường này!</strong></div>',
            'txtNCCName.unique'     => '<div><strong  style="color: red;">Nhóm sản phẩm này đã tồn tại!</strong></div>',
            'txtNCCPhone.max'   => '<div><strong  style="color: red;">Số điện thoại vượt quá độ dài cho phép!</strong></div>',
            'txtNCCPhone.min'   => '<div><strong  style="color: red;">Số điện thoại ngắn hơns độ dài cho phép!</strong></div>'
        ];
    }
}
