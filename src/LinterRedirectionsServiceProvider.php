<?php

namespace Pardalsalcap\LinterRedirections;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Pardalsalcap\LinterRedirections\Commands\LinterRedirectionsCommand;

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
            ->hasTranslations()
            ->hasMigration('create_linter_redirections_table')
          ;
    }
}
