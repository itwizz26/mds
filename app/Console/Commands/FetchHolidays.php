<?php

namespace App\Console\Commands;

use App\Calendar;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;

class FetchHolidays extends Command
{
    private $base = "https://kayaposoft.com/enrico/json/";
    private $uri = "v2.0?action=getHolidaysForYear&year={year}&country=zaf&holidayType=public_holiday";

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'holidays:fetch {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches all the South African holidays for a given year.';

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
        echo "Start: Saving holidays...\n";

        $year = $this->argument('year');

        if ($year && is_numeric ($year) && strlen ($year) == 4)
        {
            // guzzle client
            $client = new Client();
            
            $response = $client->request('GET', $this->base . str_replace("{year}", $year, $this->uri), [
                'verify'  => false,
            ]);

            $responseBody = json_decode ($response->getBody(), true);

            foreach ($responseBody as $result) 
            {
                if (is_array ($result))
                {
                    $date = $result['date'];
                    $name = $result['name'];

                    $calendar = new Calendar();
                    $calendar->date = $date;
                    $calendar->name = $name;
                    
                    $calendar->save();
                }
            }

            echo "Finished: saving Holdays!\n";
        }
        else {
            echo "Please specify a 4 digit year number!";
        }

        return 0;
    }
}
