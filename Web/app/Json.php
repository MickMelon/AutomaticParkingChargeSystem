<?php
namespace App;

class Json
{
    private $data;

    public function __construct($data)
    {
        $this->data = json_encode($data);
    }

    public function execute()
    {
        header('Content-Type: application/json');
        echo $this->data;
    }
}