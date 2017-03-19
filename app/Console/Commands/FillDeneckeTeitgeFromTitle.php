<?php

namespace App\Console\Commands;

use Grimm\LibraryBook;
use Illuminate\Console\Command;

class FillDeneckeTeitgeFromTitle extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grimm:auto_fill_library_books';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills all denecke_teitge fields from title field';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('filled ' . LibraryBook::query()->where('denecke_teitge', '')
                ->get()
                ->each(function (LibraryBook $book) {
                    $book->denecke_teitge = $book->title;
                    $book->save();
                })->count() . " books");

        return true;
    }
}
