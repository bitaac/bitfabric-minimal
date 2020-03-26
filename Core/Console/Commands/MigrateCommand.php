<?php

namespace Bitaac\Core\Console\Commands;

use Schema;
use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Console\Migrations\MigrateCommand as BaseMigrateCommand;

class MigrateCommand extends BaseMigrateCommand
{
    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Database\Migrations\Migrator  $migrator
     * @return void
     */
    public function __construct(Migrator $migrator)
    {
        parent::__construct($migrator);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
    */
    public function handle()
    {
        if (! Schema::hasTable('accounts') || ! Schema::hasTable('players')) {
            return $this->error('The default TFS scheme has not been imported to the database yet.');
        }

        parent::handle();
    }
}
