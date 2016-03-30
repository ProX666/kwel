<?php

/**
 * Csv_Info
 *
 * Write CSV file for info
 */
Class Csv_Info extends Csv_Base
{

    public function writeCsv()
    {
        parent::writeCsv();

        fputcsv($this->out, array("lng", "lat", "photo", "text"));

        foreach ($this->csv_data as $data)
        {
            fputcsv($this->out, array(
                "{$data['location']['lng']}",
                "{$data['location']['lat']}",
                "{$data['image']}",
                "{$data['info']}"
            ));
        }

        parent::close();
    }

}