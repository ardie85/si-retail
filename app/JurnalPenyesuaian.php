<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalPenyesuaian extends Model
{
    protected $table = 'jurnalPenyesuaian';
    protected $primaryKey = 'jurnalPenyesuaianId';
    public $timestamps = false;
}
