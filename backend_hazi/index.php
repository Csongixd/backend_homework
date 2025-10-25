<!doctype html>
<html lang="hu">
<head>
    <title>Zenék listázása</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <style>
        h1, h2 {
            margin: 7.21px;
        }
        form {
            border: 2px solid black;
            padding: 10px;
            margin: 10px;
        }
    </style>
</head>
<body>
<h1>Lista a zenékről</h1>
<h2>Verziószám: v0.2</h2>
<hr>
<form action="index.php" method="get">
    <label for="genre">Műfaj: </label>
    <select id="genre" name="genre">
        <option value="rock">Rock</option>
        <option value="pop">Pop</option>
        <option value="hip-hop">Hip-Hop</option>
        <option value="jazz">Jazz</option>
        <option value="elektronikus">Elektronikus</option>
        <option value="klasszikus">Klasszikus</option>
        <option value="metal">Metal</option>
        <option value="country">Country</option>
        <option value="r&b">R&B</option>
        <option value="indie">Indie</option>
    </select><br>
    <label for="decade">Évtized: </label>
    <input type="number" min="1950" max="2025" step="10" id="decade" name="decade" value="2020"><br>
    <input type="hidden" name="mode" value="query">
    <input type="submit" value="Szűrés">
</form>
<form action="index.php" method="post">
    <p>
        <label for="name">Név: </label>
        <input id="name" name="name" minlength="2">
    </p>
    <p>
        <label for="performer">Előadó: </label>
        <input id="performer" name="performer" minlength="2">
    </p>
    <p>
        <label for="album">Album: </label>
        <input id="album" name="album" minlength="2">
    </p>
    <p>
        <label for="length">Hossz (mp-ben, max 1200): </label>
        <input type="number" id="length" name="length" min="1" max="1200">
    </p>
    <p>
        <label for="genre">Műfaj: </label>
        <select id="genre" name="genre">
            <option value="rock">Rock</option>
            <option value="pop">Pop</option>
            <option value="hip-hop">Hip-Hop</option>
            <option value="jazz">Jazz</option>
            <option value="elektronikus">Elektronikus</option>
            <option value="klasszikus">Klasszikus</option>
            <option value="metal">Metal</option>
            <option value="country">Country</option>
            <option value="r&b">R&B</option>
            <option value="indie">Indie</option>
        </select>
    </p>
    <p>
        <label for="year">Év (1950-2025): </label>
        <input type="number" name="year" id="year" min="1950" max="2025" value="2025">
    </p>
    <input type="hidden" name="mode" value="new">
    <input type="submit" value="Felvétel">
</form>
<?php
require_once "./app/data.php";
require_once "./app/functions.php";
require_once "./app/view_functions.php";
require_once "./view/pages/add_track.template.php";
require_once "./view/pages/home.template.php";
require_once "./view/pages/playlist.template.php";
require_once "./view/partials/header.template.php";
require_once "./view/partials/footer.template.php";
if (isset($_GET["mode"]) && $_GET["mode"] == "query") {
    $song0 = filter_tracks_by_genre($_GET["genre"]);
    $song1 = get_tracks_by_decade($_GET["year"]);
    $songs = [];
    foreach ($song0 as $song) {
        foreach ($song1 as $yeared) {
            if ($yeared["genre"] === $_GET["genre"]) $songs[] = $yeared;
        }
    }
}
if (isset($_POST["mode"]) && $_POST["mode"] === "new") {
    file_put_contents(__DIR__."/app/data.txt", file_get_contents(__DIR__."/app/data.txt")."\n".(count(explode("\n", file_get_contents(__DIR__."/app/data.txt")))+1).";{$_POST['name']};{$_POST['performer']};{$_POST['album']};{$_POST['length']};{$_POST['genre']};{$_POST['year']}");
}
?>
</body>
</html>