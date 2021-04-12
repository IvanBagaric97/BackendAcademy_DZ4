<?php

namespace controller;

use view, db;


class IndexController extends AbstractController
{

    public function __construct(private ?string $letter)
    {
    }

    public function doAction(bool $isBack = False) : void
    {
        parent::doAction($isBack);
        $this -> doJob();
    }

    protected function doJob()
    {
        $a = new db\DBDriver();

        if($this->letter !== null){
            if(in_array(strtoupper($this->letter), range("A", "Z"))) {
                $collection = $a->startsWithLetter($this->letter);
                if (empty($collection)) {
                    $h3 = new view\ErrorView("No movies with letter " . $this->letter);
                    $h3->generateHTML();
                } else {
                    $h3 = new view\FilmTitleView($collection);
                    $h3->generateHTML();
                }
            }else{
                $h3 = new view\ErrorView("User entered " . $this->letter . " instead of a letter");
                $h3->generateHTML();
            }
        }
    }
}