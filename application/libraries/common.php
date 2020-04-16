<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common
{

    function element($type, $value, $class, $id, $name)
    {
        $element = '';
        switch ($type) {
            case 'text':
                {
                    $element = '<input class="' . $class . '" id="' . $id . '" name="' . $name . '" value="' . $value . '"/>';
                }
                break;
            case 'textarea':
                {
                    $element = '<textarea class="' . $class . '" id="' . $id . '" name="' . $name . '">' . $value . '</textarea>';
                }
                break;
        }

        echo $element;
    }

    function getSettingValue($idOrCode){

    }

}