<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alarms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baby_id');
            $table->time('time');
            $table->string('day_of_week');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('baby_id')
                  ->references('id')
                  ->on('babies')
                  ->onDelete('cascade');
            
            $table->engine = 'InnoDB';
        });
    }

    public function down()
    {
        Schema::dropIfExists('alarms');
    }
}; 