<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddImageToPassengersTable extends Migration
{
    public function up()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->string('image')->nullable(); // Add the image column
        });
    }

    public function down()
    {
        Schema::table('passengers', function (Blueprint $table) {
            $table->dropColumn('image'); // Drop the image column if rollback
        });
    }
}
//you can put them in the same migratio as long as u are not live