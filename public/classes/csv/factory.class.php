<?php

class Csv_Factory
{

    public function create($type, $title)
    {
        switch ($type) {
            case "kwel" :
                    return new Csv_Kwel($title);
                break;
            case "info" :
                    return new Csv_Info($title);
                break;
        }
    }

}