<?php
class Models_Song extends Models_Base {
    public function findAll(): array{
        $statement = "SELECT * FROM song;";

        $statement = $this->connection->query($statement);

        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): Domains_Song{
        $query = "SELECT * FROM song WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if($data) {
            return new Domains_Song($data);
        } else {
            error_log("findById failed");
        }
    }

    public function findByMoodGenreArtist(string $mood, string $genre, string $artist):array{
        $query = "SELECT * FROM song WHERE mood = :mood AND genre = :genre AND artist = :artist;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":mood" => $mood, ":genre" => $genre, ":artist" => $artist]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByMoodGenre(string $mood, string $genre):array{
        $query = "SELECT * FROM song WHERE mood = :mood AND genre = :genre;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":mood" => $mood, ":genre" => $genre]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByMoodArtist(string $mood, string $artist):array{
        $query = "SELECT * FROM song WHERE mood = :mood AND artist = :artist;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":mood" => $mood, ":artist" => $artist]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByGenreArtist(string $genre, string $artist):array{
        $query = "SELECT * FROM song WHERE genre = :genre AND artist = :artist;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":genre" => $genre, ":artist" => $artist]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByMood(string $mood){
        $query = "SELECT * FROM song WHERE mood = :mood;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":mood" => $mood]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByGenre(string $genre){
        $query = "SELECT * FROM song WHERE genre = :genre;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":genre" => $genre]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findByArtist(string $artist){
        $query = "SELECT * FROM song WHERE artist = :artist;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":artist" => $artist]);
        return array_map(function ($data) {
            return new Domains_Song($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }
    
    public function findAllMoods(): array{
        $statement = "SELECT DISTINCT mood FROM song";
        $statement = $this->connection->query($statement);
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findAllGenres(): array{
        $statement = "SELECT DISTINCT genre FROM song";
        $statement = $this->connection->query($statement);
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function findAllArtists(): array{
        $statement = "SELECT DISTINCT artist FROM song";
        $statement = $this->connection->query($statement);
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function insert(Domains_Song $obj){
        $query = "INSERT INTO song (name, artist, genre, mood, length)
                  VALUES (:name, :artist, :genre, :mood, :length);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":name" => $obj->name,
            ":artist" => $obj->artist,
            ":genre" => $obj->genre,
            ":mood" => $obj->mood,
            ":length" => $obj->length
        ]);
        $lastId = $this->connection->lastInsertId();
        return $this->findById($lastId);
    }

    public function update(Domains_Song $obj){
        $query = "UPDATE song SET name=:name, artist=:artist, genre=:genre, 
                       mood=:mood, length=:length 
                   WHERE id=:id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":name" => $obj->name,
            ":artist" => $obj->artist,
            ":genre" => $obj->genre,
            ":mood" => $obj->mood,
            ":length" => $obj->length,
            ":id" => $obj->id
        ]);
        return $this->findById($obj->id);
    }

    public function delete($id) {
        $query = "DELETE FROM song WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
    }
}
