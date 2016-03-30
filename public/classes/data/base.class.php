<?php
/**
 * Base class for data processing on kwel or info
 */
class Data_Base
{

    protected $exif;
    protected $desc;
    protected $attr;

    function __construct($exif)
    {
        if (!empty($exif))
        {
            $this->exif = $exif;
            $this->attr = array();
            return true;
        }

        return false;
    }

    public function hasDescription()
    {
        return !empty($this->exif['ImageDescription']);
    }

    public function setDescription()
    {
        $this->desc = $this->exif['ImageDescription'];
    }


    /**
     *
     * @return attributes or false if empty
     */
    public function getAttributes()
    {
        return !empty($this->attr) ? $this->attr : false;
    }

    public function setLocation()
    {
        $loc = new Location($this->exif);

        $this->attr['location']['lng'] = $loc->getLng();
        $this->attr['location']['lat'] = $loc->getLat();
    }

    public function setImage($image)
    {
        $this->attr['image'] = $image;
    }

}