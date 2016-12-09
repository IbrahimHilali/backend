<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryBooksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_books', function (Blueprint $table) {
            $table->increments('id');

            $table->string('catalog_id')->unique();
            $table->text('title');

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('CREATE FULLTEXT INDEX fx_library_book_title ON library_books (title)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE library_books DROP INDEX fx_library_book_title');

        Schema::drop('library_books');
    }
}
