<?php

abstract class Domains_Base implements JsonSerializable
{
    protected array $data;

    public function __construct($data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function __get($name)
    {
        return $this->data[$name];
    }

    public function jsonSerialize(): mixed
    {
        return $this->data;
    }

    public function property_names()
    {
        return array_keys($this->data);
    }

}
