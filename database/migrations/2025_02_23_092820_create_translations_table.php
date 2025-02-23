<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('table_name');
            $table->string('column_name');
            $table->string('locale');
            $table->text('translated_text');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
}