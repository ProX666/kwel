<?php

// auto class loader
//function __autoload($class)
//{
//    require_once 'classes/' . $class . '.class.php';
//}

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

// get all images
$dirname = "G:/__STUDIE VAN HALL 2015 - 2016/jaar 2015-2016/stage/qgis/kwel/jpg/";
$images = glob($dirname . "*.jpg");

// http://kwel.local/?action=kwel
// http://kwel.local/?action=info


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
