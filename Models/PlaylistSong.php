<?php

class Models_PlaylistSong extends Models_Base{

    public function insert(Domains_PlaylistSongs $obj){
        $query = "INSERT INTO playlistSongs (playlist_id, song_id)
                  VALUES (:playlistID, :songID);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":playlistID" => $obj->playlistID,
            ":songID" => $obj->songID,
        ]);
    }

    public function findByPlaylistID(int $playlistID): array{
        $query = "SELECT song_id FROM playlistSongs WHERE playlist_id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $playlistID]);
        return $statement->fetchAll(PDO::FETCH_COLUMN, 0);
    }

}