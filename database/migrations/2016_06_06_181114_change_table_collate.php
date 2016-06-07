<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableCollate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // It is regulated by DIN 5007 Variant 2 that in registers special characters like ä, ö and ü should be
        // sorted as ae, oe or ue. This standard is covered by the utf8_german2_ci collation of MySQL.
        \DB::statement('ALTER TABLE books CONVERT TO CHARACTER SET utf8 COLLATE utf8_german2_ci');
        \DB::statement('ALTER TABLE book_person CONVERT TO CHARACTER SET utf8 COLLATE utf8_german2_ci');
        \DB::statement('ALTER TABLE persons CONVERT TO CHARACTER SET utf8 COLLATE utf8_german2_ci');
        \DB::statement('ALTER TABLE person_prints CONVERT TO CHARACTER SET utf8 COLLATE utf8_german2_ci');
        \DB::statement('ALTER TABLE person_inheritances CONVERT TO CHARACTER SET utf8 COLLATE utf8_german2_ci');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('ALTER TABLE books CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        \DB::statement('ALTER TABLE book_person CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        \DB::statement('ALTER TABLE persons CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        \DB::statement('ALTER TABLE person_prints CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
        \DB::statement('ALTER TABLE person_inheritances CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci');
    }
}
