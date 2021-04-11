<?php

namespace db;


class DBDriver
{

    /**
     * Unesi novi red u bazu
     * @param string $file
     * @param string $row
     */
    function insert(string $file, string $row): void
    {
        $current = file_get_contents($file);
        $current .= trim($row) . "\n";
        file_put_contents($file, $current, LOCK_EX);
    }

    /**
     * Iz baze uklanja redak s odabranim id-om
     * @param string $file
     * @param string $id
     */
    function delete(string $file, string $id): void
    {
        $newContent = "";
        $current = file_get_contents($file);
        $lines = explode("\n", trim($current));

        foreach ($lines as $line) {
            if (ctype_space($line) || $line === "" || str_starts_with($line, '#')) continue;

            $split = explode(",", $line);
            if ($split[0] === $id) continue;

            $newContent .= trim($line) . "\n";
        }

        file_put_contents($file, $newContent, LOCK_EX);
    }

    /**
     * Vraća redak sa zadanim id-im ili vraća sve retke ako je id == null
     * @param string $file
     * @param string|null $id
     * @return array|string
     */
    function select(string $file, ?string $id = null): array|string
    {
        $current = file_get_contents($file);
        $lines = explode("\n", trim($current));
        if ($id === null) {
            $ret = [];
            foreach ($lines as $line) {
                if (!str_starts_with($line, '#')) {
                    $split = explode(",", $line);
                    array_push($ret, $split);
                }
            }
            return $ret;
        } else {
            foreach ($lines as $line) {
                if (ctype_space($line) || $line === "" || str_starts_with($line, '#')) continue;

                $split = explode(",", $line);
                if (trim($split[0]) === $id) return $split;
            }
        }
        return "Nema retka s tim id-em";            #dodaj neki throw
    }

    /**
     * Vraca listu filmova cije ime pocinje sa zadanim slovom
     * @param string $letter
     * @return array
     */
    function startsWithLetter(string $letter): array
    {
        $current = file_get_contents("images/film.txt");
        $lines = explode("\n", trim($current));
        $return = [];

        foreach ($lines as $line) {
            if (ctype_space($line) || $line === "" || str_starts_with($line, '#')) continue;

            $split = explode(",", $line);
            if (str_starts_with(strtoupper(trim($split[1])), strtoupper($letter))) {
                array_push($return, $split);
            }
        }
        return $return;
    }

    function createNewMovie(string $id, string $name, string $genre_id, string $year, string $duration, string $cover) : void {
        $movie = array($id, $name, $genre_id, $year, $duration, $cover);
        $prepared = implode(",", $movie);
        $current = file_get_contents('images/film.txt');
        $current .= trim($prepared) .  "\n";
        file_put_contents('images/film.txt', $current, LOCK_EX);
    }

    function getLastId(string $from): int {
        $file = file_get_contents($from);
        $lines = explode("\n", trim($file));
        $split = explode(";", end($lines));
        return intval($split[0]);
    }

    function getGenreId(string $genre) : ?int {
        $file = file_get_contents("images/genre.txt");
        $lines = explode("\n", trim($file));
        foreach($lines as $line){
            $split = explode(",", $line);
            if(strtoupper(trim($split[1])) === strtoupper(trim($genre))){
                return $split[0];
            }
        }
        return null;
    }

    function getGenres() : array {
        $ret = [];
        $file = file_get_contents("images/genre.txt");
        $lines = explode("\n", trim($file));
        foreach($lines as $line){
            $split = explode(",", $line);
            array_push($ret, $split[1]);
        }
        return $ret;
    }
}