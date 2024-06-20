<?php

class Controllers_Dashboard extends Controllers_Base
{
    private $model;

    public function __construct(Views_Base $view, array $params)
    {
        parent::__construct($view, $params);
        $this->model = new Models_User();
    }

    public function get()
    {
        $this->view->render(null);
    }

    public function post()
    {

        $data = array();

        $this->view->render($data);
    }
}
