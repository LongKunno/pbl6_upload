<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class thongtinAddRequest extends Request
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
            'txtMNTittle'  => 'required|unique:thongtin,thongtin_tieu_de',
            'txtMNResum'  => 'required',
            'txtMNContent' => 'required',
            'fImage' => 'required|mimes:jpeg,bmp,png|max:4000'
        ];
    }

    public function messages() {
        return [
            'required'   => '<div><strong  style="color: red;">Vui lòng không để trống trường này!</strong></div>',
            'txtMNTittle.unique' => '<div><strong  style="color: red;">Dữ liệu này đã tồn tại!</strong></div>',
            'fImage.mimes' => '<div><strong  style="color: red;">Vui lòng chọn đúng file ảnh</strong></div>',
            'fImage.max' => '<div><strong  style="color: red;">Vui lòng chọn file ảnh có kích thước không quá 2MB</strong></div>'
        ];
    }
}
