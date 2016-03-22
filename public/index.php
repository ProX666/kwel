<?php

// auto class loader
function __autoload($class)
{
    require_once 'classes/' . $class . '.class.php';
}

// get all images
$dirname = "G:/__STUDIE VAN HALL 2015 - 2016/jaar 2015-2016/stage/fotos/03 16 kwel/jpg/";
$images = glob($dirname . "*.jpg");

$csv = new Csv();

foreach ($images as $image)
{
    // only get images with integer value at beginning of ImageDescription (that is in microSiemens)

    $exif = exif_read_data($image);

    if ($kwel = new Kwel($exif)) {
        if ($kwel->hasDescription()) {
            $kwel->setDescription();
            if ($kwel->setKwelAttributes()) {
                $kwel->setLocation();
                $csv->addKwel($kwel->getKwelAttributes());
            }

        }
    }
}
$csv->writeCsv();