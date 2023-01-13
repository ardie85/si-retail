<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    protected $table = 'supplier';
    protected $primaryKey = 'supplierId';
    public $timestamps = false;
}
