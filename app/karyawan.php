<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    protected $table = 'pengguna';
    protected $primaryKey = 'penggunaId';
    public $timestamps = false;
}
