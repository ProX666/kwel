<?php

class Csv_Factory
{

    public function create($type, $title)
    {
        // Can also be written like this:
        $call = "Csv_" . ucfirst($type);
        return new $call($title);

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