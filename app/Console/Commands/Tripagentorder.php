<?php

namespace App\Console\Commands;

use App\Models\AdsRequests;
use Illuminate\Console\Command;

class Tripagentorder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Trpagent:orderstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show one tripagent depden on apperance_order and hidden two';

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
        $today=date("Y-m-d");
        $ads_list=AdsRequests::select('id','tripagent_id','appearance_order','expired_at','apperance_status')
        ->where('expired_at','>',$today)
        ->where('appearance_order','>',1)
        ->where('apperance_status','=','show')
        ->first();
         AdsRequests::where('id',$ads_list->id)->update([
         'apperance_status'=>'hidden',
         ]);
 
        
    }
}
