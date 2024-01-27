<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <title>Battle !</title>
</head>

<body>

    <?php
    session_start();
    if (isset($_POST['pkmJoueur']) && isset($_POST['pkmOrdi'])) {
        $_SESSION['pkmJoueur'] = $_POST['pkmJoueur'];
        $_SESSION['pkmOrdi'] = $_POST['pkmOrdi'];
    }

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
                // Permet d'attaquer
                $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
                $pkmO = $pkmManager->getPersonnageById($_SESSION['pkmOrdi']);
                $log = $pkmJ->attaque($pkmO);
                $pkmManager->updatePersonnage($pkmJ);
                $pkmManager->updatePersonnage($pkmO);
                break;
            case 'REST':
                // Permet de regenerer les points de vie
                $pkmJ = $pkmManager->getPersonnageById($_SESSION['pkmJoueur']);
                $log = $pkmJ->regenerer();
                $pkmManager->updatePersonnage($pkmJ);
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

    // Récupération des données des pokemons
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

                        if (isset($log)) {
                            echo $log;
                        } else {
                            echo 'What will ' . $pkmJ->getName() . ' do ?';
                        }

                        ?>
                    </span>
                </div>

                <div id="battleOverlayRight" class="pixel-corners">

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="./src/js/battle.js"></script>

</body>

</html>