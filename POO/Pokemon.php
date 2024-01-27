<?php

class Pokemon
{
    // ======== VARIABLES ========
    private $name = "";
    private $pv = "";
    private $maxPv = "";
    private $atk = "";
    private $lvl = "";
    private $id = "";
    private static $nbPkm = 0;


    // Permet d'initialiser les variables en utilisant les setters
    public function __construct(array $data)
    {
        $this->hydrate($data);
        self::$nbPkm++;
    }

    // Permet de regenerer les points de vie ( si $x est null, on regenere tout, sinon on regenere $x points de vie )
    public function regenerer()
    {
        $x = rand(1, 15); // Generate a random number between 1 and 10
        $this->pv = min($this->pv + $x, $this->maxPv);
        return "$this->name s'est regenere de $x points de vie !";
    }


    // Permet de reinitialiser les points de vie
    public function reinitPv()
    {
        $this->pv = $this->maxPv;
    }

    // Permet de savoir si le personnage est vivant ou non
    public function isAlive()
    {
        return $this->pv <= 0;
    }

    // Permet d'attaquer une cible
    public function attaque($cible)
    {
        $cible->pv -= $this->atk;
        return "$this->name attacks $cible->name, It deals $this->atk points of damage !";
    }

    // ======== GETTERS ET SETTERS ========

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->name = $name;
        }
    }

    public function getPv()
    {
        return $this->pv;
    }

    public function setPv($pv)
    {
        $this->pv = $pv;
    }

    public function getMaxPv()
    {
        return $this->maxPv;
    }

    public function setMaxPv($maxPv)
    {
        $this->maxPv = $maxPv;
    }

    public function getAtk()
    {
        return $this->atk;
    }

    public function setAtk($atk)
    {
        $this->atk = $atk;
    }

    public function getLvl()
    {
        return $this->lvl;
    }

    public function setLvl($lvl)
    {
        $this->lvl = $lvl;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        if (is_int($id)) {
            $this->id = $id;
        }
    }

    public static function getNbPersonnage()
    {
        return self::$nbPkm;
    }

    // ======== Hydratation ========

    // Permet d'hydrater l'objet
    public function hydrate(array $data)
    {
        // Pour chaque clé du tableau, on récupère la valeur
        foreach ($data as $key => $value) {

            // On récupère le nom du setter correspondant à l'attribut
            $method = "set" . ucfirst($key);

            // Si le setter correspondant existe
            if (method_exists($this, $method)) {

                // On appelle le setter ( $method = "setPv" par exemple )
                $this->$method($value);
            }
        }
    }
}
