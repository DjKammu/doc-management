<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belege extends Model
{
    use HasFactory;

    protected $table = 'Belege';

    protected $perPage = 20;
}
