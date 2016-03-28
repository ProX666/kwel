<?php

class Csv_Base
{

    protected $csv_data;
    protected $title;
    protected $out;

    public function __construct($title)
    {
        $this->csv_data = array();
        $this->title = $title;
    }

    public function addData($attr)
    {
        $this->csv_data[] = $attr;
    }

    public function getData()
    {
        return $this->csv_data;
    }

    protected function writeCsv()
    {
        header("Content-type: text/csv");
        header("Content-disposition: attachment;filename={$this->title}.csv");

        $this->out = fopen('php://output', 'w');
    }

    protected function close() {
        fclose($this->out);
    }

}
