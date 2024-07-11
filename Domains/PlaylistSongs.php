<?php

class Domains_PlaylistSongs extends Domains_Base
{
    public function __construct($data)
    {
        $this->data = [
            "playlistID" => null,
            "songID" => null,
        ];
        parent::__construct($data);
    }
}