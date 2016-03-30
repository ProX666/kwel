<?php

/**
 * Specific Kwel class
 */
class Data_Kwel extends Data_Base
{

    /**
     * Interesting images can have these attributes: microsiemens (, X1, X2, X3, X4)
     * Also add text if any.
     * @return boolean true: if any data otherwise: false
     */
    public function setAttributes()
    {
        // get all comma seperated data from the set description field, which contains exif:ImageDescription
        $arr = explode(",", $this->desc);

        // Check first element for microsiemens. If it is a number, it is a "kwel" location.
        $ms = array_shift($arr);
        if (is_numeric($ms))
        {
            // create default zeroes array with 5 elements for: microsiemens, X1, X2, X3, X4, text
            $this->attr['kwel'] = array_fill(0, 5, 0);
            // set microsiemens
            $this->attr['kwel'][0] = (integer) $ms;

            // reset string
            $text = "";

            // add kwel code X1, ... X4 if any as 1 on the right spot
            foreach ($arr as $value)
            {
                // find next position for a Xn
                if (strpos($value, 'X'))
                {
                    // strip number and use it as index
                    preg_match_all('!\d+!', $value, $matches);
                    $idx = implode(' ', $matches[0]);
                    // set Xn to 1 (indicating the Xn is found)
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

}