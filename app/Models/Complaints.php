<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaints extends Model
{
    protected $table = 'reclamation';
    public $primaryKey = 'IdReclamation';

    public $timestamps = false;
    use HasFactory;
}