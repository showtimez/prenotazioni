<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('SET NULL');
            $table->date('data');
            $table->integer('fascia');
            $table->integer('posti');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('reservations', function (Blueprint $table) {
        $table->dropForeign(['user_id']);
        $table->dropColumn(['user_id']);
    });
    Schema::dropIfExists('reservations');
}

};
