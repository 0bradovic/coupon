<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Offer;
use App\OfferClick;
use Carbon\Carbon;

class UpdateClick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:clicks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will delete all offer clicks older than 1 day.';

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
     * @return mixed
     */
    public function handle()
    {
        $date = Carbon::now()->subHours(24);
        $clicks = OfferClick::where('created_at','<',$date)->get();
        foreach($clicks as $click)
        {
            $click->delete();
        }
        $offers = Offer::all();
        foreach($offers as $offer)
        {
            if(count($offer->offerClicks) > 0)
            {
                $offer->click = count($offer->offerClicks);
                $offer->save();
            }
            else
            {
                $offer->click = 0;
                $offer->save();
            }
        }
    }
}