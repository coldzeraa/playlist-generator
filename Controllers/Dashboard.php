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
        echo("GET - Controllers_Dashboard");
        $this->view->render(null);
    }

    public function post()
    {
        echo ("POST - Controllers_Dashboard");
        $obj = new Domains_User($_POST);
        $data = $this->model->insert($obj);

        $this->view->render($data);
    }
}
