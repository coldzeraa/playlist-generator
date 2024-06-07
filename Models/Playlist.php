<?php
class Models_Playlist extends Models_Base {
    public function findAll(): array{
        $statement = "SELECT * FROM playlists;";

        $statement = $this->connection->query($statement);

        return array_map(function ($data) {
            return new Domains_Playlist($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): Domains_Playlist{
        $query = "SELECT * FROM playlists WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if($data) {
            return new Domains_Playlist($data);
        } else {
            throw new Exceptions_NotFound();
        }
    }

    public function insert(Domains_Playlist $obj){
        $query = "INSERT INTO playlists (name, description, created_at)
                  VALUES (:name, :description, :created_at);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":name" => $obj->name,
            ":description" => $obj->description,
            ":created_at" => $obj->created_at
        ]);
        $lastId = $this->connection->lastInsertId();
        return $this->findById($lastId);
    }

    public function update(Domains_Playlist $obj){
        $query = "UPDATE playlists SET name=:name, description=:description, created_at=:created_at 
                   WHERE id=:id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":name" => $obj->name,
            ":description" => $obj->description,
            ":created_at" => $obj->created_at,
            ":id" => $obj->id
        ]);
        return $this->findById($obj->id);
    }

    public function delete($id) {
        $query = "DELETE FROM playlists WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
    }
}
