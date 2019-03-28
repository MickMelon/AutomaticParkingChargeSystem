<?php
namespace App;

/**
 * Used for displaying a JSON result.
 */
class Json
{
    /**
     * The JSON data.
     */
    private $data;

    /**
     * Creates a new instance of the Json class.
     *
     * @param $data The data to be encoded in Json
     */
    public function __construct($data)
    {
        $this->data = json_encode($data);
    }

    /**
     * Displays the Json data.
     */
    public function execute()
    {
        header('Content-Type: application/json');
        echo $this->data;
    }
}