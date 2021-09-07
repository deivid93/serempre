<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'created_at', 'updated_at'];

    protected $table = 'cities';

    public $timestamps;

    public function Clients(){
        return $this->hasMany('App\Models\Client');
    }


}
