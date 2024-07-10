<?php
class Models_Playlist extends Models_Base {
    public function findAll(): array{
        $statement = "SELECT * FROM playlist;";

        $statement = $this->connection->query($statement);

        return array_map(function ($data) {
            return new Domains_Playlist($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): Domains_Playlist{
        $query = "SELECT * FROM playlist WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return new Domains_Playlist($data);
    }

    public function findByUserID(int $id): array{
        $query = "SELECT * FROM playlist WHERE userID = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
        return array_map(function ($data) {
            return new Domains_Playlist($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function insert(Domains_Playlist $obj){
        $query = "INSERT INTO playlist (name, description, created_at)
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
        $query = "UPDATE playlist SET name=:name, description=:description, created_at=:created_at 
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
        $query = "DELETE FROM playlist WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
    }
}
