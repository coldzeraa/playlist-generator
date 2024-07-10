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
        $obj = new Domains_User($_POST);
        $data = $this->model->insert($obj);
        
        Utils_Login::register_session($data->id, $data->username);

        $this->view->render($data);
    }
}
