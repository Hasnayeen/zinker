<?php

namespace App\Providers;

use App\Actions\ParseCodeInput;
use App\Actions\RunInTinker;
use App\Actions\RunMagicCommands;
use Illuminate\Support\ServiceProvider;
use PhpParser\ParserFactory;
use Symfony\Component\Process\PhpExecutableFinder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            ParseCodeInput::class,
            fn ($app) => new ParseCodeInput(
                config('app.url'),
                resolve(ParserFactory::class)
            ),
        );
        $this->app->bind(
            RunMagicCommands::class,
            fn ($app) => new RunMagicCommands()
        );
        $this->app->bind(
            RunInTinker::class,
            fn ($app) => new RunInTinker((new PhpExecutableFinder())->find())
        );
    }
}
