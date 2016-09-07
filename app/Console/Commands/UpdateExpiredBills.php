<?php

namespace Tamkeen\Ajeer\Console\Commands;

use Illuminate\Console\Command;
use Tamkeen\Ajeer\Models\Invoice;

class UpdateExpiredBills extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'dream:update-expired-bills';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire old bills.';
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $count = Invoice::pending()->expired()->count();
        
        Invoice::pending()->expired()->update(['status' => Invoice::STATUS_EXPIRED]);
        
        $this->info("Expired $count bills.");
    }
}
