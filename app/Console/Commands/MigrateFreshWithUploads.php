<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class MigrateFreshWithUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:fresh-seed-clear-uploads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh a migration with seeder and deletes the upload directory.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Delete uploaded files
        Storage::disk('public_uploads')->deleteDirectory('uploads');

        // Run fresh migrations with seed
        Artisan::call('migrate:fresh --seed');

        $this->info('Database and uploaded files reset.');
    }
}
