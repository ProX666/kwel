<?php

/**
 * Action
 *
 * Process photos and create CSV file.
 */
class Action
{

    protected $title;
    protected $images;
    protected $action;

    /**
     * Set vars and start process.
     *
     * @param string $action
     * @param array $images
     */
    public function __construct($action, $images)
    {
        $this->title = $action . "_data";
        $this->images = $images;
        $this->action = $action;
        $this->process();
    }

    /**
     * Create CSV file, process photos and write CSV data in file.
     */
    protected function process() {
        // create specific CSV file for: kwel or info
        $csvfactory = new Csv_Factory();
        $csv = $csvfactory->create($this->action, $this->title);

        $datafactory = new Data_Factory();

        // process all images
        foreach ($this->images as $image)
        {
            $exif = exif_read_data($image);

            // only process image with exif data
            if ($data = $datafactory->create($this->action, $exif))
            {
                // only process image with ImageDescription (=caption)
                if ($data->hasDescription())
                {
                    // set desc var to get attributes in later stadium
                    $data->setDescription();

                    // set attributes for kwel or info
                    if ($data->setAttributes())
                    {
                        // set locations
                        $data->setLocation();

                        // set image filename
                        $data->setImage($exif['FileName']);

                        // add collected and specific data to CSV
                        $csv->addData($data->getAttributes());
                    }
                }
            }
        }
        $csv->writeCsv();
    }


}