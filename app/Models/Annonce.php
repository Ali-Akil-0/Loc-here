<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Annonce extends Model
{
    function getAnnoncesPremium()
    {
        $user = DB::table('annonces')->where('name', 'Premium')->first();
        return $user;
    }
    use HasFactory;
}