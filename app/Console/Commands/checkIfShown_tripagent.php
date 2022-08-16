<?php

namespace App\Console\Commands;

use App\Models\Tripagent;
use Carbon\Carbon;
use Illuminate\Console\Command;

class checkIfShown_tripagent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkIfShown:tripagent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show tripagent dependon status and time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date_hour= Carbon::now();
        
        $levelone = Tripagent::Level1()->latest()->get();
            if($levelone->isNotEmpty())
            {
                \Log::info($levelone->contains('is_show', 1));
                if($levelone->contains('is_show', 1)){

                   $as = false;
                    foreach ($levelone as  $tripagent) {
                        //howzn   // samsoung // iphone
                        \Log::info(Carbon::now()->diff($tripagent->hour)->format('%H:%I:%S'));
                        if($tripagent->is_show &&  (Carbon::now()->diff($tripagent->hour)->format('%H:%I:%S')) >=  "01:00:00"  )
                        {
                            $as = true;
                            \Log::info('hide');
                            \Log::info('true 1');
                            $tripagent->update(['is_show' => 0 , 'hour' => Null , 'show_before' => 1]);
                        }
                        elseif(!$tripagent->is_show && !$tripagent->show_before &&  $as )
                        {
                            $as = false;
                            \Log::info('show');
                            \Log::info('false 2');
                            $tripagent->update(['is_show' => 1 , 'hour' => $date_hour , 'show_before' => 1]);
                            break;
                            
                        }else{
    
                            \Log::info('false 3');
                            //update all shown before 
                            $allShownBeforeAgents = Tripagent::Level1()->where(['show_before' => 1 , 'is_show' => 0])->latest()->get();
    
                            $allShownBeforeAgents->each->update(['show_before' => 0 ]);
    
                        }
                    }

                }else{

                    $levelone1 = Tripagent::Level1()->first();
                    $levelone1->update(['is_show' => 1 , 'hour' => $date_hour , 'show_before' => 1]);

                }
              
    
            }
    }

}

