<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{


    protected $table = 'markers';

    protected $fillable = ['latitude', 'longitude', 'description'];


} 