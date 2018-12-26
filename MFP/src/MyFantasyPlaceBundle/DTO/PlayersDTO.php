<?php

namespace MyFantasyPlaceBundle\DTO;


use Doctrine\Common\Collections\ArrayCollection;

class PlayersDTO
{
    /**
     * @var ArrayCollection
     */
    private $players;


    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @param ArrayCollection $players
     */
    public function addPlayers($players)
    {
        $this->players[] = $players;
    }




}