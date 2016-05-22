<?php

namespace App\Providers;

use Grimm\Activity;
use Grimm\Book;
use Grimm\Person;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class ModelActivityProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (app()->runningInConsole()) {
            return;
        }

        Book::created(function (Model $model) {
            $this->logCreating($model);
        });

        Book::updating(function (Model $model) {
            $this->logUpdating($model);
        });

        Book::deleting(function (Model $model) {
            $this->logDeleting($model);
        });

        Book::restored(function (Model $model) {
            $this->logRestoring($model);
        });

        Person::created(function (Model $model) {
            $this->logCreating($model);
        });

        Person::updating(function (Model $model) {
            $this->logUpdating($model);
        });

        Person::deleting(function (Model $model) {
            $this->logDeleting($model);
        });

        Person::restored(function (Model $model) {
            $this->logRestoring($model);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    protected function log($model, $log)
    {
        Activity::create([
            'model_id' => $model->id,
            'model_type' => get_class($model),
            'log' => $log,
            'user_id' => auth()->user()->id,
        ]);
    }

    protected function logCreating(Model $model)
    {
        $this->log($model, [
            'action' => 'creating',
            'after' => $model->getDirty(),
        ]);
    }

    protected function logUpdating(Model $model)
    {
        $before = $this->getBeforeFromModel($model);

        if (!array_key_exists('deleted_at', $before)) {
            $this->log($model, [
                'action' => 'updating',
                'before' => $before,
                'after' => $model->getDirty(),
            ]);
        }
    }

    protected function logDeleting(Model $model)
    {
        $this->log($model, [
            'action' => 'deleting',
            'before' => $model->getOriginal(),
        ]);
    }

    protected function logRestoring(Model $model)
    {
        $this->log($model, [
            'action' => 'restoring',
            'after' => $model->getOriginal()
        ]);
    }

    protected function getBeforeFromModel(Model $model)
    {
        return array_intersect_key($model->getOriginal(), $model->getDirty());
    }

}
