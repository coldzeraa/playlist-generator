<?php

class Utils_Dispatcher
{

    private const DASHBOARD = "Dashboard";

    public static function dispatch()
    {
        if (isset($_SERVER["PATH_INFO"])) {
            $url_elements = explode("/", $_SERVER["PATH_INFO"]);
            $resource_type = $url_elements[1];
            $path_params = array_slice($url_elements, 2);
        } else {
            $resource_type = self::DASHBOARD;
            $path_params = array();
        }

        $view_type = "Views_Html";
        $view = new $view_type($resource_type, $path_params);

        $controller_name = "Controllers_" . $resource_type;
        $controller = new $controller_name($view, $path_params);
        $verb = strtolower($_SERVER["REQUEST_METHOD"]);

        $controller->$verb();
    }
}
