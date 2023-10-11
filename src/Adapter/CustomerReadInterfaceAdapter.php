<?php

namespace App\Adapter;

interface CustomerReadInterfaceAdapter
{
    public function getFirstName(): string;
    public function getLastName(): string;
    public function getBillingAddress(): AddressReadInterface;
}