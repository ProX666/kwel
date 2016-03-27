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
        $this->action = ucfirst($action);
        $this->process();
    }

    
    protected function process() {
        $csv = new Csv($this->title);

        foreach ($this->images as $image)
        {
            $exif = exif_read_data($image);

            if ($data = new Data($exif))
            {
                if ($data->hasDescription())
                {
                    $data->setDescription();

                    // create method name on type of action
                    $dataFnct = "set{$this->action}Attributes";
                    $cvsFnct = "write{$this->action}Csv";

                    if ($data->$dataFnct())
                    {
                        $data->setLocation();
                        $data->setImage($exif['FileName']);
                        $csv->addData($data->getAttributes());
                    }
                }
            }
        }
        $csv->$cvsFnct();
    }


}