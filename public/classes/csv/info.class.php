<?php

Class Csv_Info extends Csv_Base
{

    public function writeCsv()
    {
        header("Content-type: text/csv");
        header("Content-disposition: attachment;filename={$this->title}.csv");

        $out = fopen('php://output', 'w');

        fputcsv($out, array("lng", "lat", "photo", "text"));

        foreach ($this->csv_data as $data)
        {
            fputcsv($out, array(
                "{$data['location']['lng']}",
                "{$data['location']['lat']}",
                "{$data['image']}",
                "{$data['info']}"
            ));
        }

        fclose($out);
    }

}