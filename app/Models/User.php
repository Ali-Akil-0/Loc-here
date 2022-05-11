<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    function getAnnoncesPremium()
    {
        $user = DB::table('annonces')->where('name', 'Premium')->first();
        return $user;
    }

    use HasFactory;
}