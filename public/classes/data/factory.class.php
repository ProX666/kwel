<?php

/**
 * Return object for kwel or info
 */
class Data_Factory
{

    public function create($type, $exif)
    {
        // Can also be written like this:
        // $call = "Data_" . ucfirst($type);
        // return new $call($exif);

        switch ($type) {
            case "kwel" :
                    return new Data_Kwel($exif);
                break;
            case "info" :
                    return new Data_Info($exif);
                break;
        }
    }

}