<?php

namespace App\Repository\Order;


interface OrderRepositoryInterface
{

    public function create($paramObj);
    public function update($paramObj);
}

?>