<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroFeaturesTable extends Migration
{
    public function up()
    {
        Schema::create('hero_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hero_slide_id')
                  ->constrained('hero_slides')
                  ->onDelete('cascade');
            $table->string('icon_class');
            $table->string('text');
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_features');
    }
}
