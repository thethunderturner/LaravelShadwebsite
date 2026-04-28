<?php

namespace App\Providers;

use Awcodes\Curator\Facades\Glide;
use Awcodes\Curator\Glide\SymfonyResponseFactory;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentColor;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->extend(
            HtmlSanitizerConfig::class,
            fn (HtmlSanitizerConfig $config): HtmlSanitizerConfig => $config
                ->allowElement('iframe', ['src', 'width', 'height', 'frameborder', 'allowfullscreen', 'allow', 'title', 'referrerpolicy', 'class'])
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentColor::register([
            'purple' => Color::Purple,
            'sky' => Color::Sky,
        ]);

        Glide::serverConfig([
            'response' => new SymfonyResponseFactory(request()),
            'source' => public_path('images'),
            'cache' => storage_path('app'),
            'cache_path_prefix' => '.cache',
            'max_image_size' => 2000 * 2000,
            'base_url' => 'curator',
        ]);
    }
}
