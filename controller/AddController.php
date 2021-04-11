<?php

namespace controller;
use view, db, lib;

class AddController extends AbstractController
{

    public function __construct(private array $data)
    {
    }

    public function doAction(bool $isBack = False) : void
    {
        parent::doAction(True);
        $this  -> doJob();

    }

    protected function doJob()
    {
        $er = "";
        $a = new db\DBDriver();
        if(!empty($this->data)){
            $title = lib\post("title");
            $genre = lib\post("genre");
            $year = lib\post("year");
            $duration = lib\post("duration");
            $file = $_FILES["file"]["name"];

            if($title === null || $title === "") $er .= "Movie title is missing. ";
            if($genre === null) $er .= "Movie genre is missing. ";
            if($year === null) $er .= "Movie year is missing. ";
            if($duration === null || $duration === ""){
                $er .= "Duration is missing. ";
            }elseif((int)$duration > 300 || (int)$duration < 10) {
                $er .= "Movie duration is out of range.";
            }
            if($file === null) $er .= "Movie headline image is missing. ";

            if($er === ""){
                $upload_dir = "resources/";
                $uploadFile = $file;

                $array = explode(".", $uploadFile);
                $fileExtension = end($array);

                $newName = $upload_dir . "file_" . time() . "." . $fileExtension;

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $newName)) {

                    $a->createNewMovie($a->getLastId("images/film.txt") + 1, $title, $a->getGenreId($genre),
                                    $year, $duration, $newName);
                } else {
                    echo "Datoteka nije prebacena!";
                }
            }
        }

        $h1 = new view\FormView();
        $h1 -> generateHTML();

        if($er !== ""){
            $h = new view\ErrorView($er);
            $h -> generateHTML();
            reset($_POST);
        }

        $col = $a->select("images/film.txt");
        $sort = lib\get("sort");
        if($sort === "naslov"){
            usort($col, "lib\compareName");
        }elseif($sort === "godina"){
            usort($col, "lib\compareYear");
        }elseif($sort === "trajanje"){
            usort($col, "lib\compareDuration");
        }
        $h2 = new view\FilmTableView($col);
        $h2 -> generateHTML();
    }
}