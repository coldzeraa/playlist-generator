<?php

class Controllers_User extends Controllers_Base
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
        $playlistModel = new Models_Playlist();

        // Get user
        $userData = $this->model->findByUsername($_SESSION["username"]);

        $mood = isset($_GET["mood"]);
        $genre = isset($_GET["genre"]);
        $artist = isset($_GET["artist"]);

        // Handle GET requests for generating playlists based on mood, genre, or artist
        if ($mood && $genre && $artist) {
            $songs = $songModel->findByMoodGenreArtist($_GET['mood'], $_GET['genre'], $_GET['artist']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if ($mood && $genre && !$artist) {
            $songs = $songModel->findByMoodGenre($_GET['mood'], $_GET['genre']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if ($mood && $artist && !$genre) {
            $songs = $songModel->findByMoodArtist($_GET['mood'], $_GET['artist']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if ($artist && $genre && !$mood) {
            $songs = $songModel->findByGenreArtist($_GET['genre'], $_GET['artist']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if ($mood && !$artist && !$genre) {
            $songs = $songModel->findByMood($_GET['mood']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if (!$mood && $artist && !$genre) {
            $songs = $songModel->findByArtist($_GET['artist']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else if (!$mood && !$artist && $genre) {
            $songs = $songModel->findByGenre($_GET['genre']);
            $randomSongs = $this->getRandomSongs($songs);
            $this->createPlaylist($randomSongs, $playlistModel, $_GET['name']);
            $this->sendJsonResponse(['songs' => $randomSongs]);
        } else {
            // Get all moods, genres, and artists
            $moods = $songModel->findAllMoods();
            $genres = $songModel->findAllGenres();
            $artists = $songModel->findAllArtists();
            $playlists = $playlistModel->findByUserID($_SESSION["id"]);

            $data["moods"] = $moods;
            $data["genres"] = $genres;
            $data["artists"] = $artists;
            $data["user"] = $userData;
            $data["playlists"] = $playlists;
            $data["songs"] = $songModel->findAll();

            $this->view->render($data);
        }
    }

    private function createPlaylist(array $songs, Models_Playlist $playlistModel, string $playlistName): bool
    {
        $playlistSongsModel = new Models_PlaylistSong();
        $length = $this->getLength($songs);
        $playlist = new Domains_Playlist(["name" => $playlistName, "totalTime" => $length, "userID" => $_SESSION["id"]]);
        $obj = $playlistModel->insert($playlist);

        foreach ($songs as $song) {
            $playlistSongs = new Domains_PlaylistSongs(["playlistID" => $obj->id, "songID" => $song->id]);
            $playlistSongsModel->insert($playlistSongs);
        }
        return true;
    }

    private function getLength(array $songs)
    {
        $length = 0;
        foreach($songs as $song){
            $length += $song->length;
        }
        return $length;
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
        $data = $this->model->insert($obj);

        Utils_Login::register_session($data->id, $data->username);

        $this->view->render($data);
    }
}
