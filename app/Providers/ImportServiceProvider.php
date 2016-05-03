<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ImportServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }
        $this->app->singleton(PersonConverter::class, function () {
            $converter = new PersonConverter();

            $converter->registerParsers([
                new NameParser(),
                new BioDataParser(app(BioDataExtractor::class)),
                new PersonPrintParser(),
                new InheritanceParser(),
                new PersonRestFieldParser(),
            ]);

            return $converter;
        });

        $this->app->singleton(BookConverter::class, function () {
            $converter = new BookConverter();

            $converter->registerParsers([
                new TitleParser(),
                new YearParser(),
                new SourceParser(),
                new GrimmParser(),
            ]);

            return $converter;
        });
    }
}
