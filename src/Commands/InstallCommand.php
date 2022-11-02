<?php

namespace Sedehi\LaravelModule\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the module resources';

    /**
     *
     * @return void
     */
    public function handle()
    {
        $providerPath = app_path('Providers/RouteServiceProvider.php');
        $str = Str::of(file_get_contents($providerPath));
        $str = $str->beforeLast('}')->when(!$str->contains('mapModuleApiRoutes'),function($string){
            return $string->append(file_get_contents(__DIR__ . '/stubs/install/route-api-method.stub').'}');
        });
        file_put_contents($providerPath,$str);

        $str = Str::of(file_get_contents($providerPath));
        $str = $str->when(!$str->contains('mapModuleAdminRoutes'),function($string){
            return $string->beforeLast('}')->append(file_get_contents(__DIR__ . '/stubs/install/route-admin-method.stub').'}');
        });
        file_put_contents($providerPath,$str);

        $str = Str::of(file_get_contents($providerPath));
        $str = $str->when(!$str->contains('mapModuleWebRoutes'),function($string){
            return $string->beforeLast('}')->append(file_get_contents(__DIR__ . '/stubs/install/route-web-method.stub').'}');
        });
        file_put_contents($providerPath,$str);

        $str = Str::of(file_get_contents($providerPath))
            ->replace('$this->routes(function () {',PHP_EOL.'$this->routes(function () {'.PHP_EOL.'$this->mapModuleApiRoutes();');
        file_put_contents($providerPath,$str);

        $str = Str::of(file_get_contents($providerPath))
            ->replace('$this->routes(function () {',PHP_EOL.'$this->routes(function () {'.PHP_EOL.'$this->mapModuleAdminRoutes();');
        file_put_contents($providerPath,$str);

        $str = Str::of(file_get_contents($providerPath))
            ->replace('$this->routes(function () {',PHP_EOL.'$this->routes(function () {'.PHP_EOL.'$this->mapModuleWebRoutes();');
        file_put_contents($providerPath,$str);

    }
}
