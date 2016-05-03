<?php

namespace App\Providers;

use App\Import\Books\Converter\BookConverter;
use App\Import\Books\Parser\GrimmParser;
use App\Import\Books\Parser\SourceParser;
use App\Import\Books\Parser\TitleParser;
use App\Import\Books\Parser\YearParser;
use App\Import\Persons\BioDataExtractor;
use App\Import\Persons\Converter\PersonConverter;
use App\Import\Persons\Parser\BioDataParser;
use App\Import\Persons\Parser\InheritanceParser;
use App\Import\Persons\Parser\NameParser;
use App\Import\Persons\Parser\PersonPrintParser;
use App\Sync\DeploymentService;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use App\Import\Persons\Parser\RestFieldParser as PersonRestFieldParser;
use Spatie\Valuestore\Valuestore;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Carbon::setLocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DeploymentService::class, function() {
            return new DeploymentService(Valuestore::make(storage_path('app/deployment.json')));
        });
    }
}
