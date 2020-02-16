<?php

namespace App\Console\Commands\Make;

use Illuminate\Database\Migrations\MigrationCreator;

class Migrate extends MigrationCreator
{
    /**
     * Get the stub file for the generator.
     *
     * @param mixed $table
     * @param mixed $create
     *
     * @return string
     */
    protected function getStub($table, $create)
    {
        if (!$create) {
            return parent::getStub($table, $create);
        }

        return $this->files->get(__DIR__ . '/stubs/migration-create.stub');
    }
}
