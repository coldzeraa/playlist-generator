<?php

class Domains_Playlist extends Domains_Base
{
    public function __construct($data)
    {
        $this->data = [
            "id" => null,
            "name" => null,
            "totalTime" => null,
            "userID" => null,
        ];
        parent::__construct($data);
    }
}