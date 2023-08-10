<?php

namespace App;

mb_internal_encoding('UTF-8');

class WordFormat
{
    
    public $last_char;
    public $invalid_chars = ['ъ', 'ь', 'ы'];
    public $current_word;
    public array $all_cities;
    public array $entered_cities;
    public $user_word;

    
    //Получаем последнюю букву в слове
    public function getLastChar($word)
    {
        return mb_substr($word, -1);
    }

    //Получаем слово от пользователя
    public function getUserWord()
    {
        $this->user_word = mb_strtolower(htmlspecialchars($_POST['city']));
    }

    //Проверяем последнюю букву на наличие в списке недопустимых и возвращаем true/false
    public function isValidLastChar()
    {
        $this->last_char = $this->getLastChar($this->current_word);
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
        $this->current_word = $this->entered_cities[array_key_last($this->entered_cities)];

        if($word !== null)
        {
            $this->current_word = $word;
        }
    
        if(!$this->isValidLastChar())
        {
            $this->current_word = mb_substr($this->current_word, -1, 1);
            return $this->checkInput($this->current_word);
        }

        return true;
        
    }
}