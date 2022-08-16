<?php

namespace App\Console\Commands;

use App\Models\PopupSliderPhoto;
use Illuminate\Console\Command;
use Carbon\Carbon;

class showpopphoto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'popup_photoslider';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'show images when photo status active and not expired';

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
       $showslider=PopupSliderPhoto::select('id','photo','expired_at')
       ->where('status','active')
       ->where('expired_at','<',$today)
       ->get();
        foreach($showslider as $pop)
        {
        PopupSliderPhoto::where('id',$pop->id)->update([
        'status'=>'notactive',
        ]);

        }
            }
}
