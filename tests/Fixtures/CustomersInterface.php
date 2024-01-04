<?php

namespace App\Tests\Fixtures;

interface CustomersInterface
{
    //valid
    public function countZero(): array;
    public function countFive(): array;
    public function first(): array;
    public function second(): array;
    public function third(): array;
    public function fourth(): array;
    public function fifth(): array;
    public function minId(): array;
    public function maxId(): array;

    //invalid
    public function withoutId(): array;
    public function withoutEmail(): array;
    public function maxIdOver(): array;
    public function minIdLess(): array;
    public function double(): array;
}