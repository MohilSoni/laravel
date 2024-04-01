<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_models', function (Blueprint $table) {
            $table->id();
            $table->string('username', 30);
            $table->string('useremail', 50);
            $table->string('userpassword', 50);
            $table->string('usercontact', 10);
            $table->string('useraddress');
            $table->string('usergender');
            $table->string('userhobbies');
            $table->string('usercountry');
            $table->string('userimage');
            $table->string('location',255);
            $table->string('lat');
            $table->string('lon');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_models');
    }
};
