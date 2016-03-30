<?php
/**
 * Some code to process photo data for locations during my internship @Onlanden.
 *
 * Photos should be JPG and given a "caption" in Lightroom (which is transformed to "title" during export (?)
 *
 * For "kwel" locations, use alwasy consistently: microsiemens, (X1, X2, X3, X4, text) > i.e. the caption looks like: 213, X3, uitvlokking
 * For "info" locations, just use comma delimited text > peilbuis, uittreedplek
 *
 * The photos are processed to CSV files.
 *
 * Call: kwel.local/?action= parameters: info or kwel
 */

// autoloader for classes
function __autoload($class_name)
{
    $filename = str_replace('_', DIRECTORY_SEPARATOR, strtolower($class_name)).'.class.php';

    $file = 'classes/' . $filename;

    if ( ! file_exists($file))
    {
        return FALSE;
    }
    require_once $file;
}

// get all images for a given path
$dirname = "G:/__STUDIE VAN HALL 2015 - 2016/jaar 2015-2016/stage/qgis/kwel/jpg/";
$images = glob($dirname . "*.jpg");

// process GET action
switch ($_GET['action'])
{
    case "info" :
        $action = "info";
        break;
    case "kwel":
    default:
        $action = "kwel";
}

new Action($action, $images);
