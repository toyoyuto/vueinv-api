<?php

namespace App\Console\Commands\Make;

use Illuminate\Routing\Console\ControllerMakeCommand;

class Controller extends ControllerMakeCommand
{
    use BuildReplacementsTrate;

    private $replaces = [];

    public function handle(): void
    {
        if (parent::handle() === false) {
            return;
        }

        if ($this->option('model')) {
            $name = $this->getModuleName();
            $path = $this->getModuleRelativePath();

            $modelClass = class_basename($this->parseModel($this->option('model')));

            $this->call('make:request', [
                'name'    => "{$path}{$name}SearchRequest",
                '--model' => $this->option('model'),
            ]);
            $this->call('make:request', [
                'name'    => "{$path}{$name}StoreRequest",
                '--model' => $this->option('model'),
            ]);
            $this->call('make:request', [
                'name'    => "{$path}{$name}UpdateRequest",
                '--model' => $this->option('model'),
            ]);

            $this->call('make:resource', [
                'name'    => "{$path}{$name}Resource",
                '--model' => $this->option('model'),
            ]);
            $this->call('make:resource', [
                'name'    => "{$path}{$name}ResourceCollection",
                '--model' => $this->option('model'),
            ]);

            $this->call('make:service', [
                'name'                   => "{$modelClass}Service",
                '--model'                => $this->option('model'),
                '--module_relative_path' => $path,
            ]);

            $this->call('make:valueObject', [
                'name'                   => "{$modelClass}StoreValue",
                '--model'                => $this->option('model'),
                '--module_relative_path' => $path,
            ]);
            $this->call('make:valueObject', [
                'name'                   => "{$modelClass}UpdateValue",
                '--model'                => $this->option('model'),
                '--module_relative_path' => $path,
            ]);

            $this->line('');
            $this->info('routes/api.php に下記コードを追加して下さい。');
            $this->line("Route::apiResource('{$this->replaces['DummyResourceSnakePlural']}', '{$this->replaces['DummyRelativeNamespace']}{$this->replaces['DummyResourceCamelSingular']}Controller');");
            $this->line('');
            $this->info('app/Providers/DeferServiceProvider.php に下記コードを追加して下さい。');
            $this->line("use App\\Services\\{$modelClass}Service;

    public function register()
    {
        \$this->app->singleton({$modelClass}Service::class, function (\$app) {
            return new {$modelClass}Service();
        });
    }

    public function provides()
    {
        return [
            {$modelClass}Service::class,
        ];
    }
            ");
        }
    }

    protected function buildDummiesReplacements(array $replaces, $name)
    {
        // コメント用に使いたい
        $this->replaces = $replaces;

        return $replaces;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if ($this->option('api') && $this->option('model')) {
            return __DIR__ . '/stubs/controller.model.api.stub';
        }

        return parent::getStub();
    }
}
