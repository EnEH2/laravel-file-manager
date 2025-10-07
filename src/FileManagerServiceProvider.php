<?php


namespace EnEH2\FileManager;

use Illuminate\Support\ServiceProvider;

class FileManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/eneh-filemanager.php', 'eneh-filemanager'
        );
    }


    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__ . '/config/eneh-filemanager.php' => config_path('eneh-filemanager.php'),
        ], 'eneh-filemanager-config');
    }
}
