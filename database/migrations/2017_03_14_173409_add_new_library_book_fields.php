<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewLibraryBookFields extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('library_books', function (Blueprint $table) {
            $table->text('denecke_teitge')->default('');

            $table->string('volumes')->nullable()->default(null);
            $table->string('vols_year')->nullable()->default(null);
            $table->string('numbers')->nullable()->default(null);
            $table->string('place')->nullable()->default(null);
            $table->string('publisher')->nullable()->default(null);
            $table->string('year')->nullable()->default(null);
            $table->string('pages')->nullable()->default(null);
            $table->string('handwritten_dedication')->nullable()->default(null);

            $table->string('notes_jg')->nullable()->default(null);
            $table->string('notes_wg')->nullable()->default(null);
            $table->string('notes_other')->nullable()->default(null);

            $table->string('particularities')->nullable()->default(null);
            $table->string('place_of_storage')->nullable()->default(null);
            $table->string('purchase_number')->nullable()->default(null);
            $table->string('shelf_mark')->nullable()->default(null);

            $table->string('tales_comm_1856')->nullable()->default(null);
            $table->string('handwr_add_tales_comm_1856')->nullable()->default(null);

            $table->string('external_digitization')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
