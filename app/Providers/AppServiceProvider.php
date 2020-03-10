<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Validation\CustomValidator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Validator::resolver(function ($translator, $data, $rules, $messages, $attributes) {
            return new CustomValidator($translator, $data, $rules, $messages, $attributes);
        });
        $this->sqlLog();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
    }

    private function sqlLog(): void
    {
        \DB::listen(function ($query): void {
            $sql = $query->sql;

            for ($i = 0; $i < count($query->bindings); $i++) {
                $sql = preg_replace('/\\?/', $query->bindings[$i], $sql, 1);
            }

            \Log::debug('SQL', ['time' => sprintf('%.2f ms', $query->time), 'sql' => $sql]);
        });
    }
}
