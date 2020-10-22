<?php

namespace App\Data;


use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Participant;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints as Assert;

class Recherche{


    /**
     * @var Campus
     */
    public $campus;

    /**
     * @var null|string
     */
    public $search = '';

    /**
     * @var null|DateTime
     */
    public  $dateDebut;

    /**
     * @var null|DateTime
     *  @Assert\Expression(
     *     "this.getDateLimite() <= this.getDateDebut()",
     *  message="La date limite d'inscription ne peut dépasser celle de la sortie"
     * )
     */
    public   $dateLimite;

    /**
     * @var Participant
     */
    public $organisateur;

    /**
     * @var null|string
     */
    public $inscription;

    /**
     * @var Etat
     */
    public $etat;

    /**
     * @return DateTime|null
     */
    public function getDateDebut(): ?\DateTime
    {
        return $this->dateDebut;
    }

    /**
     * @return DateTime|null
     */
    public function getDateLimite(): ?\DateTime
    {
        return $this->dateLimite;
    }



}

