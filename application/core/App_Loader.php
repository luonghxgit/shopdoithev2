<?php

class App_Loader {

    var $modules;
    var $loadded;
    var $modules_dir;

    public function __construct() {
        
        $this->modules_dir = APPPATH . 'modules';
        $this->loadded = array();
        $this->modules = array();
        log_message('debug', "App_Loader Class Initialized");
    }

    function pre_system() {
        $varient_object_file = APPPATH . 'libraries/VarienObject.php';
        $this->load($varient_object_file, false);
    }

    function load($file, $load_ci = true) {
        if ($load_ci) {
            $_this = $ci = $CI = &get_instance();
            $menu = $_this->menu;
        }
        if (!in_array($file, $this->loadded) && file_exists($file)) {
            include $file;
            $this->loadded[] = $file;
        }
    }

    function get_all_module() {
        $modules = array();
        $modules_dir = $this->modules_dir;
        $dirlist = scandir($modules_dir);
        foreach ($dirlist as $module) {
            if ($module != '.' && $module != '..') {
                $module_dir = $modules_dir . '/' . $module;
                if (is_dir($module_dir)) {
                    $modules[$module] = array('name' => $module, 'path' => $module_dir);
                }
            }
        }
        $this->modules = $modules;
        return $modules;
    }

}