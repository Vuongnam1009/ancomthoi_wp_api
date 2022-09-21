<?php
$log_directory = dirname(__FILE__);
$results_array = array();

if (is_dir($log_directory)) {
    if ($handle = opendir($log_directory)) {
        //Notice the parentheses I added:
        while (($file = readdir($handle)) !== FALSE) {
            $results_array[] = $file;
        }
        closedir($handle);
    }
}

foreach ($results_array as $value) {
    $fileName = Str_replace(".php", "", $value);
    if ($fileName !== "index") {
        $obj = new stdClass();
        $file = ANCOMTHOI_REST_API_PATH . '/routers/' . $fileName . ".php";
        if (file_exists($file)) {
            require_once $file;
            $routerName = $fileName . '_Router';
            $obj = new $routerName();
        }
    }
}
