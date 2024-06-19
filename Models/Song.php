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
            throw new Exceptions_NotFound();
        }
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
