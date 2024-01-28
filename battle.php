<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">

    <title>Battle !</title>
</head>

<body>

    <audio id="backgroundMusic" controls autoplay loop>
        <source src="./src/Battle.mp3" type="audio/mp3">
        Votre navigateur ne prend pas en charge l'élément audio.
    </audio>
    <button id="backgroundMusicButton" onclick="togglePause()">
        <img id="bgMusicImg" src="./img/sound.svg" alt="sound">
    </button>

    <!-- Appel du script pour que l'affichage du JS se passe bien -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <?php
    // Démarre la session & attribue les id des pokemons à la session
    session_start();
    if (isset($_POST['pkmJoueur']) && isset($_POST['pkmOrdi'])) {
        $_SESSION['pkmJoueur'] = $_POST['pkmJoueur'];
        $_SESSION['pkmOrdi'] = $_POST['pkmOrdi'];
    }

    // Vérifie si les pokemons sont bien attribués
    if (!isset($_SESSION['pkmJoueur']) || !isset($_SESSION['pkmOrdi'])) {
        header('Location: ./home.php');
    }

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

    // Initialisation des objets
    $pkmManager = new PokemonManager($db);

    // Vérifications des actions
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'FIGHT':
                echo '<script> </script>';
                // Permet d'attaquer
                $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
                $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
                $logJ = $pkmJ->attaque($pkmO);
                $pkmManager->updatePersonnage($pkmJ);
                $pkmManager->updatePersonnage($pkmO);

                // Permet de faire jouer l'ordi avant l'affichage du dialogue
                $actionOrdi = rand(1, 2);
                if ($actionOrdi == 1) {
                    $logO = $pkmO->attaque($pkmJ);
                    $pkmManager->updatePersonnage($pkmO);
                    $pkmManager->updatePersonnage($pkmJ);
                } else {
                    $logO = $pkmO->regenerer();
                    $pkmManager->updatePersonnage($pkmO);
                }

                // On cache les bouttons de l'overlay
                // Appel de la fonction pour changer le dialogue après 3s
                echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        $("#battleOverlayRightContainer").css("display", "none");
                    });
                    setTimeout(function() {
                        afficherActionAdverse();
                    }, 2000);
                </script>';
                break;

            case 'REST':
                // Permet de regenerer les points de vie
                $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
                $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
                $logJ = $pkmJ->regenerer();
                $pkmManager->updatePersonnage($pkmJ);

                // Permet de faire jouer l'ordi avant l'affichage du dialogue
                $actionOrdi = rand(1, 2);
                if ($actionOrdi == 1) {
                    $logO = $pkmO->attaque($pkmJ);
                    $pkmManager->updatePersonnage($pkmO);
                    $pkmManager->updatePersonnage($pkmJ);
                } else {
                    $logO = $pkmO->regenerer();
                    $pkmManager->updatePersonnage($pkmO);
                }

                // On cache les bouttons de l'overlay
                // Appel de la fonction pour changer le dialogue après 3s
                echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    $("#battleOverlayRightContainer").css("display", "none");
                });
                setTimeout(function() {
                    afficherActionAdverse();
                }, 2000);
            </script>';

                break;
            case 'RUN':
                // Permet de quitter la partie

                // Reinitialisation des points de vie
                $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
                $pkmJ->reinitPv();
                $pkmManager->updatePersonnage($pkmJ);
                $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
                $pkmO->reinitPv();
                $pkmManager->updatePersonnage($pkmO);

                // Suppression des variables de session
                unset($_SESSION['pkmJoueur']);
                unset($_SESSION['pkmOrdi']);
                session_destroy();

                // Redirection vers la page d'accueil
                header('Location: ./home.php');
                break;
            default:
                break;
        }
    }

    // Récupération des données des pokemons actualisé après action pour l'affichage
    $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
    $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);

    ?>

    <section id="battleSection">

        <div id="battleScene">
            <div id="gifPokemonPlayer">
                <?php
                echo '<img src="./img/' . $pkmJ->getName() . '-back.gif" alt="">';
                ?>
            </div>

            <div id="gifPokemonOrdi">
                <?php
                echo '<img src="./img/' . $pkmO->getName() . '-front.gif" alt="">';
                ?>
            </div>
        </div>

        <div id="battleOverlay">

            <div id="battleOverlayHeader">
                <?php

                // Affichage de l'overlay du pokémon du joueur
                echo '<div id="battleOverlayPlayer" class="battleOverlayInfo">
                    <div class="btemplatePkmRight">
                        <div class="btemplatePkmInfoTop">
                            <p class="btemplatePkmName">' . $pkmJ->getName() . '</p>
                            <img src="./img/overlay_lv.png" alt="">
                            <span>' . $pkmJ->getLvl() . '</span>
                        </div>
                        <span class="pvCounter">' . $pkmJ->getPv() . '/' . $pkmJ->getMaxPv() . '</span>
                        <img class="btemplateHpBar" src="./img/databox_normal.png" alt="">
                    </div>
                </div>';

                // Affichage de l'overlay du pokémon de l'ordi
                echo '<div id="battleOverlayOrdi" class="battleOverlayInfo">
                    <div class="btemplatePkmRight">
                        <div class="btemplatePkmInfoTop">
                            <p class="btemplatePkmName">' . $pkmO->getName() . '</p>
                            <img src="./img/overlay_lv.png" alt="">
                            <span>' . $pkmO->getLvl() . '</span>
                        </div>
                        <span class="pvCounter">' . $pkmO->getPv() . '/' . $pkmO->getMaxPv() . '</span>
                        <img class="btemplateHpBar" src="./img/databox_normal_foe.png" alt="">
                    </div>
                </div>';

                ?>
            </div>

            <div id="battleOverlayFooter">
                <div id="battleOverlayLeft" class="pixel-corners">
                    <span id="overlayText">
                        <?php

                        // Affichage des dialogues de combat
                        if (isset($logJ)) {
                            echo $logJ;
                        } else {
                            echo 'What will ' . $pkmJ->getName() . ' do ?';
                        }

                        ?>
                    </span>
                </div>

                <div id="battleOverlayRight" class="pixel-corners" style="display: grid;">

                    <div id="battleOverlayRightContainer">
                        <form class="overlayButton" method="post">
                            <button type="submit" name="action" value="FIGHT" class="pixel-corners">FIGHT</button>
                        </form>
                        <form class="overlayButton" method="post">
                            <button id="overlayButtonRest" type="submit" name="action" value="REST" class="pixel-corners">REST</button>
                        </form>
                        <form class="overlayButton" method="post">
                            <button type="submit" class="pixel-corners" disabled>POKEMON</button>
                        </form>
                        <form class="overlayButton" method="post" onsubmit="return confirmRun()">
                            <button type="submit" name="action" value="RUN" class="pixel-corners">RUN</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>


    <?php

    // Vérification des points de vie
    if ($pkmJ->getPv() <= 0) {
        echo '<script>alert("Vous avez perdu !")</script>';

        // Reinitialisation des points de vie
        $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
        $pkmJ->reinitPv();
        $pkmManager->updatePersonnage($pkmJ);
        $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
        $pkmO->reinitPv();
        $pkmManager->updatePersonnage($pkmO);
        echo '<script>document.location.href="./home.php"</script>';
    } elseif ($pkmO->getPv() <= 0) {
        echo '<script>alert("Vous avez gagné !")</script>';

        // Reinitialisation des points de vie
        $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
        $pkmJ->reinitPv();
        $pkmManager->updatePersonnage($pkmJ);
        $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
        $pkmO->reinitPv();
        $pkmManager->updatePersonnage($pkmO);
        echo '<script>document.location.href="./home.php"</script>';
    }

    ?>

    <script>
        // Cette fonction affiche l'action du personnage adverse
        function afficherActionAdverse() {

            // Affiche l'action dans le résultat
            $("#overlayText").empty();
            $("#overlayText").append("<?php echo $logO; ?>");

            // Réinitialise l'affichage du tour du joueur
            $("#battleOverlayRightContainer").css("display", "grid");
        }
    </script>

    <script src="./src/js/battle.js"></script>

</body>

</html>