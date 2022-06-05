<?php

namespace App\Repository\Log;

use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Core\ReturnMessage;

class LogRepository implements LogRepositoryInterface
{

    public function create($message)
    {
        $returnedObj = array();
        $returnedObj['laravelStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        
        try {
            $date = date("Y-m-d");

            $log = new Log();
            $log->message = $message;
            $log->date    = $date;
            $log->save();
            
            $returnedObj['laravelStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (\Exception $e) {
            
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'Log Error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            
            $returnedObj['laravelStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }


}