<?php
declare(strict_types=1);

function get_all_tracks(): array
{
    $music = explode("\n", file_get_contents(__DIR__."/data.txt"));
    $__MUSIC__ = [];
    foreach ($music as $music_line) {
        $sublist = [];
        $music_data = explode(";", $music_line);
        $keys = ["id", "title", "performer", "album", "length", "genre", "year"];
        $x = 0;
        foreach ($keys as $key) {
            $sublist[$key] = $music_data[$x] ?? "A rendszer hülye >:(";
            $x++;
        }
        $__MUSIC__[] = $sublist;
    }
    return $__MUSIC__;
}

function filter_tracks_by_genre(string $genre) :array
{
    $music1 = get_all_tracks();
    $music2 = [];
    foreach ($music1 as $x) {
        if ($x["genre"] === $genre) {
            $music2[] = $x;
        }
    }
    return $music2;
}

function get_total_playlist_duration() :int
{
    $music1 = get_all_tracks();
    $sum = 0;
    foreach ($music1 as $music_line) {
        $sum += $music_line["length"];
    }
    return $sum;
}

function get_tracks_by_decade(int $decade) :array
{
    $music1 = get_all_tracks();
    $music2 = [];
    foreach ($music1 as $music_line) {
        if ($music_line["year"] >= $decade && $music_line["year"] <= $decade+9) {
            $music2[] = $music_line;
        }
    }
    return $music2;
}