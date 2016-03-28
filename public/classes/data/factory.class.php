<?php

class Data_Factory
{

    public function create($type, $exif)
    {
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