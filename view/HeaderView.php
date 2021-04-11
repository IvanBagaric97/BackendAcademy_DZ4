<?php

namespace view;
use lib;

class HeaderView extends AbstractView
{
    public function __construct(private string $title, private bool $isBack)
    {
    }

    public function generateHTML()
    {
        if($this->isBack){
            $imageLink = "resources/back-arrow.png";
            $text = "Add Movie";
            $l = "index.php";
        }else{
            $imageLink = "resources/plus.png";
            $text = "Movies Collection";
            $l = "index.php?action=add";
        }

        $html = new lib\HTMLHtmlElement();
        $head = new lib\HTMLHeadElement();
        $title = new lib\HTMLTitleElement($this -> title);
        $meta = new lib\HTMLMetaElement("utf-8");
        $body = new lib\HTMLBodyElement();

        $head -> add_children(new lib\HTMLCollection([$title, $meta]));

        $p = new lib\HTMLPElement();
        $tekst = new lib\HTMLTextNode($text);
        $p -> add_child($tekst);

        $table = new lib\HTMLTableElement();

        $a1 = new lib\HTMLAElement("index.php", "");
        $img1 = new lib\HTMLImageElement("resources/movie.png");
        $img1 -> add_attribute(new lib\HTMLAttribute("style", "width:60px"));
        $a1 -> add_child($img1);
        $t1 = new lib\HTMLCellElement($a1);
        $t1 -> add_attribute(new lib\HTMLAttribute("style", "text-align:left"));

        $t2 = new lib\HTMLCellElement($p);
        $t2 -> add_attribute(new lib\HTMLAttribute("style", "text-align:center"));

        $a2 = new lib\HTMLAElement($l, "");
        $img2 = new lib\HTMLImageElement($imageLink);
        $img2 -> add_attribute(new lib\HTMLAttribute("style", "width:60px"));
        $a2 -> add_child($img2);
        $t3 = new lib\HTMLCellElement($a2);
        $t3 -> add_attribute(new lib\HTMLAttribute("style", "text-align:right"));

        #$table -> add_attribute(new HTMLAttribute("border", "2px solid black"));
        $table -> add_row(new lib\HTMLRowElement([$t1, $t2, $t3]));
        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed"));

        $body -> add_child($table);

        $html -> add_children(new lib\HTMLCollection([$head, $body]));

        echo $html;
    }
}