<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="">
    <link
            href="https://fonts.googleapis.com/css2?family=VT323&display=swap"
            rel="stylesheet"
    />

    <title>Pokedex</title>
</head>
<body>
<?php
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");
error_reporting(E_ALL);
?>
<!--
    <div class="grid-container interface">
        <div class="search-container">
            <div class="search-items-grouped">
                <input
                        autocomplete="false"
                        name="hidden"
                        type="text"
                        placeholder="Who's that Pokemon?"
                        class="search bar"
                        id="pokemon-search"

                />
                <button class="search-button hvr-buzz" id="submit" >
                    <img
                            class="pokeball hvr-buzz"
                            src="https://cdn.emojidex.com/emoji/seal/pokeball.png"
                            emoji-code="pokeball"
                            alt="pokeball"
                    />
                </button>
                <label class="tickbox">Shiny
                    <input id="shiny-check" type="checkbox">
                    <span class="checkmark"></span>
                </label>
            </div>
            <div class="button toggle-previous button-3" id="previous-button">
                <div id="circle"></div>
                <a href="#">Previous</a>
            </div>
            <div class="button toggle-next button-3" id="next-button">
                <div id="circle"></div>
                <a href="#">Next</a>
            </div>
            <div class="button evolve button-3" id="evolve-button">
                <div id="circle"></div>
                <a href="#">Evolve!</a>
            </div>
            <div class="button species button-3" id="species-button">
                <div id="circle"></div>
                <a href="#">Species</a>
            </div>
        </div>


        <div class="pokemon-images">
            <div class="pokemon-on-display">
                <img id="sprite-target-front" src="" alt="" />
                <img id="sprite-target-back" src="" alt="" />
                <img id="sprite-evolution-1" src="" alt="" />
                <img id="sprite-evolution-2" src="" alt="" />
                <img id="sprite-evolution-3" src="" alt="" />
                <img id="sprite-evolution-4" src="" alt="" />
                <img id="sprite-evolution-5" src="" alt="" />
                <img id="sprite-evolution-6" src="" alt="" />
                <img id="sprite-evolution-7" src="" alt="" />
                <img id="sprite-evolution-8" src="" alt="" />
            </div>
        </div>
        <div class="pokemon-data">
            <div class="data-points">
                <div id="id-display"></div>
                <div id="name-target" class=""></div>
                <div id="flavour-text"></div>
                <ul id="moves"></ul>
            </div>
        </div>
        <div class="zone-1"></div>
        <div class="zone-2"></div>
        <div class="zone-3"></div>
        <div class="zone-4"></div>
    </div>
    </div>
</main>

-->
<form action="index.php" method="get">
    <input type="text" name="pokemon">
    <input type="submit" value="search">
</form>

<!-- php section   -->

<?php
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
  //  var_dump($secondEvolution);
  //  var_dump($thirdEvolution);
  }





// name displayed
echo '<h2>' . $response["forms"]["0"]["name"] . ' #' . $response["id"] ."</h2>";

// ID displayed
//echo '<p># ' . $response["id"]  . '</p>' ;

//Testing area
 //   var_dump($speciesResponse);
   // var_dump($flavourText);

  // var_dump($flavourEnglish);

   // var_dump($types[0]["type"]);

//types
   foreach ($types as $type) {
        echo $type["type"]["name"] . "<br>";
    }
   echo "<br>";

//moves displayed
foreach (array_rand($moves, 4)as $index ) {
    echo $moves[$index]["move"]["name"] . "<br>";
}

//var_dump($moves);
//foreach ($moves as $move) {
  //  echo $move["move"]["name"] . "<br>";



  // echo "<img src='" . $response["sprites"]["front_default"] . "'>";
// var_dump($moves);

// Flavor text
    $flavourEnglish = [];
    foreach ($flavourText as $text) {
        if($text["language"]["name"] === "en"){
            array_push ($flavourEnglish , $text ["flavor_text"]);
        }
    }
    //var_dump(array_rand($flavourEnglish, 1));

    echo "<br>". $flavourEnglish[array_rand($flavourEnglish, 1)] . "<br>";



    //sprites front and back and shiny displayed
    echo "<img src='" . $response["sprites"]["front_default"] . " '> <img src='" . $response["sprites"]["back_default"] ."'>
         <br> <img src='" . $response["sprites"]["front_shiny"] . " '> <img src='" . $response["sprites"]["back_shiny"] ."'> <br>";

    //var_dump($flavourEnglish);

    // Evolutionchain display

  //  echo $firstEvolution


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


var_dump($response);

}

// This is example of a function that finds random entries n arrays,       array_rand ( array $array [, int $num = 1 ] ) : mixed

?>

</body>
</html>



