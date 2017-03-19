<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryRelationTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $structure = function (Blueprint $table) {
            $table->increments('id');

            $table->integer('library_book_id')->unsigned();
            $table->integer('library_person_id')->unsigned();

            $table->foreign('library_book_id',
                'book_index_' . uniqid())->references('id')->on('library_books')->onDelete('cascade');
            $table->foreign('library_person_id',
                'person_index_' . uniqid())->references('id')->on('library_people')->onDelete('cascade');

            $table->unique(['library_book_id', 'library_person_id'], 'library_relation_unique_' . uniqid());
        };

        Schema::create('library_author_relation', $structure);
        Schema::create('library_editor_relation', $structure);
        Schema::create('library_translator_relation', $structure);
        Schema::create('library_illustrator_relation', $structure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('library_author_relation');
        Schema::drop('library_editor_relation');
        Schema::drop('library_translator_relation');
        Schema::drop('library_illustrator_relation');
    }
}
