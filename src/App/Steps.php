<?php

namespace App;

use App\WordFormat;
use App\Game;

class Steps 
{
    
    public $steps = 1;
    public $format = new WordFormat();
    public Game $game_run;


    //Проверка, чей сейчас ход. Ход пользователя кратен 2
    public function checkSteps()
    {
        return $this->steps % 2 == 0;
    }

    public function firstStep()
    {
        $current_city_id = rand(0, count($this->format->all_cities) - 1);
        $current_city = $this->format->all_cities[$current_city_id];
        $this->format->entered_cities[] = $current_city;
        $this->steps++;
        return $current_city;

    }


    //Ход игрока. Даётся 3 попытки назвать город. Если условия названия соблюдены, то доавляем город в поле $entered_cities, ход переходит компьютеру; 
    //по истечении 3-х попыток свойство $game_run переходит в false и далее в методе game()
    public function userStep()
    {
        $tries = 3;
        
        $this->format->getUserWord();
        $this->format->checkInput();

        //Если слово юзера начинается на последнюю букву
        if(str_starts_with($this->format->user_word, $this->format->last_char))
        {
            if(in_array($this->format->user_word, $this->format->all_cities))
            {
                if(in_array($this->format->user_word, $this->format->entered_cities))
                {
                    echo "Город уже был назван";
                
                    $tries -= 1;
                    if($tries < 1)
                    {
                        $this->game_run = false;
                    }
                }
                else
                {
                    $this->format->entered_cities[] = $this->format->user_word;
                    $this->steps++;
                    break;
                }
            }
            else
            {
                echo "Такого города не существует";

                $tries -= 1;
                if($tries < 1)
                {
                    $this->game_run = false;
                }
            }
        }
        else
        {
            echo "Слово должно начинаться на - " . $this->format->last_char;

            $tries -= 1;
            if($tries < 1)
            {
                $this->game_run = false;
            }
        }
    }

    //Ход компьютера. Если первый ход, то выбирает случайное слово из списка городов.
    //Иначе циклом проходимся по всем городам, проверяем основное условие игры
    //Если нашлось подходящее слово - добавляем в список, иначе свойство $game_run переходит в false и далее в методе game()
    public function computerStep()
    {
        $lose = true;

        for($i=0; $i<count($this->format->all_cities); $i++)
        {
            $current_city = $this->format->all_cities[$i];
            if (str_starts_with($current_city, $this->format->last_char))
            {
                if(in_array($current_city, $this->format->entered_cities))
                {
                    continue;
                }
                else
                {
                    $lose = false;
                    $this->format->entered_cities[] = $current_city;
                    $this->steps++;
                    return $current_city;
                }
            }
        }
        
        if($lose)
        {
            $this->game_run = false;
        }
    
    }
}