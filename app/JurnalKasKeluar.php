<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalKasKeluar extends Model
{
    protected $table = 'jurnalKasKeluar';
    protected $primaryKey = 'jurnalKasKeluarId';
    public $timestamps = false;
}
