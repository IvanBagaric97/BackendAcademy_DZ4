<?php

namespace view;
use lib;

class ErrorView extends AbstractView
{

    public function __construct(private string $message)
    {
        $this -> $message = $message;
    }

    public function generateHTML()
    {
        echo "<br>";
        $body = new lib\HTMLBodyElement();
        $table = new lib\HTMLTableElement();

        $img =new lib\HTMLImageElement('resources/bug.png');
        $img -> add_attribute(new lib\HTMLAttribute("style", "width:60px"));

        $t1 = new lib\HTMLCellElement();
        $t1 -> add_child($img);
        $t1 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center"));

        $t2 = new lib\HTMLCellElement();
        $t2 -> add_child(new lib\HTMLTextNode($this->message));
        $t2 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center"));

        $table -> add_row(new lib\HTMLRowElement([$t1]));
        $table -> add_row(new lib\HTMLRowElement([$t2]));
        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed"));

        $body -> add_child($table);

        echo $body;
    }
}