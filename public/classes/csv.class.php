<?php

class Csv
{

    protected $csv_data;

    function __construct()
    {
        $this->csv_data = array();
    }

    public function addKwel($attr)
    {
        $this->csv_data[] = $attr;
    }

    public function getKwel() {
        return $this->csv_data;
    }

    /**
     * array(2) {
     *  ["kwel"]=> array(5) {
     *      [0]=> int(209) [1]=> string(0) "" [2]=> string(0) "" [3]=> string(0) "" [4]=> string(0) ""
     *  }
     *  ["location"]=> array(2) {
     *      ["lng"]=> float(6.5290033333333) ["lat"]=> float(53.157741666667) }
     *  }
     */
    public function writeCsv()
    {
        $title = 'Kwel';
        header("Content-type: text/csv");
        header("Content-disposition: attachment;filename={$title}.csv");

        $out = fopen('php://output', 'w');

        fputcsv($out, array("lng", "lat", "microsiemens", "X1", "X2", "X3", "X4", "photo"));

        foreach ($this->csv_data as $data)
        {
                fputcsv($out, array(
                    "{$data['location']['lng']}",
                    "{$data['location']['lat']}",
                    "{$data['kwel'][0]}",
                    "{$data['kwel'][1]}",
                    "{$data['kwel'][2]}",
                    "{$data['kwel'][3]}",
                    "{$data['kwel'][4]}",
                    "{$data['image']}"));

        }

        fclose($out);
    }

}
