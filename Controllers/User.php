<?php

class Controllers_User extends Controllers_Base{
    private $model;

    public function __construct(Views_Base $view, array $params){
        parent::__construct($view, $params);
        $this->model = new Models_User();
    }

    public function get() {

        error_log($this->params[0]);
        $data = $this->model->findByUsername($_SESSION["username"]);
        

        $this->view->render($data);
    }
}