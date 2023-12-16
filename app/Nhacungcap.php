<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class voucher extends Model
{
    protected $table = "voucher";

    protected $fillable = ['voucher_ten','voucher_dia_chi','voucher_sdt'];

	public $timestamps = false;
}
