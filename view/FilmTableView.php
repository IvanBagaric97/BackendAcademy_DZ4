<?php

namespace view;
use lib;

class FilmTableView extends AbstractView
{

    public function __construct(private array $collection)
    {
    }

    public function generateHTML()
    {
        echo "<br>";

        $body = new lib\HTMLBodyElement();
        $table = new lib\HTMLTableElement();

        $h1 = new lib\HTMLTableHeadElement();
        $h1 -> add_child(new lib\HTMLTextNode("Headline"));
        $h2 = new lib\HTMLTableHeadElement();
        $h2 -> add_child(new lib\HTMLAElement("index.php?action=add&sort=naslov", "Title"));
        $h3 = new lib\HTMLTableHeadElement();
        $h3 -> add_child(new lib\HTMLAElement("index.php?action=add&sort=godina", "Year"));
        $h4 = new lib\HTMLTableHeadElement();
        $h4 -> add_child(new lib\HTMLAElement("index.php?action=add&sort=trajanje", "Duration"));
        $h5 = new lib\HTMLTableHeadElement();
        $h5 -> add_child(new lib\HTMLTextNode("Action"));

        $table -> add_row(new lib\HTMLRowElement([$h1, $h2, $h3, $h4, $h5]));

        foreach($this->collection as $row){
            $img = new lib\HTMLImageElement("index.php?action=get&id=" . $row[0]);
            $img->add_attribute(new lib\HTMLAttribute("style", "width:120px"));

            $t1 = new lib\HTMLCellElement();
            $t1 -> add_child($img);
            $t1 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center; border:2px solid black;"));

            $text2 = new lib\HTMLTextNode($row[1]);
            $t2 = new lib\HTMLCellElement();
            $t2 -> add_child($text2);
            $t2 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center; border:2px solid black;"));

            $text3 = new lib\HTMLTextNode($row[3]);
            $t3 = new lib\HTMLCellElement();
            $t3 -> add_child($text3);
            $t3 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center; border:2px solid black;"));

            $text4 = new lib\HTMLTextNode($row[4]);
            $t4 = new lib\HTMLCellElement();
            $t4 -> add_child($text4);
            $t4 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center; border:2px solid black;"));

            $text5 = new lib\HTMLAElement("index.php?action=delete&id=" . $row[0], "[obrisi]");
            $t5 = new lib\HTMLCellElement();
            $t5 -> add_child($text5);
            $t5 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center; border:2px solid black;"));

            $table -> add_row(new lib\HTMLRowElement([$t1, $t2, $t3, $t4, $t5]));
        }
        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed; border:2px solid black;"));
        $body -> add_child($table);

        echo $body;
    }
}