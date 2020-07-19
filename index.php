<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <link
            href="https://fonts.googleapis.com/css2?family=VT323&display=swap"
            rel="stylesheet"
    />

    <title>Pokedex</title>
    <link rel="icon" href="https://cdn.emojidex.com/emoji/seal/pokeball.png" type="png">
</head>
<body>
<?php
//ini_set('display_errors', "1");
//ini_set('display_startup_errors', "1");
//error_reporting(E_ALL);

$api = "https://pokeapi.co/api/v2/";

if( isset($_GET["pokemon"])) {
    $data =  file_get_contents ( $api . "pokemon/" .strtolower($_GET["pokemon"])) ;
    $response = json_decode ( $data, true);
    $moves = $response ["moves"] ;
    $types = $response["types"];
    $speciesData = file_get_contents ($api . "pokemon-species/" . strtolower($_GET["pokemon"]));
    $speciesResponse = json_decode($speciesData, true);
    $flavourText = $speciesResponse["flavor_text_entries"];
    $evolutionData = file_get_contents (rtrim($speciesResponse ["evolution_chain"]["url"],'/'));
    $evolutionResponse = json_decode($evolutionData, true);
    $firstEvolution = $evolutionResponse["chain"]["species"]["name"];
    $firstEvolutionSprite = json_decode(file_get_contents($api."pokemon/".$evolutionResponse["chain"]["species"]["name"]), true);
    $secondEvolution = null;
    $thirdEvolution = null;

    if (count($evolutionResponse["chain"]["evolves_to"]  )>= 1) {
        $secondEvolution = $evolutionResponse["chain"]["evolves_to"];
        $thirdEvolution = $evolutionResponse["chain"]["evolves_to"][0]["evolves_to"];
    }

    foreach ($types as $type) {

    }

    foreach (array_rand($moves, 4)as $index ) {

    }

    $flavourEnglish = [];
    foreach ($flavourText as $text) {
        if($text["language"]["name"] === "en"){
            array_push ($flavourEnglish , $text ["flavor_text"]);
        }
    }

    if ($secondEvolution) {
        foreach ($secondEvolution as $evolvedForm) {
            $evolvedData = file_get_contents($api . "pokemon/" . $evolvedForm["species"]["name"]);
            $evolvedResponse = json_decode($evolvedData, true);

        }
    }
    if ($thirdEvolution) {
        foreach ($thirdEvolution as $evolvedForm) {
            $evolvedData = file_get_contents($api . "pokemon/" . $evolvedForm["species"]["name"]);
            $evolvedResponse = json_decode($evolvedData, true);

        }
    }
}

?>
<video playsinline autoplay loop muted >
    <source src="assets/pokeballBG.mp4" type="video/mp4" />
</video>

<header class="pokedex-logo">
    <img class="pokedex-logo" src="assets/pokedexlogo.png" alt="Logo for the pokedex">
</header>
<div class="main">
    <div class="grid-container">
        <div class="pokemon-images">
            <?php
            if( isset($_GET["pokemon"])){
                echo "<img src='" . $response["sprites"]["front_default"] . " '> <img src='" . $response["sprites"]["back_default"] ."'>";
                echo "<hr>";
                echo "<img src='" . $firstEvolutionSprite["sprites"]["front_default"] . " '>";
                if ($secondEvolution) {
                    foreach ($secondEvolution as $evolvedForm) {
                        $evolvedData = file_get_contents($api . "pokemon/" . $evolvedForm["species"]["name"]);
                        $evolvedResponse = json_decode($evolvedData, true);
                        echo "<img src='" . $evolvedResponse["sprites"]["front_default"] . "'>";

                    }
                }
                if ($thirdEvolution) {
                    foreach ($thirdEvolution as $evolvedForm) {
                        $evolvedData = file_get_contents($api . "pokemon/" . $evolvedForm["species"]["name"]);
                        $evolvedResponse = json_decode($evolvedData, true);
                        echo "<img src='" . $evolvedResponse["sprites"]["front_default"] . "'>";

                    }
                }

            }

            ?>
        </div>
        <div class="pokemon-data">
            <?php
            if( isset($_GET["pokemon"])){
                echo '<h2>' . $response["forms"]["0"]["name"] . ' #' . $response["id"] ."</h2>";
                echo "<br>";
                foreach ($types as $type) {
                    echo $type["type"]["name"] . "<br>";
                }
                echo "<br>";
                echo "<br>". $flavourEnglish[array_rand($flavourEnglish, 1)] . "<br>";
                echo "<br>";
                foreach (array_rand($moves, 4)as $index ) {
                    echo $moves[$index]["move"]["name"] . "<br>";
                }
            }
            ?>
        </div>
        <div class="search-container">
            <div class="search-buttons">
                <form action="index.php" method="get">
                    <input placeholder="Who's that Pokemon?"
                           type="text" name="pokemon"
                           class="search-bar"
                           id="pokemon-search"
                           autocomplete="false">
                    <button class="search-button hvr-buzz"
                            type="submit"
                            value="<img

                src='https://cdn.emojidex.com/emoji/seal/pokeball.png'
                emoji-code='pokeball'
                alt='pokeball'
                />"
                            id="submit"><img
                                class="pokeball hvr-buzz"
                                src="https://cdn.emojidex.com/emoji/seal/pokeball.png"
                                emoji-code="pokeball"
                                alt="pokeball">
                    </button>
                    <div class="button toggle-previous button-3" id="random-button">
                        <div id="circle"></div>
                        <a href="#">Random</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>