<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class akunSaldo extends Model
{
    protected $table = 'saldoperiode';
    protected $primaryKey = 'saldoId';
    public $timestamps = false;
}
