<?php

namespace App\Repository\Order;

use App\Repository\Log\LogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

use App\Core\ReturnMessage;

class OrderRepository implements OrderRepositoryInterface
{
    private $repo;

    public function __construct(LogRepositoryInterface $repo)
    {
        $this->repo        = $repo;
    }

    public function create($paramObj)
    {
        $returnedObj = array();
        $returnedObj['laravelStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        
        $currentUser = $paramObj->user_id;
           
        try {
   
            $paramObj->save();
            //create info log
            $date = $paramObj->created_at;
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' created an order .' . PHP_EOL;
            $this->repo->create($message);

            $returnedObj['laravelStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (\Exception $e) {
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' created an order and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            $this->repo->create($message);

            $returnedObj['laravelStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }

    public function update($paramObj)
    {
        $returnedObj = array();
        $returnedObj['laravelStatusCode'] = ReturnMessage::INTERNAL_SERVER_ERROR;
        
        $currentUser = $paramObj->user_id;
           
        try {
   
            $paramObj->update();

            $date = date("Y-m-d");
            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' checkout order of total of '.$paramObj->final_cost .' with the discount = '.$paramObj->discount . PHP_EOL;
            $this->repo->create($message);

            $returnedObj['laravelStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (\Exception $e) {
            //create error log
            $date    = date("Y-m-d H:i:s");
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' checkout an order and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            //LogCustom::create($date, $message);

            $returnedObj['laravelStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}