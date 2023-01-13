<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalPenjualan extends Model
{
    protected $table = 'jurnalPenjualan';
    protected $primaryKey = 'jurnalPenjualanId';
    public $timestamps = false;
}
