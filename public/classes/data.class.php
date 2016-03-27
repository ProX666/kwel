<?php

class Data
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

    public function setInfoAttributes()
    {
        $arr = explode(",", $this->desc);

        // Skip image if it has microsiemens at start
        if (!is_numeric($arr[0]))
        {
            $this->attr['info'] = trim(implode (", ", $arr ));

            return true;
        }

        return false;
    }

    /**
     * Interesting images can have these attributes: microsiemens (, X1, X2, X3, X4)
     * Also add text if any.
     * @return
     */
    public function setKwelAttributes()
    {
        $arr = explode(",", $this->desc);

        // check for microsiemens
        $ms = array_shift($arr);

        if (is_numeric($ms))
        {
            // create zeroes array with 5 elements for: microsiemens, X1, X2, X3, X4, text
            $this->attr['kwel'] = array_fill(0, 5, 0);
            // set microsiemens
            $this->attr['kwel'][0] = (integer) $ms;

            // reset string
            $text = "";

            // add kwel code X1, ... X4 if any as 1 on the right spot
            foreach ($arr as $value)
            {
                if (strpos($value, 'X'))
                {
                    // strip number and use it as index
                    preg_match_all('!\d+!', $value, $matches);
                    $idx = implode(' ', $matches[0]);
                    $this->attr['kwel'][$idx] = 1;
                } else
                {
                    // It is not a Xn, so if there is anything left; it must be text
                    $text = trim($value);
                }
            }
            $this->attr['kwel'][5] = "{$text}";

            return true;
        }

        return false;
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