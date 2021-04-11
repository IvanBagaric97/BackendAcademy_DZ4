<?php

namespace view;
use lib;

class AlphabetView extends AbstractView
{
    private array $letters;

    public function __construct(array $letters)
    {
        $this -> letters = $letters;
    }

    public function generateHTML()
    {
        $body = new lib\HTMLBodyElement();
        $table = new lib\HTMLTableElement();

        $t = new lib\HTMLCellElement();
        foreach($this->letters as $v){
            $t -> add_child(new lib\HTMLAElement('index.php?letter=' . $v, "|" . $v . "|"));
        }
        $t -> add_attribute(new lib\HTMLAttribute("style", "text-align:center"));
        $table -> add_row(new lib\HTMLRowElement([$t]));
        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed"));
        $body -> add_child($table);

        echo $body;
    }
}