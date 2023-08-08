<?php

use flexgame\CitiesParserFromFile;

class Logic
{
    public array $entered_cities;
    public array $all_cities;
    public $user_word;
    public $computer_word;
    public $invalid_chars = ['ъ', 'ь', 'ы', ' ', '\n'];
    public $steps = 1;
    public $last_char;
    private bool $game_run = true;

    public function checkSteps()
    {
        return $this->steps % 2 == 0;
    }

    public function getUserWord()
    {
        $this->user_word = strtolower(htmlspecialchars($_POST['city']));
    }
    
    public function getLastChar()
    {
        $last_char = substr($this->user_word, -1);
        return $last_char;
    }

    public function isValidLastChar()
    {
        $this->getLastChar($this->user_word);
        if(!in_array($this->last_char, $this->invalid_chars))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function checkUserInput()
    {
        $word_without_invalid_chars = $this->user_word;
    
        if(!$this->isValidLastChar($this->user_word, $this->invalid_chars))
        {
            $word_without_invalid_chars = mb_substr($word_without_invalid_chars, -1, 1);
            return $this->checkUserInput($word_without_invalid_chars, $this->invalid_chars);
        }
        else
        {
            $this->last_char = $this->getLastChar($this->user_word);
            return true;
        }
    
    }

    public function userStep()
    {
        if(in_array($this->user_word, $this->all_cities))
        {
            if(in_array($this->user_word, $this->entered_cities))
            {
                echo "Город уже был назван";
            }
            else
            {
                $entered_cities[] = $this->user_word;
                $this->steps++;
            }
        }
        else
        {
            echo "Такого города не существует";
        }
    }

    public function computerStep()
    {
        $lose = true;
        for($i=0; $i<count($this->all_cities); $i++)
        {
            $current_city = $this->all_cities[$i];
            if (str_starts_with($current_city, $this->last_char))
            {
                if(in_array($current_city, $this->entered_cities))
                {
                    continue;
                }
                else
                {
                    $lose = false;
                    $entered_cities[] = $current_city;
                    $this->steps++;
                    break;
                }
            }
        }

        if($lose)
        {
            $this->game_run = false;
        }
    }

    public function game()
    {
        while($this->game_run)
        {
            if($this->steps)
            {
                $this->userStep();
            }
            else
            {
                $this->computerStep();
            }
            
        }

        if($this->checkSteps())
        {
            return "Вы победили!";
        }
        else
        {
            return "Победил компьютер";
        }
    }
    
    
}
