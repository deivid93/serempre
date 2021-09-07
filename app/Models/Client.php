<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['cod', 'name', 'cities_id', 'created_at', 'updated_at'];
    protected $table = 'client';
    public $timestamps;

    public function cities(){
        return $this->belongsTo('App\Models\City');
    }
}
