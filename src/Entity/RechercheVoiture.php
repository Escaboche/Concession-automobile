<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class RechercheVoiture{
    /** 
    * @Assert\LessThanOrEqual(propertyPath="maxAnnee")
    */
    private $minAnnee;

    /**
     * @Assert\GreaterThanOrEqual(propertyPath="minAnnee")
     */
    private $maxAnnee;

    public function getMinAnnee()
    {
        return $this->minAnnee;
    }

    public function getMaxAnnee()
    {
        return $this->maxAnnee;
    }
    public function setMinAnnee(int $Annee)
    {
        $this->minAnnee = $Annee;
        return $this;
    }
    public function setMaxAnnee(int $Annee)
    {
        $this->maxAnnee = $Annee;
        return $this;
    }
}