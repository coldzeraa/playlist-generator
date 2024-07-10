<?php

class Controllers_Generator extends Controllers_Base{
    private $model;

    public function __construct(Views_Base $view, array $params){
        parent::__construct($view, $params);
        $this->model = new Models_Playlist();
    }

    public function get() {
        $this->view->render(null);
    }

    public function post() {

        

    }
}