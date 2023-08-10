<?php

namespace App;

use App\Steps;
use App\WordFormat;
use App\Parser\CitiesParserFromFile;

class Game 
{
    public bool $game_run = true;
    public WordFormat $all_cities;
    public $parser = new CitiesParserFromFile();
    public $steps = new Steps();

    public function __construct()
    {
        require_once "G:\\XAMPP\\htdocs\\cities-game\\src\\Parser\\CitiesParserFromFile.php";
        
        $this->all_cities = $parser->init();
        $this->game();
    }

    //Установка хода юзера/компьютера и проверка, кто выйграл, после окончания игры 
    public function game()
    {
        while($this->game_run)
        {
            if($this->steps->checkSteps())
            {
                $this->steps->userStep();
            }
            else
            {
                $this->steps->computerStep();
            }
            
        }

        if($this->steps->checkSteps())
        {
            return "Вы победили!";
        }
        else
        {
            return "Победил компьютер";
        }
    }
}