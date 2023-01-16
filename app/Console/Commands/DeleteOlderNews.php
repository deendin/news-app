<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteOlderNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:delete-older-records {noOfDays=14}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dispatches the job to delete older news records.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $noOfDays = $this->argument('noOfDays');

        $this->info("Deleting news older than $noOfDays days....");

        \App\Jobs\DeleteOlderNews::dispatch($this->argument('noOfDays'));

        $this->info("Successfully deleted news older than $noOfDays days.");
    }
}
