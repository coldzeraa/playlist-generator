<?php

class Views_Html extends Views_Base
{

    public function render($data)
    {
        // Determin which class called render() function
        $backtrace = debug_backtrace();
        $callerClass = isset($backtrace[1]['class']) ? $backtrace[1]['class'] : null;

        $template = "";

        // Dicide template based on the class that called render()
        switch ($callerClass) {
            case "Controllers_Dashboard":
                $template = "dashboardNotLoggedIn.phtml";
                break;
            case "Controllers_Song":
                if (is_array($data)) {
                    $template = "table.phtml";
                    break;
                } else {
                    $template = "object.phtml";
                    break;
                }
            case "Controllers_User":
                $template = "dashboardLoggedIn.phtml";
                break;
            case "Controllers_Playlist":
                if(is_array($data)) {
                    $template = "table.phtml";
                    break;
                }else{
                    $template = "object.phtml";
                    break;
                }
            case "Controllers_Generator":
                $template = "table.phtml";
                break;
        }

        if (is_readable(dirname("__FILE__") . "/templates/") . strtolower($this->resource_name) . "/" . $template) {
            $template = strtolower($this->resource_name) . "/" . $template;
        }

        include "templates/" . $template;
        exit;
    }
}
