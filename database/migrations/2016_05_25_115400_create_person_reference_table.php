<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonReferenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person_reference', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('person_id')->unsigned();
            $table->integer('reference_id')->unsigned();

            $table->text('notes')->nullable();

            $table->unique(['person_id', 'reference_id']);

            $table->foreign('person_id')
                ->references('id')->on('persons')
                ->onDelete('cascade');

            $table->foreign('reference_id')
                ->references('id')->on('persons')
                ->onDelete('cascade');


            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('person_reference');
    }
}
