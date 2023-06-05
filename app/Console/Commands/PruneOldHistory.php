<?php

namespace App\Console\Commands;

use App\Models\History;
use Illuminate\Console\Command;

class PruneOldHistory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'history:prune-old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune old history';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $date = now()->subMonths(1);

        History::query()->where('created_at', '<', $date)->delete();

        $this->components->info('Pruned old history.');
    }
}
