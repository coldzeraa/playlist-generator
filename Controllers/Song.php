<?php

class Controllers_Song extends Controllers_Base{

    public function __construct(Views_Base $view, array $params){
        parent::__construct($view, $params);
    }

    public function get(){
        $this->view->render(2);
    }
}