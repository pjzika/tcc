<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('babies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->date('birth_date');
            $table->timestamps();
            
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('babies');
    }
}; 