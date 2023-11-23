<?php

namespace Modules\Media\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Modules\Media\Console\RefreshThumbnailCommand;
use Modules\Media\Entities\File;
use Modules\Media\Events\Handlers\HandleMediaStorage;
use Modules\Media\Events\Handlers\RemovePolymorphicLink;
use Modules\Media\Repositories\Eloquent\EloquentFileRepository;
use Modules\Media\Repositories\FileRepository;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'Media';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'media';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        $this->registerMaxFolderSizeValidator();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        $events->listen('*', HandleMediaStorage::class);
        $events->listen('*', RemovePolymorphicLink::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->registerCommands();
        $this->app->register(RouteServiceProvider::class);
    }

    private function registerBindings()
    {
        $this->app->bind(FileRepository::class, function ($app) {
            return new EloquentFileRepository(new File(), $app['filesystem.disk']);
        });
    }

    /**
     * Register all commands for this module
     */
    private function registerCommands()
    {
        $this->registerRefreshCommand();
    }

    /**
     * Register the refresh thumbnails command
     */
    private function registerRefreshCommand()
    {
        //$this->app->bindShared('command.media.refresh', function ($app) {
        $this->app->singleton('command.media.refresh', function ($app) {
            return new RefreshThumbnailCommand($app['Modules\Media\Repositories\FileRepository']);
        });

        $this->commands('command.media.refresh');
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath,
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'Resources/lang'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }

    private function registerMaxFolderSizeValidator()
    {
        Validator::extend('max_size', '\Modules\Media\Validators\MaxFolderSizeValidator@validateMaxSize');
    }
}
