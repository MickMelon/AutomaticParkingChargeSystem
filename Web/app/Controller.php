<?php
namespace App;

abstract class Controller
{
    protected $params;

    protected function __construct(array $params)
    {
        $this->params = $params;
    }
}