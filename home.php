<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <title>Home</title>
</head>

<body>

    <audio id="backgroundMusic" controls autoplay loop>
        <source src="./src/Yoneuve.mp3" type="audio/mp3">
        Votre navigateur ne prend pas en charge l'élément audio.
    </audio>
    <button id="backgroundMusicButton" onclick="togglePause()">
        <img id="bgMusicImg" src="./img/sound.svg" alt="sound">
    </button>

    <a id="settingsButton" href="./backoffice.php">
        <img src="./img/round.svg" alt="">
    </a>

    <?php

    //Intégre la bdd
    require_once "./POO/connexion.php";

    // Permet de load automatiuement les classes
    spl_autoload_register(function ($class) {
        // Chemin du répertoire contenant les classes
        $classPath = __DIR__ . '/POO/' . $class . '.php';

        // Vérifier si le fichier de la classe existe
        if (file_exists($classPath)) {
            require_once $classPath;
        }
    });

    $pkmManager = new PokemonManager($db);

    $data = $pkmManager->getList();

    ?>

    <section id="homeSection">

        <div id="homeHeader">
            <img src="./img/pkmIcon.png" alt="Pokémon">
            <h1>Choisissez votre pokemon et votre adversaire.</h1>
        </div>

        <div id="homeWrapper">

            <div id="homeWrapperBodyBorder" class="pixel-corners--wrapper">

                <form id="homeBodyForm" action="./battle.php" method="post">

                    <div class="homeInputContainer">
                        <label for="pkmJoueurSelect">Votre pokemon</label>
                        <div class="pixel-corners--wrapper homeInputBorder">
                            <select class="homeInput" name="pkmJoueur" id="pkmJoueurSelect">
                                <option value="" disabled selected>Pokemon 1</option>
                                <?php

                                foreach ($data as $key => $value) {
                                    echo '<option value="' . $value->getId() . '">' . $value->getName() . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                    <div id="middleHomeForm">
                        <span class="homeVS">VS</span>
                        <button type="submit">
                            Battle !
                        </button>
                    </div>

                    <div class="homeInputContainer">
                        <label for="pkmOrdiSelect">Pokemon rival</label>
                        <div class="pixel-corners--wrapper homeInputBorder">
                            <select class="homeInput" name="pkmOrdi" id="pkmOrdiSelect">
                                <option value="" disabled selected>Pokemon 2</option>
                                <?php

                                foreach ($data as $key => $value) {
                                    echo '<option value="' . $value->getId() . '">' . $value->getName() . '</option>';
                                }

                                ?>
                            </select>
                        </div>
                    </div>

                </form>

            </div>

            <div id="homeWrapperAsideBorder" class="pixel-corners--wrapper">
                <div id="homeWrapperAside">

                    <?php

                    $data = $pkmManager->getList();

                    foreach ($data as $key => $value) {
                        echo '<div class="homePkmTemplate">';
                        echo '<img class="htemplatePkmImg" src="./img/' . $value->getName() . '.png" alt="' . $value->getName() . '">';
                        echo '<div class="htemplatePkmRight">';
                        echo '<div class="htemplatePkmInfoTop">';
                        echo '<p class="htemplatePkmName">' . $value->getName() . '</p>';
                        echo '<img src="./img/overlay_lv.png" alt="">';
                        echo '<span>' . $value->getLvl() . '</span>';
                        echo '</div>';
                        echo '<div class="htemplatePkmInfoBottom">';
                        echo '<img class="htemplateHpBar" src="./img/overlay_hp_back.png" alt="">';
                        echo '<span>' . $value->getPv() . '/' . $value->getMaxPv() . '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    ?>


                </div>
            </div>

        </div>

    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./src/js/home.js"></script>

</body>

</html>