<?php

class Controllers_Playlist extends Controllers_Base
{
    private $model;

    public function __construct(Views_Base $view, array $params)
    {
        parent::__construct($view, $params);
        $this->model = new Models_Playlist();
    }

    public function get()
    {
        if ($this->params) {
            $playlistSongsModel = new Models_PlaylistSong();
            $playlist = $this->model->findById($this->params[0]);
            $songsIDs = $playlistSongsModel->findByPlaylistID($playlist->id);
            $songs = $this->getSongs($songsIDs);
            $data["playlist"] = $playlist;
            $data["songs"] = $songs;
        } else {
            $data = $this->model->findByUserID($_SESSION["id"]);
        }
        $this->view->render($data);
    }

    private function getSongs(array $songIDs): array
    {
        $songModel = new Models_Song();
        $result = [];
        for ($i = 0; $i < count($songIDs); $i++) {
            $result[$i] = $songModel->findById($songIDs[$i]);
        }
        return $result;
    }

    public function delete(){
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        error_log("ID: " . $id);

        if ($id) {
            $this->model->delete($id);
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        }
    }
}
