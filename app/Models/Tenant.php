<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $perPage = 20;

    protected $fillable = [
     'name' , 'property_id'
    ];
    
    function property(){
    	return $this->hasOne(Property::class,'id','property_id');
    	// return $this->belongsTo(Property::class,'property_id','id');
    }

}
