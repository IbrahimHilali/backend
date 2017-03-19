<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLibraryPeopleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('library_people', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->string('note')->nullable()->default(null);

            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement('CREATE FULLTEXT INDEX fx_library_person_name ON library_people (name)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('library_people');
    }
}
