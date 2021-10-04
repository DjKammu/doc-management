<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $perPage = 9;

    CONST API_PER_PAGE = 20;

    protected $fillable = [
     'property_name' , 'property_address' ,'city',
     'state' , 'country' ,'zip_code' , 'notes' ,'photo','proprty_type_id'
    ];

    public function proprty_type(){
    	return $this->belongsTo(ProprtyType::class);
    }

    public function documents(){
    	return $this->hasMany(Document::class);
    }

    public function tenants(){
        return $this->hasMany(Tenant::class);
    }

    public function vendors(){
        return $this->hasMany(Vendor::class);
    }
    
}
