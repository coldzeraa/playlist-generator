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
}