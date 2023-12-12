<?php

namespace Pardalsalcap\LinterRedirections;

use Pardalsalcap\LinterRedirections\Commands\LinterRedirectionsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LinterRedirectionsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('linter-redirections')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_linter-redirections_table')
            ->hasCommand(LinterRedirectionsCommand::class);
    }
}
