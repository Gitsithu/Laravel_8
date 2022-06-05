<?php

namespace App\Repository\Order_detail;

use App\Repository\Log\LogRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Models\Order;
use App\Core\ReturnMessage;

class OrderDetailRepository implements OrderDetailRepositoryInterface
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
        
        $order_id = $paramObj->order_id;
        $currentUser = Order::where('id',$order_id)->value('user_id');

        try {
            $date    = date("Y-m-d H:i:s");
            $paramObj->save();

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' order product = '.$paramObj->product_id . PHP_EOL;
            $this->repo->create($message);

            $returnedObj['laravelStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (\Exception $e) {
            
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
        
        $order_id = $paramObj->order_id;
        $currentUser = Order::where('id',$order_id)->value('user_id');

        try {
            $date    = date("Y-m-d H:i:s");
            $paramObj->update();

            //create info log
            //$date = $paramObj->created_at;

            $message = '['. $date .'] '. 'info: ' . 'User '.$currentUser.' updated order = '.$paramObj->product_id . PHP_EOL;
            //LogCustom::create($date, $message);

            $returnedObj['laravelStatusCode'] = ReturnMessage::OK;
            return $returnedObj;
        } catch (\Exception $e) {
            //create error log
            
            $message = '['. $date .'] '. 'error: ' . 'User '.$currentUser.' updated an order and got error -------'.$e->getMessage(). ' ----- line ' .$e->getLine(). ' ----- ' .$e->getFile(). PHP_EOL;
            //LogCustom::create($date, $message);

            $returnedObj['laravelStatusMessage'] = $e->getMessage();
            return $returnedObj;
        }
    }
}