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
            // foreign key ke hero_slides.id
            $table->foreignId('hero_slide_id')
                  ->constrained('hero_slides')
                  ->cascadeOnDelete();
            $table->string('icon_class', 150);
            $table->string('text', 255);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hero_features');
    }
}
