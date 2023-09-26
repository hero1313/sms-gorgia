<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Redirect;
use App\Models\Employee;
use GrahamCampbell\ResultType\Success;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BirthdayMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:birthday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to send birthday messages';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $number = array("+995599539300", "+995511200657");

        foreach ($number as $single) {
            $client = new \GuzzleHttp\Client();
            $res = $client->get('http://81.95.160.47/mt/oneway?username=gorgia&password=Gor480&client_id=480&service_id=1&to='. $single .'&text=Test');
            echo $res->getStatusCode(); // 200
            echo $res->getBody();

        }
    }
}
