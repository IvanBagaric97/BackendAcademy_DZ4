<?php

namespace controller;
use db;

class DeleteController extends AbstractController
{

    public function __construct(private int $id)
    {
    }

    public function doAction(bool $isBack = False) : void
    {
        $this->doJob();
    }

    protected function doJob()
    {
        $a = new db\DBDriver();
        $a -> delete("images/film.txt", $this->id);
        header("Location: index.php?action=add");
    }
}