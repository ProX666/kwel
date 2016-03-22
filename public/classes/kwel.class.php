<?php

class Kwel
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
     * Interesting images can have these attributes: microsiemens (, X1, X2, X3, X4)
     * @return
     */
    public function setKwelAttributes()
    {
        $arr = explode(",", $this->desc);

        // check for microsiemens
        $ms = array_shift($arr);

        if (is_numeric($ms))
        {
            // create empty array with 5 elements for: microsiemens, X1, X2, X3, X4
            $this->attr['kwel'] = array_fill(0, 5, '');
            // set microsiemens
            $this->attr['kwel'][0] = (integer) $ms;

            // add kwel code X1, ... X4 if any on the right spot
            foreach ($arr as $value)
            {
                if (strpos($value, 'X'))
                {
                    // strip number and use it as index
                    preg_match_all('!\d+!', $value, $matches);
                    $idx = implode(' ', $matches[0]);
                    $this->attr['kwel'][$idx] = trim($value);
                }

            }

            return true;
        }

        return false;

    }

    /**
     *
     * @return attributes or false if empty
     */
    public function getKwelAttributes()
    {
        return !empty($this->attr) ? $this->attr : false;
    }

    public function setLocation()
    {
        $this->attr['location']['lng'] = $this->getGps($this->exif["GPSLongitude"], $this->exif['GPSLongitudeRef']);
        $this->attr['location']['lat'] = $this->getGps($this->exif["GPSLatitude"], $this->exif['GPSLatitudeRef']);
    }

    public function getLng() {
        return $this->attr['location']['lng'];
    }

    public function getLat() {
        return $this->attr['location']['lat'];
    }

    protected function getGps($exifCoord, $hemi)
    {
        $degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
        $minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
        $seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;
        $flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

        return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
    }

    protected function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

}