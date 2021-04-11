<?php

namespace view;
use db\DBDriver;
use lib, db;

class FormView extends AbstractView
{

    public function generateHTML()
    {
        echo "<br>";
        $a = new db\DBDriver();

        $body = new lib\HTMLBodyElement();
        $table = new lib\HTMLTableElement();

        $form = new lib\HTMLFormElement();
        $form->add_attribute(new lib\HTMLAttribute("action", "index.php?action=add"));
        $form->add_attribute(new lib\HTMLAttribute("method", "post"));
        $form->add_attribute(new lib\HTMLAttribute("enctype", "multipart/form-data"));  ##check

        $title = new lib\HTMLInputElement();
        $title->add_attribute(new lib\HTMLAttribute("type", "text"));
        $title->add_attribute(new lib\HTMLAttribute("name", "title"));

        $genre = new lib\HTMLSelectElement();
        $genre->add_attribute(new lib\HTMLAttribute("name", "genre"));

        $x = $a->getGenres();
        foreach($x as $v){
            $option = new lib\HTMLOptionElement();
            $option->add_child(new lib\HTMLTextNode($v));
            $option->add_attribute(new lib\HTMLAttribute("value", $v));
            $genre->add_child($option);
        }

        $year = new lib\HTMLSelectElement();
        $year->add_attribute(new lib\HTMLAttribute("name", "year"));

        $x = range(1900, 2021);
        $x = array_reverse($x);
        foreach($x as $v){
            $option = new lib\HTMLOptionElement();
            $option->add_child(new lib\HTMLTextNode($v));
            $option->add_attribute(new lib\HTMLAttribute("value", strval($v)));
            $year->add_child($option);
        }

        $duration = new lib\HTMLInputElement();
        $duration->add_attribute(new lib\HTMLAttribute("type", "number"));
        $duration->add_attribute(new lib\HTMLAttribute("name", "duration"));

        $file = new lib\HTMLInputElement();
        $file->add_attribute(new lib\HTMLAttribute("type", "file"));
        $file->add_attribute(new lib\HTMLAttribute("name", "file"));

        $submit = new lib\HTMLInputElement();
        $submit->add_attribute(new lib\HTMLAttribute("type", "submit"));
        $submit->add_attribute(new lib\HTMLAttribute("name", "submit"));
        $submit->add_attribute(new lib\HTMLAttribute("value", "Add Movie"));

        $h1 = new lib\HTMLTableHeadElement();
        $h1 -> add_child(new lib\HTMLTextNode("Title"));
        $h2 = new lib\HTMLTableHeadElement();
        $h2 -> add_child(new lib\HTMLTextNode("Genre"));
        $h3 = new lib\HTMLTableHeadElement();
        $h3 -> add_child(new lib\HTMLTextNode("Year"));
        $h4 = new lib\HTMLTableHeadElement();
        $h4 -> add_child(new lib\HTMLTextNode("Duration"));
        $h5 = new lib\HTMLTableHeadElement();
        $h5 -> add_child(new lib\HTMLTextNode("Headline"));
        $h6 = new lib\HTMLTableHeadElement();
        $h6 -> add_child(new lib\HTMLTextNode("Add"));

        $table -> add_row(new lib\HTMLRowElement([$h1, $h2, $h3, $h4, $h5, $h6]));

        $center = new lib\HTMLAttribute("style", "text-align:center;");

        $c1 = new lib\HTMLCellElement();
        $c1 -> add_child($title);
        $c1 -> add_attribute($center);

        $c2 = new lib\HTMLCellElement();
        $c2 -> add_child($genre);
        $c2 -> add_attribute($center);

        $c3 = new lib\HTMLCellElement();
        $c3 -> add_child($year);
        $c3 -> add_attribute($center);

        $c4 = new lib\HTMLCellElement();
        $c4 -> add_child($duration);
        $c4 -> add_attribute($center);

        $c5 = new lib\HTMLCellElement();
        $c5 -> add_child($file);
        $c5 -> add_attribute($center);

        $c6 = new lib\HTMLCellElement();
        $c6 -> add_child($submit);
        $c6 -> add_attribute($center);

        $table -> add_row(new lib\HTMLRowElement([$c1, $c2, $c3, $c4, $c5, $c6]));

        $table -> add_attribute(new lib\HTMLAttribute("style", "width:100%; table-layout:fixed; border:2px solid black;"));
        $form->add_child($table);
        $body -> add_child($form);

        echo $body;
    }
}