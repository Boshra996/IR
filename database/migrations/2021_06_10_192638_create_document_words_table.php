<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentWordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_words', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->double('tf');
            $table->double('weight');
            $table->unsignedBigInteger('document_id');
            $table->unsignedBigInteger('word_id');
            $table->foreign('document_id')->references('id')->on('documents');
            $table->foreign('word_id')->references('id')->on('word');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_words');
    }
}
