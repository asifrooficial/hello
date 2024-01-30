<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('body')->nullable();
            $table->integer('eventId')->unique()->nullable();
            $table->string('mainHand')->nullable();
            $table->string('offHand')->nullable();
            $table->string('head')->nullable();
            $table->string('armor')->nullable();
            $table->string('shoes')->nullable();
            $table->string('cape')->nullable();
            $table->string('mount')->nullable();
            $table->string('bag')->nullable();
            $table->string('killer')->nullable();
            $table->string('killerGuild')->nullable();
            $table->string('killerAlliance')->nullable();
            $table->string('timeKilled')->nullable();
            $table->tinyInteger('isApproved')->default(0);
            //$table->boolean('regearMe')->default(0); 
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }
 
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
