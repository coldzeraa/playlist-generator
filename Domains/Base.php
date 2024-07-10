<?php

abstract class Domains_Base implements JsonSerializable
{
    protected array $data;

    public function __construct($data)
    {
        if(is_array($data)){
            $this->data = array_merge($this->data, $data);
        }else{
            $this->data = array();
        }
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
