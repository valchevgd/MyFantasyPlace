<?php
/**
 * Created by PhpStorm.
 * User: valchevgd
 * Date: 12/24/2018
 * Time: 3:58 PM
 */

namespace MyFantasyPlaceBundle\DTO;


use Doctrine\Common\Collections\ArrayCollection;

class PlayersToRemoveDTO
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