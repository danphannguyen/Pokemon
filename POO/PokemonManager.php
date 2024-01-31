<?php

class PokemonManager
{

    // Instancie la bdd
    private $db;

    // Constructeur
    public function __construct($db)
    {
        $this->setDb($db);
    }

    // Setter
    public function setDb(PDO $db)
    {
        $this->db = $db;
    }

    // Fonction get all
    public function getList() {
        $query = $this -> db -> query('SELECT * FROM Pokemons');

        while ($data = $query -> fetch(PDO::FETCH_ASSOC)) {
            $persos[] = new Pokemon($data);
        }

        return $persos;
    }

    // Fonction add
    public function addPersonnage(Pokemon $perso) {
        $query = $this -> db -> prepare('INSERT INTO Pokemons(name, pv, atk, maxPv, lvl, typePkm) VALUES(:name, :pv, :atk, :maxpv, :lvl, :typePkm)');
        $query -> bindValue(':name', $perso -> getName());
        $query -> bindValue(':pv', $perso -> getPv());
        $query -> bindValue(':atk', $perso -> getAtk());
        $query -> bindValue(':maxpv', $perso -> getMaxPv());
        $query -> bindValue(':lvl', $perso -> getLvl());
        $query -> bindValue(':typePkm', $perso -> getTypePkm());
        $query -> execute();
    }

    // Fonction get by id
    public function getPersonnageById($id) {
        $query = $this -> db -> prepare('SELECT * FROM Pokemons WHERE id = :id');
        $query -> bindValue(':id', $id);
        $query -> execute();

        $data = $query -> fetch(PDO::FETCH_ASSOC);

        return new Pokemon($data);
    }

    // Fonction delete
    public function deletePersonnage(Pokemon $perso) {
        $query = $this -> db -> prepare('DELETE FROM Pokemons WHERE id = :id');
        $query -> bindValue(':id', $perso -> getId());
        $query -> execute();
    }

    // Fonction update
    public function updatePersonnage(Pokemon $perso) {
        $query = $this -> db -> prepare('UPDATE Pokemons SET name = :name, pv = :pv, atk = :atk, maxPv = :maxpv, lvl = :lvl, typePkm = :typePkm  WHERE id = :id');
        $query -> bindValue(':name', $perso -> getName());
        $query -> bindValue(':pv', $perso -> getPv());
        $query -> bindValue(':atk', $perso -> getAtk());
        $query -> bindValue(':id', $perso -> getId());
        $query -> bindValue(':maxpv', $perso -> getMaxPv());
        $query -> bindValue(':lvl', $perso -> getLvl());
        $query -> bindValue(':typePkm', $perso -> getTypePkm());
        $query -> execute();
    }

}
