<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalPembelian extends Model
{
    protected $table = 'jurnalPembelian';
    protected $primaryKey = 'jurnalPembelianId';
    public $timestamps = false;
}
