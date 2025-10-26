<!doctype html>
<html lang="hu">
<head>
    <title>Lejátszási lista</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
    <style>
        h1, h2, .stat {
            margin: 7.21px;
        }
        .form, .stat {
            border: 2px solid black;
            padding: 10px;
            margin: 10px;
        }
        .stat {
            background-color: #BCBCBC;
            font-size: 2em;
            color: #252525;
        }
        .table {
            margin: auto;
            width: 197vh;
        }
        .table-container {
            margin: 1.53vh;
        }
        h1 {
            font-size: 2em;
        }
        h2 {
            font-size: 1em;
        }
        .title2 {
            font-size: 1.3em;
        }
        hr {
            margin: 20px;
        }
    </style>
</head>
<body>
<h1>Lejátszási lista</h1>
<h2>Verziószám: v1.0</h2>
<hr>
<div class="form">
    <form action="index.php" method="get">
        <p class="title2">Szűrés</p>
        <hr>
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
        <input type="number" min="1950" max="2025" step="10" id="decade" name="decade" required><br>
        <input type="hidden" name="mode" value="query">
        <input type="submit" value="Szűrés">
    </form>
    <form action="index.php" method="get">
        <input type="submit" value="Szűrés törlése">
    </form>
</div>
<form class="form" action="index.php" method="post">
    <p class="title2">Új zeneszám felvétele</p>
    <hr>
    <p>
        <label for="name">Név: </label>
        <input id="name" name="name" minlength="2" required>
    </p>
    <p>
        <label for="performer">Előadó: </label>
        <input id="performer" name="performer" minlength="2" required>
    </p>
    <p>
        <label for="album">Album: </label>
        <input id="album" name="album" minlength="2" required>
    </p>
    <p>
        <label for="length">Hossz (mp-ben, max 1200): </label>
        <input type="number" id="length" name="length" min="1" max="1200" required>
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
        <input type="number" name="year" id="year" min="1950" max="2025" value="2025" required>
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
    $songs = [];
    foreach ($song0 as $song) {
        if ($song["genre"] === $_GET["genre"] && substr($song["year"], 0, 3) === substr($_GET["decade"], 0, 3)) $songs[] = $song;
    }
}
if (isset($_POST["mode"]) && $_POST["mode"] === "new") {
    file_put_contents(__DIR__."/app/data.txt", file_get_contents(__DIR__."/app/data.txt")."\n".(count(explode("\n", file_get_contents(__DIR__."/app/data.txt")))+1).";{$_POST['name']};{$_POST['performer']};{$_POST['album']};{$_POST['length']};{$_POST['genre']};{$_POST['year']}");
    $songs = get_all_tracks();
}
$XXXXXXXXXX = "";
$num = 0;
$dur = 0;
$a = 2025;
$z = 1950;
$genres = [];
foreach ($songs as $song) {
    $XXXXXXXXXX .= render_track_row($song);
    $num++;
    $dur += intval($song["length"]);
    $genres[] = $song["genre"];
    if ($song["year"] < $a) $a = $song["year"];
    if ($song["year"] > $z) $z = $song["year"];
}
$avg_dur = $dur / $num;
?>
<div class="stat">
    <p>
        Zenék száma: <?= $num ?> //
        Teljes lejátszási idő: <?= format_duration(get_total_playlist_duration()) ?> //
        Műfajok száma: <?= count(array_unique($genres)) ?> //
        Legrégebbi dal éve: <?= $a ?> //
        Legújabb dal éve: <?= $z ?> //
        Átlagos dalhossz: <?= format_duration($avg_dur) ?>
    </p>
</div>
<div class="table-container">
    <table class="table is-hoverable is-striped">
        <thead>
        <tr>
            <th>X</th>
            <th>Dal címe</th>
            <th>Előadó</th>
            <th>Album</th>
            <th>Hossz</th>
            <th>Műfaj</th>
            <th>Év</th>
        </tr>
        </thead>
        <tbody>
            <?= $XXXXXXXXXX ?>
        </tbody>
    </table>
</div>
</body>
</html>