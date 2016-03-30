<?php

/**
 * Specific Info class
 */
class Data_Info extends Data_Base
{

    // Add comma seperated text to attributes if it has no microsiemens
    public function setAttributes()
    {
        $arr = explode(",", $this->desc);

        // Skip image if it has microsiemens at start
        if (!is_numeric($arr[0]))
        {
            $this->attr['info'] = trim(implode(", ", $arr));

            return true;
        }

        return false;
    }

}