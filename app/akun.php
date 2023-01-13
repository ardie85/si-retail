<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class akun extends Model
{
    protected $table = 'akun';
    protected $primaryKey = 'akunid';
    public $timestamps = false;
}
