<?php

class Models_User extends Models_Base
{
    public function findAll(): array
    {
        $statement = "SELECT * FROM user;";

        $statement = $this->connection->query($statement);

        return array_map(function ($data) {
            return new Domains_User($data);
        }, $statement->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(int $id): Domains_User
    {
        $query = "SELECT * FROM user WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Domains_User($data);
        } else {
            throw new Exception();
        }
    }

    public function insert(Domains_User $obj)
    {
        $query = "INSERT INTO user (username, email, password, created_at)
                  VALUES (:username, :email, :password, :created_at);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":username" => $obj->username,
            ":email" => $obj->email,
            ":password" => $obj->password,
            ":created_at" => $obj->created_at
        ]);
        $lastId = $this->connection->lastInsertId();
        return $this->findById($lastId);
    }

    public function update(Domains_User $obj)
    {
        $query = "UPDATE user SET username=:username, email=:email, password=:password, created_at=:created_at 
                   WHERE id=:id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":username" => $obj->username,
            ":email" => $obj->email,
            ":password" => $obj->password,
            ":created_at" => $obj->created_at,
            ":id" => $obj->id
        ]);
        return $this->findById($obj->id);
    }

    public function delete($id)
    {
        $query = "DELETE FROM users WHERE id = :id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":id" => $id]);
    }
}
