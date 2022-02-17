<?php

namespace app\test\controller;

class Abc
{
    public function index($food = 'Apple')
    {
        return 'Eating ' . $food;
    }
}
