<?php

namespace flexgame;

class CitiesParserFromFile
{
    private const FILE_PATH = "G:/XAMPP/htdocs/cities-game/cities.txt";
    private const PARSER_FILE_PATH = "G:/XAMPP/htdocs/cities-game/src/Parser.py";

    public array $cities;

    public function init()
    {
        $this->isFileValid();
        
        return $this->cities;
    }

    public function isFileValid()
    {
        if(file_exists(self::FILE_PATH))
        {
            $this->parse();
        }
        else
        {
            $this->setCitiesFile();
        }
    }

    public function setCitiesFile()
    {
        $command = escapeshellcmd(self::PARSER_FILE_PATH);
        shell_exec($command);        
    }

    public function parse()
    {
        $file = fopen(self::FILE_PATH, 'r');

        while(!feof($file))
        {
            $this->cities[] = strtolower(htmlentities(fgets($file)));
        }

        fclose($file);
    }
}