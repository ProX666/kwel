<?php

/**
 * Csv_Kwel
 *
 * Write CSV file for kwel
 */
Class Csv_Kwel extends Csv_Base
{

    public function writeCsv()
    {
        parent::writeCsv();

        fputcsv($this->out, array("lng", "lat", "microsiemens", "X1", "X2", "X3", "X4", "photo", "text"));
        foreach ($this->csv_data as $data)
        {
                fputcsv($this->out, array(
                    "{$data['location']['lng']}",
                    "{$data['location']['lat']}",
                    "{$data['kwel'][0]}",
                    "{$data['kwel'][1]}",
                    "{$data['kwel'][2]}",
                    "{$data['kwel'][3]}",
                    "{$data['kwel'][4]}",
                    "{$data['image']}",
                    "{$data['kwel'][5]}"
                    ));

        }

        parent::close();
    }

}