<?php

namespace Bitaac\Core\Console\Commands;

use Bitaac\Contracts\Account;
use Illuminate\Console\Command;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bitaac:admin:make {account_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update given account with admin rights.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Account $account)
    {
        $account = $account->where('name', $name = $this->argument('account_name'));

        if (! $account->exists()) {
            return $this->error('No account could be found.');
        }

        $account = $account->first();

        if ($account->bitaac->admin == 1) {
            return $this->comment(vsprintf(
                'Account %s already have admin rights.'
            , $name));
        }

        $proceed = $this->choice(vsprintf(
            'Are you sure you want to give account %s admin rights?'
        , $name), ['yes', 'no'], 1);

        if ($proceed == 'no') {
            return false;
        }

        $account->bitaac->admin = 1;
        $account->bitaac->save();

        return $this->info(vsprintf(
            'Account %s has been granted admin rights.'
        , $name));
    }
}
