<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flight_id'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('image');
            $table->date('dob');
            $table->date('passport_expiry_date');
            $table->timestamps();
            $table->softDeletes(); 
        
            $table->foreign('flight_id')->references('id')->on('flights')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passengers');
    }
    
};
