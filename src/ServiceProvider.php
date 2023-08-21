<?php

namespace JustBetter\StatamicPostcodenl;

use Illuminate\Support\Facades\Http;
use JustBetter\StatamicPostcodenl\Tags\PostcodenlTag;
use Statamic\Providers\AddonServiceProvider;
use JustBetter\StatamicPostcodenl\Fieldtypes\Postcodenl;

class ServiceProvider extends AddonServiceProvider
{
    protected $tags = [
        PostcodenlTag::class,
    ];

    protected $scripts = [
        __DIR__ . '/../dist/js/statamic-postcodenl.js'
    ];

    public function register(): void
    {
        $this->registerConfig();
    }
    public function boot(): void
    {
        parent::boot();

        $this
            ->bootRoutes()
            ->bootMacros()
            ->bootPublishables()
            ->bootCustomFieldTypes();
    }

    public function registerConfig() : self
    {
        $this->mergeConfigFrom(__DIR__.'/../config/justbetter-postcodenl.php', 'justbetter-postcodenl');

        return $this;
    }

    public function bootPublishables() : self
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'justbetter-postcodenl');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/justbetter-postcodenl'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/justbetter-postcodenl.php' => config_path('justbetter-postcodenl.php'),
        ], 'config');

        return $this;
    }

    public function bootRoutes() : self
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        return $this;
    }

    public function bootMacros() : self
    {
        Http::macro('postcodenl', function () {
            return Http::withHeaders([
                'Authorization' => 'Basic ' . base64_encode(config('justbetter-postcodenl.key') . ':' . config('justbetter-postcodenl.secret')),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])->baseUrl('https://api.postcode.eu');
        });

        return $this;
    }

    public function bootCustomFieldTypes(): self
    {
        Postcodenl::register();

        return $this;
    }
}
