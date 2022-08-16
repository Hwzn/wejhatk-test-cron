<?php

namespace App\Console\Commands;

use App\Models\AdsRequests;
use Illuminate\Console\Command;

class ads_listStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ads:liststatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change status of appearance_order of tripagent';

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
        // $datenow=date("Y-m-d H:i:s");
       $today=date("Y-m-d");
       $ads_list=AdsRequests::select('id','tripagent_id','appearance_order','expired_at')
       ->where('expired_at','<',$today)
       ->get();
        foreach($ads_list as $pop)
        {
            AdsRequests::where('id',$pop->id)->update([
        'status'=>'expired',
        ]);

        }
    }
}
