<?php

class Controllers_Song extends Controllers_Base{
    private $model;

    public function __construct(Views_Base $view, array $params){
        parent::__construct($view, $params);
        $this->model = new Models_Song();
    }

    public function get() {
        echo("GET-Controllers_Song");
        if ($this->params) {
            $data = $this->model->findById($this->params[0]);
        } else {
            $data = $this->model->findAll();
        }
        $this->view->render($data);
    }
}