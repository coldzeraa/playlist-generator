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
        $songModel = new Models_Song();

        if (isset($_GET["mood"])) {
            $songs = $songModel->findByMood($_GET['mood']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if (isset($_GET["genre"])) {
            $songs = $songModel->findByGenre($_GET['genre']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else {
            $moods = $songModel->findAllMoods();
            $genres = $songModel->findAllGenres();

            $data["moods"] = $moods;
            $data["genres"] = $genres;

            $this->view->render($data);
        }
    }

    private function sendJsonResponse(array $data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getRandomSongs(array $songs): array
    {
        $result = [];
        $totalSongs = count($songs);

        if ($totalSongs <= 10) {
            return $songs;
        }

        $selectedIndexes = [];

        while (count($result) < 10) {
            $randomIndex = rand(0, $totalSongs - 1);

            if (!in_array($randomIndex, $selectedIndexes)) {
                $result[] = $songs[$randomIndex];
                $selectedIndexes[] = $randomIndex;
            }
        }

        return $result;
    }


    public function post()
    {
        $obj = new Domains_User($_POST);
        $users = $this->model->findAll();

        if ($this->checkIfUserExists($obj, $users) == 0) {
            header('Content-Type: application/json');
            echo json_encode("0");
            $data = $this->model->findByUsername($obj->username);
            Utils_Login::register_session($data->id, $data->username);
        } else if($this->checkIfUserExists($obj, $users) == -1) {
            header('Content-Type: application/json');
            echo json_encode("0");
            $data = $this->model->insert($obj);
            Utils_Login::register_session($data->id, $data->username);
        }else if($this->checkIfUserExists($obj, $users) == 1) {
            header('Content-Type: application/json');
            echo json_encode(-1);
            exit;
        }


    }

    private function checkIfUserExists(Domains_User $user, array $users): int
    {
        foreach ($users as $element) {
            if ($element->username == $user->username && $element->password == $user->password) {
                return 0;
            }else if($element->username == $user->username && $element->password != $user->password){
                return 1;
            }
        }
        return -1;
    }
}
