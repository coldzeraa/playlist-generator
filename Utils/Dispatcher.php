<?php

class Utils_Dispatcher{

    public static function dispatch(){
        $url_elements = explode("/", $_SERVER["PATH_INFO"]);
        $resource_type = $url_elements[1];
        $path_params = array_slice($url_elements, 2);

        $view_type = "Views_Html";
        $view = new $view_type($resource_type, $path_params);

        $controller_name = "Controllers_" . $resource_type;
        $controller = new $controller_name($view, $path_params);
        $verb = strtolower($_SERVER["REQUEST_METHOD"]);

        $controller->$verb();
    }

}