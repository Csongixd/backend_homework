<?php
declare(strict_types=1);

function render_track_row(array $track) :string {
    return "<tr><td>{$track['id']}</td><td>{$track['title']}</td><td>{$track['performer']}</td><td>{$track['album']}</td><td>".get_total_playlist_duration($track['length'])."</td><td>{$track['genre']}</td><td>{$track['year']}</td></tr>";
}

function format_duration(int $seconds) :string
{
    $s = $seconds % 60;
    $m = ($seconds - $s) / 60;
    return $s < 10 ? "$m:0$s" : "$m:$s";
}

function render_genre_tag(string $genre) :string
{
    $tags = ["black", "dark", "light", "primary", "link", "info", "success", "warning", "danger"];
    $genres = ["metal", "rock", "country", "r&b", "indie", "elektronikus", "klasszikus", "hip-hop", "pop"];
    $tag = "";
    for ($i = 0; $i < count($genres); $i++) {
        if ($genres[$i] === $genre) {
            $tag = "<span class=\"tag is-{$tags[$i]}\">{$genres[$i]}</span>";
            break;
        }
    }
    return $tag;
}

?>