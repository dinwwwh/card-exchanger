<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Arr;
use DB;
use Exception;
use Str;

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
        # barryvdh/laravel-ide-helper package
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        Arr::macro('toJson', function ($json) {
            // Convert from array to json and add slashes, if necessary.
            if (is_array($json)) {
                $json = addslashes(json_encode($json));
            }
            // Or check if the value is malformed.
            elseif (is_null($json) || is_null(json_decode($json))) {
                throw new Exception('A valid JSON string was not provided.');
            }
            return DB::raw("CAST('{$json}' AS JSON)");
        });

        # Helper to convert keys of array to 'camelCase'
        Arr::macro('camel', function (array $arr, int $depth = -1): array {
            if ($depth == 0) return $arr;
            $camelArr = [];
            foreach ($arr as $key => $value) {
                $camelArr[Str::camel($key)] = is_array($value)
                    ? static::camel($value, $depth - 1)
                    : $value;
            }
            return $camelArr;
        });
    }
}
