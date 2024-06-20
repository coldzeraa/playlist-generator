<?php
require_once 'Models/Song.php';
require_once 'Domains/Song.php';

class Controllers_Song extends Controllers_Base {
    protected $model;

    public function __construct(Views_Base $view, array $params) {
        parent::__construct($view, $params);
        $this->model = new Models_Song();
        $this->initializeModel();
    }

    protected function initializeModel() {
        $this->model = new Models_Song();
    }

    public function get() {
        if ($this->params) {
            $data = $this->model->findById($this->params[0]);
        } else {
            $data = $this->model->findAll();
        }
        $this->view->render($data);
    public function get() {
        $this->view->render(2);
    }

    public function post() {
        $this->filter();
    }

    public function filter() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $artist = $_POST['artist'] ?? null;
            $genre = $_POST['genre'] ?? null;
            $mood = $_POST['mood'] ?? null;

            $conditions = [];
            $params = [];

            if ($artist) {
                $conditions[] = "artist = :artist";
                $params[':artist'] = $artist;
            }
            if ($genre) {
                $conditions[] = "genre = :genre";
                $params[':genre'] = $genre;
            }
            if ($mood) {
                $conditions[] = "mood = :mood";
                $params[':mood'] = $mood;
            }

            $query = "SELECT * FROM song";
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }

            try {
                $statement = $this->model->getConnection()->prepare($query);
                $statement->execute($params);
                $songs = $statement->fetchAll(PDO::FETCH_ASSOC);
                $this->view->render(["songs" => $songs]);
            } catch (PDOException $e) {
                $this->view->render(["error" => "Fehler beim Filtern der Songs: " . $e->getMessage()]);
            }
        }
    }
}

