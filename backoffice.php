<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./src/css/style.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>

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

    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'deletePkm':
                $pkmManager->deletePersonnage($pkmManager->getPersonnageById($_POST['id']));
                break;
            case 'editPkm':
                $editPkm = $pkmManager->getPersonnageById($_POST['id']);
                $editPkm->setName($_POST['name']);
                $editPkm->setPv($_POST['pv']);
                $editPkm->setMaxPv($_POST['maxPv']);
                $editPkm->setAtk($_POST['atk']);
                $editPkm->setLvl($_POST['lvl']);
                $editPkm->setTypePkm($_POST['type']);
                $pkmManager->updatePersonnage($editPkm);
                break;
            case 'addPkm':
                $pkmManager->addPersonnage(new Pokemon([
                    'name' => $_POST['name'],
                    'pv' => $_POST['pv'],
                    'maxPv' => $_POST['maxPv'],
                    'atk' => $_POST['atk'],
                    'lvl' => $_POST['lvl'],
                    'typePkm' => $_POST['type']
                ]));
                break;
            default:
                break;
        }
    }

    $data = $pkmManager->getList();

    ?>

    <section id="backofficeSection">
        <h1>Backoffice</h1>
        <a id="backofficeBack" href="./home.php">Retour a l'accueil</a>
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
                    echo '<div class="toolsContainer">';
                    echo '
                    <button type="button" class="editTool" data-bs-toggle="modal" data-bs-target="#persoModal' . $value->getId() . '">
                    <img src="./img/boEdit.svg" alt="">
                    </button>';
                    echo '<form action="./backoffice.php" method="post">';
                    echo '<input type="hidden" name="action" value="deletePkm">';
                    echo '<input type="hidden" name="id" value="' . $value->getId() . '">';
                    echo '<button class="deleteTool" type="submit" name="delete"> <img src="./img/boDelete.svg" alt=""> </button>';
                    echo '</form>';
                    echo '</div>';
                    echo '</div>';
                }

                ?>
            </div>

        </div>

        <?php

        foreach ($data as $key => $value) {
            echo '<div class="modal fade" id="persoModal' . $value->getId() . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">';
            echo '<div class="modal-dialog">';
            echo '<div class="modal-content">';
            echo '<div class="modal-header">';
            echo '<h5 class="modal-title" id="exampleModalLabel">Modifier ' . $value->getName() . '</h5>';
            echo '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
            echo '</div>';
            echo '<div class="modal-body">';
            echo '<form action="./backoffice.php" method="post">';
            echo '<input type="hidden" name="action" value="editPkm">';
            echo '<input type="hidden" name="id" value="' . $value->getId() . '">';
            echo '<div class="mb-3">';
            echo '<label for="name" class="form-label">Nom</label>';
            echo '<input type="text" class="form-control" id="name" name="name" value="' . $value->getName() . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="pv" class="form-label">PV</label>';
            echo '<input type="number" class="form-control" id="pv" name="pv" value="' . $value->getPv() . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="maxPv" class="form-label">PV Max</label>';
            echo '<input type="number" class="form-control" id="maxPv" name="maxPv" value="' . $value->getMaxPv() . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="atk" class="form-label">Attaque</label>';
            echo '<input type="number" class="form-control" id="atk" name="atk" value="' . $value->getAtk() . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="lvl" class="form-label">Niveau</label>';
            echo '<input type="number" class="form-control" id="lvl" name="lvl" value="' . $value->getLvl() . '">';
            echo '</div>';
            echo '<div class="mb-3">';
            echo '<label for="type" class="form-label">Type</label>';
            echo '<input type="text" class="form-control" id="type" name="type" value="' . $value->getTypePkm() . '">';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary">Modifier</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        ?>

        <button id="addPkmButton" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
            Ajouter un pokemon
        </button>

        <!-- Add Pokemon Modal -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Ajouter un Pokemon</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="./backoffice.php" method="post">
                            <input type="hidden" name="action" value="addPkm">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="pv" class="form-label">PV</label>
                                <input type="number" class="form-control" id="pv" name="pv" required>
                            </div>
                            <div class="mb-3">
                                <label for="maxPv" class="form-label">PV Max</label>
                                <input type="number" class="form-control" id="maxPv" name="maxPv" required>
                            </div>
                            <div class="mb-3">
                                <label for="atk" class="form-label">Attaque</label>
                                <input type="number" class="form-control" id="atk" name="atk" required>
                            </div>
                            <div class="mb-3">
                                <label for="lvl" class="form-label">Niveau</label>
                                <input type="number" class="form-control" id="lvl" name="lvl" required>
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" class="form-control" id="type" name="type" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

</body>

</html>