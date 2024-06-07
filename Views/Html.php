<?php

class Views_Html extends Views_Base{

    public function render($data){

        if(is_array($data)) {
            $template = "table.phtml";
        } else {
            $template = "object.phtml";
        }    

        # $template = "helloWorld.phtml";
        if (is_readable(dirname("__FILE__") . "/templates/") . strtolower($this->resource_name) . "/" . $template) {
            $template = strtolower($this->resource_name) . "/" . $template;
        }
        include "templates/" . $template;
        exit;
    }
}
