<?php

namespace App\Entity;

class AssociationSearch {
    /**
     * @var string
     */ 
    private $city;

    /**
     * Get the value of city
     */ 
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set the value of city
     *
     * @return  self
     */ 
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }
}


?>
