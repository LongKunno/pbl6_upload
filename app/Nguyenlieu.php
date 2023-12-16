<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nguyenlieu extends Model
{
    protected $table = 'nguyenlieu';

	protected $fillable = ['sanpham_id','thongtin_id'];

	public $timestamps = false;
}
