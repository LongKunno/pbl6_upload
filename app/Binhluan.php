<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Binhluan extends Model
{
    protected $table = "binhluan";
    // Tránh lỗ hỏng khi user cố tình cho role = 'admin'
    //$fillable cho phép thiết lập các cột trong một bảng có thể sử dụng tính năng Mass Assignment (Lỗ hỏng bảo mật)
    protected $fillable = ['id','binhluan_ten','binhluan_email','binhluan_noi_dung','binhluan_trang_thai','sanpham_id'];
    // tạo create time and update time
	public $timestamps = true;
}
