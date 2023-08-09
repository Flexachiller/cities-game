<?php

use flexgame\CitiesParserFromFile;

class Logic
{
    public array $entered_cities;
    public array $all_cities;
    public $user_word;
    public $current_word;
    public $invalid_chars = ['ъ', 'ь', 'ы', ' ', '\n'];
    public $steps = 1;
    public $last_char;
    private bool $game_run = true;

    //Проверка, чей сейчас ход. Ход пользователя кратен 2
    public function checkSteps()
    {
        return $this->steps % 2 == 0;
    }

    //Получаем слово от пользователя
    public function getUserWord()
    {
        $this->user_word = strtolower(htmlspecialchars($_POST['city']));
    }
    
    //Получаем последнюю букву в слове
    public function getLastChar($word)
    {
        $this->last_char = substr($word, -1);
    }

    //Проверяем последнюю букву на наличие в списке недопустимых и возвращаем true/false
    public function isValidLastChar()
    {
        $this->last_char = $this->getLastChar($this->user_word);
        if(!in_array($this->last_char, $this->invalid_chars))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    //Проверяем последнюю букву. Если входит в список недопустимых - удаляем и рекурсивно вызываем метод;
    //если не входит - записывает последнюю букву в поле $last_char
    public function checkInput($word=null)
    {
        $this->current_word = $this->entered_cities[-1];

        if($word !== null)
        {
            $this->current_word = $word;
        }
        
    
        if(!$this->isValidLastChar($this->current_word, $this->invalid_chars))
        {
            $this->current_word = mb_substr($this->current_word, -1, 1);
            return $this->checkInput($this->current_word);
        }
        else
        {
            $this->getLastChar($this->current_word);
            return true;
        }
    
    }

    //Ход игрока. Даётся 3 попытки назвать город. Если условия названия соблюдены, то доавляем город в поле $entered_cities, ход переходит компьютеру; 
    //по истечении 3-х попыток свойство $game_run переходит в false и далее в методе game()
    public function userStep()
    {
        $tries = 3;
        
        for($i = 0; $i<3; $i++)
        {
            $this->getUserWord();
            $this->checkInput();

            //Если слово юзера начинается на последнюю букву
            if(str_starts_with($this->user_word, $this->last_char))
            {
                if(in_array($this->user_word, $this->all_cities))
                {
                    if(in_array($this->user_word, $this->entered_cities))
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
                        $entered_cities[] = $this->user_word;
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
                echo "Слово должно начинаться на - " . $this->last_char;

                    $tries -= 1;
                    if($tries < 1)
                    {
                        $this->game_run = false;
                    }
            }
        }
    }

    //Ход компьютера. Если первый ход, то выбирает случайное слово из списка городов.
    //Иначе циклом проходимся по всем городам, проверяем основное условие игры
    //Если нашлось подходящее слово - добавляем в список, иначе свойство $game_run переходит в false и далее в методе game()
    public function computerStep()
    {
        $lose = true;

        if($this->steps === 1)
        {
            $current_city_id = rand(0, count($this->all_cities));
            $current_city = $this->all_cities[$current_city_id];
            $this->entered_cities[] = $current_city;
            $this->steps++;
            $lose = false;
        }
        else
        {
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
        }
        if($lose)
        {
            $this->game_run = false;
        }
    }

    //Установка хода юзера/компьютера и проверка, кто выйграл, после окончания игры 
    public function game()
    {
        while($this->game_run)
        {
            if($this->checkSteps())
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
