<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

     protected $fillable = [
     'name' , 'slug' ,'account_number',
     'file','property_id',
     'document_type_id'
    ];


    public function document_type(){

        return $this->belongsTo(DocumentType::class);
    }

    public function property(){
    	return $this->belongsTo(Property::class);
    }

    public function files(){
        return $this->hasMany(DocumentFile::class);
    }
}
