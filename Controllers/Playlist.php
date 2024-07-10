<?php

class Controllers_Playlist extends Controllers_Base{
    private $model;

    public function __construct(Views_Base $view, array $params){
        parent::__construct($view, $params);
        $this->model = new Models_Playlist();
    }

    public function get() {
        if ($this->params) {
            $data = $this->model->findById($this->params[0]);
        } else {
            $data = $this->model->findByUserID($_SESSION["id"]);
            //error_log($data);
        }
        $this->view->render($data);
    }
}