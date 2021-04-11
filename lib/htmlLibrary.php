<?php

namespace lib;

use JetBrains\PhpStorm\Pure;

/**
 * Razred sluzi oznacavanju razreda koji predstavljaju cvorove
 * stabla .
 */
abstract class HTMLNode{
    /**
     * Vraca html cvor kao string .
     */
    public abstract function get_html();
}

abstract class HTMLElement extends HTMLNode{

    /**
     * Polje atributa koji pripadaju elementu
     * @var array
     */
    protected array $attributes;

    /**
     * Djeca HTML elementa
     * @var HTMLCollection
     */
    protected HTMLCollection $children;

    /**
     * Zastavica koja oznacava ima li otvarajuci tag i pripadajuci
     * zatvarajuci tag .
     */
    protected bool $closed;

    /**
     * Naziv HTML elementa
     */
    protected string $name;

    /**
     * Stvara novi element zadanog naziva uz posvecivanje
     * paznje na otvarajuce i zatvarajuce tagove .
     * @param $name
     * @param bool $closed
     */
    #[Pure] public function __construct($name, $closed = true){
        $this->closed = $closed;
        $this->name = $name;
        $this->attributes = [];
        $this->children = new HTMLCollection();
    }

    /**
     * Elementu dodaje novo dijete.
     *
     * @param HTMLNode $node novo dijete
     * @return integer pozicija dodanog djeteta unutar polje djece
     */
    public function add_child(HTMLNode $node): int
    {
        return $this -> children -> add($node);
    }

    /**
     * Elementu dodaje cijelu kolekciju elemenata koji ce biti njegova
     * djeca .
     *
     * @param HTMLCollection $collection kolekcija elemenata koja
     * predstavlja djecu
     */
    public function add_children(HTMLCollection $collection){
        $this -> children = $collection;
    }

    /**
     * Vraca dijete koje se nalazi na zadanoj poziciji .
     *
     * @param $position
     * @return mixed HTMLNode dijete na zadanoj poziciji
     */
    public function get_child($position) : HTMLNode
    {
        return $this -> children -> get($position);
    }

    /**
     * Vraca trenutni broj djece elementa .
     *
     * @return integer broj djece elementa
     */
    #[Pure] public function get_children_number(): int
    {
        return $this -> children -> size();
    }

    /**
     * Uklanje dijete koje se nalazi na poziciji odredjenoj parametrom .
     *
     * @param integer $position pozicija na kojoj se nalazi dijete
     * koje je potrebno ukloniti
     */
    public function remove_child(int $position){
        $this -> children -> delete($position);
    }

    /**
     * Obavlja dodavanje novog atributa.
     *
     * @param HTMLAttribute $attribute novi atribut elementa
     */
    public function add_attribute(HTMLAttribute $attribute){
        array_push($this -> attributes, $attribute);
    }

    /**
     * Iz polja atributa uklanja atribut zadanog imena.
     * @param string $attribute naziv atributa koji je potrebno ukloniti
     */
    public function remove_attribute(string $attribute){
        foreach($this -> attributes as $key => $value){
            if($value -> get_name() === $attribute){
                array_splice($this -> attributes, $key, 1);
            }
        }
    }

    /**
     * Vraca naziv elementa.
     * @return string naziv elementa
     */
    public function get_name(): string
    {
        return $this -> name;
    }

    /**
     * Pretvara objekt u niz znakova
     */
    public function __toString(): string
    {
        return $this -> get_html();
    }

    protected function get_head_tag(): string
    {
        return "<head>";
    }

    protected function get_tail_tag(): string
    {
        return "<tail>";
    }

    public function get_html(): string
    {
        $return = "<" . $this -> name . " ";

        foreach($this -> attributes as $attribute){
            $return .= strval($attribute);
        }
        $return .= ">" . $this -> children -> get_html_collection();

        if($this -> closed){
            $return .= "</" . $this -> name . ">";
        }

        return $return;
    }
}

/**
 * Implementacija cvor koji predstavlja
 */
class HTMLTextNode extends HTMLNode{

    /**
     * Sadrzaj tekstualnog cvora
     */
    private string $text;

    /**
     * Stvara novo tekstualni cvor zadanog sadrzaja
     * @param string $text tekst cvora
     */
    public function __construct(string $text){
        $this->text = $text;
    }

    /**
     * Alias metode __toString u situacijama kada bi ova
     * metoda bila semanticki ispravnija
     */
    public function get_text(): string
    {
        return $this -> text;
    }

    /**
     * Vraca sadrzaj cvora .
     */
    public function __toString(): string
    {
        return $this -> text;
    }

    #[Pure] public function get_html(): string
    {
        return $this -> get_text();
    }
}

/**
 * Implementacija HTML atributa
 */
class HTMLAttribute
{

    /**
     * Naziv atributa
     * @var string
     */
    private string $name;

    /**
     * Vrijednost atributa koja moze biti niz znakova ako se radi o
     * samo jednoj vrijednosti , odnosno polje ako se radi o vise vrijednosti.
     * @var mixed
     */
    private $value;

    /**
     * Kreira novi atribut prema zadanom imenu i vrijednosti
     *
     * @param string $name naziv atributa
     * @param mixed $value vrijednost ( string ) ili vrijednosti ( array ) atributa
     */
    public function __construct(string $name, mixed $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Atributu dodaje jednu novu vrijednost . Nije dozvoljeno
     * duplicirati vrijednosti .
     * @param $value
     */
    public function add_value($value) : void
    {
        if(!($this -> $value === $value || in_array($value, $this -> value))){
            if(gettype($this -> value) === "string"){
                $this -> value = [$this -> value];
            }
            array_push($this -> value, $value);
        }
    }

    /**
     * Atributu dodaje vise novih vrijednosti. Potrebno je paziti
     * da ne dodje do dupliciranja vrijednosti.
     * @param $values
     */
    public function add_values($values) : void
    {
        foreach($values as $value){
            $this -> add_value($value);
        }
    }

    /**
     * Uklanja postojecu vrijednost atributa.
     * @param string $value vrijednost koju je potrebno ukloniti
     */
    public function remove_value(string $value)
    {
        if(gettype($this -> value) === "string"){
            if($this -> value === $value) $this -> value = null;
        }else{
            if (($key = array_search($value, $this -> value)) !== false) {
                #unset($this -> value[$key]);
                array_splice($this -> value, $key, 1);
            }
        }
    }

    /**
     * Vraca naziv atributa
     *
     * @return string naziv atributa
     */
    public function get_name(): string
    {
        return $this->name;
    }

    /**
     * Vraca vrijednosti atributa u formatu pogodnom za zapis u tagu.
     * Ex: key = "value"
     * Vraca se "value"
     */
    #[Pure] public function get_values(): string
    {
        if(gettype($this -> value) === "string") {
            return "'" . $this->value . "'";
        }else{
            $res = "'";
            foreach($this -> value as $v){
                $res .= strval($v) . " ";
            }
            $res .= "'";
        }
        return $res;
    }

    /**
     * Zapisuje atribut i njegove vrijednosti pomocu
     * niza znakova.
     */
    #[Pure] public function __toString(): string
    {
        return $this -> name . "=" . $this->get_values();
    }
}

class HTMLCollection
{
    /**
     * Polje cvorova koji su dio kolekcije
     * @var HTMLNode
     */
    private array $nodes;

    /**
     * Stvara novu kolekciju i puni je cvorovima ako je barem jedan,
     * predan metodi. Pozicija svakog umetnutog cvora odgovara
     * poziciji cvora u predanom polju.
     *
     * @param array $nodes polje cvorova koje je potrebno ubaciti u kolekciju
     */
    public function __construct($nodes = [])
    {
        $this->nodes = $nodes;
    }

    /**
     * Umece novi cvor u kolekciju cvorova . Cvor se umece na
     * kraj polja, tako da njegovo mjesto uvijek odgovara
     * do tada umetnutom broju cvorova.
     *
     * @param  HTMLNode $node cvor koji je potrebno umetnuti
     * @return integer mjesto unutar kolekcije na koje je cvor umetnut
     */
    public function add(HTMLNode $node): int
    {
        array_push($this -> nodes, $node);
        return key(array_slice($this -> nodes, -1, 1, true));
    }

    /**
     * Dohvaca cvor kolekcije s tocno odredjene pozicije
     *
     * @param integer $position pozicija cvora koji je potrebno dohvatiti
     * @return HTMLNode cvor s trazene pozicije
     */
    public function get(int $position) : HTMLNode
    {
        return $this->nodes[$position];
    }

    /**
     * Vraca sve elemente kolekcije.
     * @return array elementi kolekcije
     */
    public function get_all(): array
    {
        return $this->nodes;
    }

    /**
     * Vraca informaciju o velicini kolekcije.
     * @return integer broj elemenata kolekcije
     */
    #[Pure] public function size(): int
    {
        return sizeof($this->nodes);
    }

    /**
     * Brise element s tocno odredene pozicije iz kolekcije .
     * @param $position
     */
    public function delete($position)
    {
        array_splice($this -> nodes, $position, 1);
    }

    public function get_html_collection(): string
    {
        $nodes = "";
        foreach ($this->nodes as $node) {
            $nodes .= $node->get_html();
        }
        return $nodes;
    }
}

class HTMLHtmlElement extends HTMLElement {

    #[Pure] public function __construct () {
        parent :: __construct ("html", true);
    }

    /**
     * @return string
     */
    public function get_html() : string
    {
        $html = " <! doctype  html >";
        $html .= $this -> get_head_tag();
        $html .= $this -> children -> get_html_collection();
        $html .= $this -> get_tail_tag();
        return $html;
    }

}

class HTMLHeadElement extends HTMLElement {

    #[Pure] public function __construct(){
        parent :: __construct ("head", true);
    }

}

class HTMLBodyElement extends HTMLElement {

    #[Pure] public function __construct(){
        parent :: __construct ("body", true);
    }

}

class HTMLTableElement extends HTMLElement {

    #[Pure] public function __construct(){
        parent :: __construct ("table", true);
    }

    /**
     * Dodaje novi redak tablice. Ako je predani parametar jednak 'null',
     * tada se dodaje novi prazan redak tablice.
     *
     * @param HTMLRowElement $row novi redak koji se dodaje
     * @return integer pozicija umetnutog retka
     */
    public function add_row(HTMLRowElement $row = null): int
    {
        if($row === null) $row = new HTMLRowElement();
        return $this -> add_child($row);
    }

    /**
     * Dodaje vise novih redaka tablice . Ako je predani parametar prazno polje ,
     * tada se dodaje samo jedan prazan redak .
     *
     * @param { HTMLRowElement } $row novi retci koje je potrebno umetnuti
     */
    public function add_rows($rows = []) {
        foreach ($rows as $row) {
            $this -> add_child($row);
        }
    }

    /**
     * Uklanja redak iz tablice
     *
     * @param integer $position redak koji je potrebno ukloniti
     */
    public function remove_row(int $position){
        $this -> remove_child($position);
    }
}

class HTMLRowElement extends HTMLElement {

    #[Pure] public function __construct($cellArray = null){
        parent :: __construct ("tr", true);
        if($cellArray !== null) {
            foreach ($cellArray as $cell) {
                #$this -> children -> add($cell);
                self::add_child($cell);
            }
        }else{
            self::add_child(new HTMLCellElement());     #dodaje prazan cell
        }
    }

    /**
     * Dodaje retku novu celiju. Ako je predani parametar jednak 'null',
     * tada se dodaje prazna celija.
     *
     * @param HTMLCellElement $cell nova celija koja se umece u redak
     * @return integer pozicija umetnute celije
     */
    public function add_cell(HTMLCellElement $cell): int
    {
        if($cell === null) $cell = new HTMLCellElement("");
        return $this -> add_child($cell);
    }

    /**
     * Dodaje retku vise novih celija. Ako je predani parametar prazno polje,
     * tada se dodaje samo jedna prazna celija.
     *
     * @param HTMLRowElement $cells nove celije
     */
    public function add_cells($cells = []){
        if(empty($cells)){
            $this -> add_cell(new HTMLCellElement(""));
        }else{
            foreach ($cells as $cell) {
                $this -> add_cell($cell);
            }
        }
    }

    /**
     * Uklanja celiju iz retka
     *
     * @param integer $position celija koju je potrebno ukloniti
     */
    public function remove_cell(int $position){
        $this -> children -> delete($position);
    }
}

class HTMLCellElement extends HTMLElement {

    public function __construct($elem = null){
        parent :: __construct ("td", true);
        if($elem !== null) self::add_child($elem);
    }

}

class HTMLTableHeadElement extends HTMLElement {

    public function __construct($elem = null){
        parent :: __construct ("th", true);
        if($elem !== null) self::add_child($elem);
    }

}

class HTMLFormElement extends HTMLElement{

    #[Pure] public function __construct() {
        parent :: __construct ("form", true);
    }

}

class HTMLInputElement extends HTMLElement {

    #[Pure] public function __construct () {
        parent :: __construct ("input", false);
    }

}

class HTMLButtonElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("button", true);
    }

}

class HTMLSelectElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("select", true);
    }

}

class HTMLOptionElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("option", false);
    }

}

class HTMLDivElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("div", true);
    }

}

class HTMLPElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("p", true);
    }

}

class HTMLTitleElement extends HTMLElement{

    #[Pure] public function __construct($title){
        parent :: __construct("title", true);
        self::add_child(new HTMLTextNode($title));
    }

}

class HTMLMetaElement extends HTMLElement{

    #[Pure] public function __construct($charset){
        parent :: __construct("meta", false);
        self::add_attribute(new HTMLAttribute("charset", $charset));
    }

}

class HTMLAElement extends HTMLElement{

    #[Pure] public function __construct($link , $text){
        parent :: __construct("a", true);
        array_push($this -> attributes, new HTMLAttribute("href", $link));
        self::add_child(new HTMLTextNode($text));
    }

}

class HTMLLabelElement extends HTMLElement{

    #[Pure] public function __construct(){
        parent :: __construct("label", true);
    }

}

class HTMLImageElement extends HTMLElement{

    #[Pure] public function __construct(string $link){
        parent :: __construct("img", false);
        self::add_attribute(new HTMLAttribute("src", $link));
    }
}