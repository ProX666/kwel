<?php

class Csv_Base
{

    protected $csv_data;
    protected $title;

    public function __construct($title)
    {
        $this->csv_data = array();
        $this->title = $title;
    }

    public function addData($attr)
    {
        $this->csv_data[] = $attr;
    }

    public function getData() {
        return $this->csv_data;
    }

}
