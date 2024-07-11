<?php

class Domains_Song extends Domains_Base
{
    public function __construct($data)
    {
        $this->data = [
            "id" => null,
            "name" => null,
            "artist" => null,
            "genre" => null,
            "mood" => null,
            "length" => null,
        ];
        parent::__construct($data);
    }

    public function __toString()
    {
        return sprintf(
            "Song [ID: %s, Name: %s, Artist: %s, Genre: %s, Mood: %s, Length: %s seconds]",
            $this->data["id"],
            $this->data["name"],
            $this->data["artist"],
            $this->data["genre"],
            $this->data["mood"],
            $this->data["length"]
        );
    }
}