<?php

class Action
{

    protected $title;
    protected $images;

    public function __construct($action, $images)
    {
        $this->title = $action . "_data";
        $this->images = $images;
        $this->{"$action"}();
    }

    protected function kwel()
    {
        $csv = new Csv($this->title);

        foreach ($this->images as $image)
        {
            // only get kwel images with integer value at beginning of ImageDescription (that is in microSiemens)
            $exif = exif_read_data($image);

            if ($kwel = new Data($exif))
            {
                if ($kwel->hasDescription())
                {
                    $kwel->setDescription();
                    if ($kwel->setKwelAttributes())
                    {
                        $kwel->setLocation();
                        $kwel->setImage($exif['FileName']);
                        $csv->addData($kwel->getAttributes());
                    }
                }
            }
        }
        $csv->writeKwelCsv();
    }

    protected function info()
    {
        $csv = new Csv($this->title);

        foreach ($this->images as $image)
        {
            // only get text data images, so beginning is without Siemens data
            $exif = exif_read_data($image);

            if ($info = new Data($exif))
            {
                if ($info->hasDescription())
                {
                    $info->setDescription();
                    if ($info->setInfoAttributes())
                    {
                        $info->setLocation();
                        $info->setImage($exif['FileName']);
                        $csv->addData($info->getAttributes());
                    }
                }
            }
        }

        $csv->writeInfoCsv();
    }

}