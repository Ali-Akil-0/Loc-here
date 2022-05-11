<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->String("Nom");
            $table->String("Prenom");
            $table->String("Username");
            $table->String("Email")->unique();
            $table->String("Password");
            $table->String("Type");
            $table->timestamps();
        });
        // Schema::create('client', function (Blueprint $table) {
        //     $table->id();
        //     $table->String("NomClint");
        //     $table->String("PrenomClient");
        //     $table->String("UsernameClient");
        //     $table->String("EmailClient")->unique();
        //     $table->String("PasswordClient");
        //     $table->timestamps();
        // });
        // Schema::create('partenaire', function (Blueprint $table) {
        //     $table->id();
        //     $table->String("NomPartenaire");
        //     $table->String("PrenomPartenaire");
        //     $table->String("UsernamePartenaire");
        //     $table->String("EmailPartenaire")->unique();
        //     $table->String("PasswordPartenaire");
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};