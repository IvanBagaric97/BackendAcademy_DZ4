<?php

namespace controller;
use view;

abstract class AbstractController
{

    public function doAction(bool $isBack = False) : void {
        $h1 = new view\HeaderView("FILMOVI", $isBack);
        $h1 -> generateHTML();
        $h2 = new view\AlphabetView(range('A', 'Z'));
        $h2 -> generateHTML();
    }

    protected abstract function doJob();

}