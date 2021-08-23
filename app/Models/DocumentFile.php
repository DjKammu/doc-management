<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
    use HasFactory;


   protected $fillable = [
	     'file','name'
	 ];

    public function document(){
    	return $this->belongsTo(Document::class);
    }

}
