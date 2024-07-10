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

    public function findByUsername(string $username): Domains_User{
        $query = "SELECT * FROM user WHERE username = :username;";
        $statement = $this->connection->prepare($query);
        $statement->execute([":username" => $username]);
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        if ($data) {
            return new Domains_User($data);
        } else {
            throw new Exception();
        }
    }

    public function insert(Domains_User $obj)
    {
        // If user is already in database
        if (in_array($obj, $this->findAll())) { 
            return $obj;
        }

        $query = "INSERT INTO user (username, password)
                  VALUES (:username, :password);";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":username" => $obj->username,
            ":password" => $obj->password,
        ]);
        $lastId = $this->connection->lastInsertId();
        return $this->findById($lastId);
    }

    public function update(Domains_User $obj)
    {
        $query = "UPDATE user SET username=:username, password=:password
                   WHERE id=:id;";
        $statement = $this->connection->prepare($query);
        $statement->execute([
            ":username" => $obj->username,
            ":password" => $obj->password,
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
