<?php

namespace lib;

use JetBrains\PhpStorm\NoReturn;
use JetBrains\PhpStorm\Pure;

/**
 * Ispisuje siguran string od HTML koda.
 * @param string $v
 * @return string
 */
#[Pure] function __(string $v): string{
    return htmlentities($v, ENT_QUOTES, "utf-8");
}

/**
 * Iz URL-a dohvaca parametar $v.
 * Ukoliko parametra nema, null vracen.
 * @param string $v
 * @param null $d
 */
function get(string $v, $d = null){
    return isset($_GET[$v]) ? $_GET[$v] : $d;
}

/**
 * Iz tijela HTTP zahtjeva dohvaca parametar imena $v.
 * Ukoliko parametra nema vracen null.
 * @param string $v
 * @param null $d
 */
function post(string $v, $d = null){
    return isset($_POST[$v]) ? $_POST[$v] : $d;
}

/**
 * Provjerava je li zahtjev POST.
 * Ako je zahtjev POST, provjerava se postoji li
 * parametar nazvav $key
 * @param null $key
 * @return bool
 */
#[Pure] function isPost($key = null): bool{
    if(null === $key){
        return count($_POST) > 0;
    }

    return null !== post($key);
}

/**
 * Provjerava je li varijabla $param prazna ili null
 * @param $param
 * @return bool
 */
function paramExists($param): bool{
    if(null !== $param && ! empty ( $param )) return true;
    return false;
}

/**
 * Usmjeravanje na URL .
 * @param $url
 */
#[NoReturn] function redirect ($url) : void {
    header (" Location : " . $url );
    die (); // prekida izvodenje skripte pozivateljice
}

/**
 * Provjera prijavljenosti korisnika .
 * @return true ako je korisnik prijavljen , false inace
 */
function isLoggedIn (): bool{
    if(isset($_COOKIE["PHPSESSID"])) return true;
    else return false;
}

/**
 * Vraca ID prijavljenog korisnika
 * @return ?int ako je korisnik prijavljen , null inace
 */
#[Pure] function userID (): ?int {
    return isset($_SESSION["user_id"]) ? $_SESSION["user_id"] : null;
}

#[Pure] function compareName($a, $b): int
{
    return strnatcmp($a[1], $b[1]);
}

#[Pure] function compareYear($a, $b): int
{
    return strnatcmp($a[3], $b[3]);
}

#[Pure] function compareDuration($a, $b): int
{
    return strnatcmp($a[4], $b[4]);
}