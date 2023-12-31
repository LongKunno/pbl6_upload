<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class NhomAddRequest extends Request
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
            'txtNName'    => 'required|unique:nhom,nhom_ten',
            'fImage' => 'required|mimes:jpeg,bmp,png|max:4000'
        ];
    }

    public function messages() {
        return [
            'txtNName.required'   => '<div><strong  style="color: red;">Vui lòng không để trống trường này!</strong></div>',
            'txtNName.unique'     => '<div><strong  style="color: red;">Nhóm sản phẩm này đã tồn tại!</strong></div>',
            'mimes' => '<div><strong  style="color: red;">Vui lòng chọn đúng file ảnh</strong></div>',
            'fImage.max' => '<div><strong  style="color: red;">Vui lòng chọn file ảnh có kích thước không quá 2MB</strong></div>'
        ];
    }
}
