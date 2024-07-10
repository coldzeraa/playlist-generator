<?php

class Controllers_User extends Controllers_Base {
    private $model;

    public function __construct(Views_Base $view, array $params) {
        parent::__construct($view, $params);
        $this->model = new Models_User();
    }

    public function get() {
        $songModel = new Models_Song();

        // TODO not working
        $userData = $this->model->findByUsername($_SESSION["username"]);
        //$data = $this->model->findByUsername($_SESSION["username"]);

        // Convert the object to an array
        $data = (array)$userData;


        // Handle GET requests for generating playlists based on mood, genre, or artist
        if (isset($_GET["mood"])) {
            $songs = $songModel->findByMood($_GET['mood']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if (isset($_GET["genre"])) {
            $songs = $songModel->findByGenre($_GET['genre']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if (isset($_GET["artist"])) {
            $songs = $songModel->findByArtist($_GET['artist']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else {
            // Get all moods, genres, and artists
            $moods = $songModel->findAllMoods();
            $genres = $songModel->findAllGenres();
            $artists = $songModel->findAllArtists();

            $data["moods"] = $moods;
            $data["genres"] = $genres;
            $data["artists"] = $artists;

            $this->view->render($data);
        }
    }

    private function sendJsonResponse(array $data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    private function getRandomSongs(array $songs): array {
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

    public function post() {
        $obj = new Domains_User($_POST);
        $data = $this->model->insert($obj);

        Utils_Login::register_session($data->id, $data->username);

        $this->view->render($data);
    }
}
