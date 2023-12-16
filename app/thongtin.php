<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thongtin extends Model
{
    protected $table = 'thongtin';

	protected $fillable = ['thongtin_ten_gia','thongtin_tieu_de','thongtin_tom_tat','thongtin_noi_dung','thongtin_luot_xem','thongtin_da_xoa','thongtin_anh'];

	public $timestamps = true;
}
