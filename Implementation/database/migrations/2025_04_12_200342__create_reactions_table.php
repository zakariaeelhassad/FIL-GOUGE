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
        Schema::create('reactions' , function(Blueprint $table){
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('post_id')->constrained('posts')->onDelete('cascade');
            $table->enum('reaction' , ['like' , 'wow' , "grr" , "sad" , "love" , "haha"]);
            $table->timestamps();
        });     
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
