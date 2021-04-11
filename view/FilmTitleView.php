<?php

namespace view;
use lib;

class FilmTitleView extends AbstractView
{

    public function __construct(private array $collection)
    {
    }

    public function generateHTML()
    {
        echo "<br>";

        $body = new lib\HTMLBodyElement();
        $table = new lib\HTMLTableElement();

        foreach($this->collection as $row) {
            $img = new lib\HTMLImageElement($row[5]);
            $img->add_attribute(new lib\HTMLAttribute("style", "width:120px"));

            $t1 = new lib\HTMLCellElement();
            $t1->add_child($img);
            $t1->add_attribute(new lib\HTMLAttribute("style", "text-align:center;"));

            $table->add_row(new lib\HTMLRowElement([$t1]));

            $text2 = new lib\HTMLTextNode($row[1] . " (" . $row[3] . ")");
            $t2 = new lib\HTMLCellElement();
            $t2->add_child($text2);
            $t2->add_attribute(new lib\HTMLAttribute("style", "text-align:center;"));

            $table->add_row(new lib\HTMLRowElement([$t2]));

            $text3 = new lib\HTMLTextNode("Trajanje: " . $row[4] . " min");
            $t3 = new lib\HTMLCellElement();
            $t3->add_child($text3);
            $t3->add_attribute(new lib\HTMLAttribute("style", "text-align:center;"));

            $table->add_row(new lib\HTMLRowElement([$t3]));
        }
        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed;"));
        $body -> add_child($table);

        echo $body;
    }
}