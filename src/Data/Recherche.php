<?php

namespace App\Data;


use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

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
     * @var null|DateTimeType
     */
    public  $dateDebut;

    /**
     * @var null|DateTimeType
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
     * @var array
     */
    public $etat=[];





}

