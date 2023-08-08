<?php

namespace flexgame;

class CitiesParserFromFile
{
    private const FILE_PATH = "G:/XAMPP/htdocs/cities-game/cities.txt";
    private const PARSER_FILE_PATH = "G:/XAMPP/htdocs/cities-game/src/Parser.py";

    public static array $cities;
    
    public function __construct()
    {
        $this->isFileValid();
    }

    private function isFileValid()
    {
        if(file_exists(self::FILE_PATH))
        {
            return true;
        }
        else
        {
            $this->setCitiesFile();
        }
    }

    private function setCitiesFile()
    {
        $command = escapeshellcmd(self::PARSER_FILE_PATH);
        shell_exec($command);
    }

    public function parse()
    {
        $file = fopen(self::FILE_PATH, 'r');
        while(!feof($file))
        {
            self::$cities[] = strtolower(htmlentities(fgets($file)));
        }
        fclose($file);
    }

}