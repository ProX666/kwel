<?php

class Action
{

    protected $title;
    protected $images;
    protected $action;

    public function __construct($action, $images)
    {
        $this->title = $action . "_data";
        $this->images = $images;
        $this->action = $action;
        $this->process();
    }

    protected function process() {
        $csvfactory = new Csv_Factory();
        $csv = $csvfactory->create($this->action, $this->title);

        $datafactory = new Data_Factory();

        foreach ($this->images as $image)
        {
            $exif = exif_read_data($image);

            if ($data = $datafactory->create($this->action, $exif))
            {
                if ($data->hasDescription())
                {
                    $data->setDescription();

                    if ($data->setAttributes())
                    {
                        $data->setLocation();
                        $data->setImage($exif['FileName']);
                        $csv->addData($data->getAttributes());
                    }
                }
            }
        }
        $csv->writeCsv();
    }


}