<?php

namespace App\Providers;

use App\Deployment\DeploymentService;
use App\Filters\FilterApplicator;
use App\History\HistoryEntityTransformer;
use App\History\Presenters\BookPresenter;
use App\History\Presenters\PersonPresenter;
use Carbon\Carbon;
use Grimm\Person;
use Illuminate\Support\ServiceProvider;
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
        Person::$unknownName = trans('people.unknownName');
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
        
        $this->app->singleton(HistoryEntityTransformer::class, function () {
            return new HistoryEntityTransformer([new PersonPresenter(), new BookPresenter()]);
        });

        $this->app->singleton(FilterApplicator::class, function () {
            return new FilterApplicator();
        });
        
        \URL::macro('filtered_to', function($to, $deltaFilters = []) {
            /** @var FilterApplicator $filterApplicator */
            $filterApplicator = app(FilterApplicator::class);
            
            $queryString = $filterApplicator->buildQueryString($deltaFilters);

            if (empty($queryString)) {
                return $to;
            }

            return $to . '?' . $queryString;
        });

        \URL::macro('filtered', function($deltaFilters = []) {
            return url()->filtered_to(url()->current(), $deltaFilters);
        });
    }
}
