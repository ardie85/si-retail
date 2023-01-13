<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beban extends Model
{
    protected $table = 'beban';
    protected $primaryKey = 'bebanId';
    public $timestamps = false;
}
