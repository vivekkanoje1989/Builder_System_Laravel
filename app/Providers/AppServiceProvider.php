<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Blade::setRawTags("[[", "]]"); // echo some text or value {{ %variable }}
        \Blade::setContentTags('<%', '%>'); // for variables and all things Blade // {{ %variable }}
        \Blade::setEscapedContentTags('<%%', '%%>'); // for escaped data // all special HTML chars are escaped
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
