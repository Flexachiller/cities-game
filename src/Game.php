<?php

namespace flexgame;

use flexgame\CitiesParserFromFile;

class Game
{
    public array $named_cities;
    public array $all_cities;

    public function __construct()
    {
       $this->all_cities = CitiesParserFromFile::$cities;
       $this->init();
    }

    public function init()
    {
        return "Игра началась! Первое слово - " . $this->setFirstWord();
    }

    public function setFirstWord()
    {
        $cities_count = count($this->all_cities);
        $first_word = rand(0, $cities_count-1);
        $this->named_cities[] = $first_word;
    }
}