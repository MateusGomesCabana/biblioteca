<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_authors', function (Blueprint $table) {
            $table->integer('authors_id')->unsigned();
            $table->integer('books_id')->unsigned();
            $table->timestamps();

        });
        Schema::table('books_authors', function(Blueprint $table){
            $table->foreign('authors_id')->references('id')->on('authors');
            $table->foreign('books_id')->references('id')->on('books');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_authors');
    }
}
