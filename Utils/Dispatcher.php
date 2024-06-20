<?php
class Utils_Dispatcher {
    public static function dispatch() {
        $url_elements = explode("/", $_SERVER["PATH_INFO"] ?? '/song'); // Default to /song if PATH_INFO is not set
        $resource_type = ucfirst($url_elements[1]); // ucfirst to ensure the controller class name starts with a capital letter
        $path_params = array_slice($url_elements, 2);

        $view_type = "Views_Html";
        $view = new $view_type($resource_type, $path_params);

        $controller_name = "Controllers_" . $resource_type;
        if (class_exists($controller_name)) {
            $controller = new $controller_name($view, $path_params);
            $verb = strtolower($_SERVER["REQUEST_METHOD"]);
            if (method_exists($controller, $verb)) {
                $controller->$verb();
            } else {
                throw new Exception("Method $verb not found in controller $controller_name");
            }
        } else {
            throw new Exception("Controller $controller_name not found");
        }
    }
}

