<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserSnookerPlayer
 *
 * @ORM\Table(name="user_snooker_player")
 * @ORM\Entity(repositoryClass="MyFantasyPlaceBundle\Repository\UserSnookerPlayerRepository")
 */
class UserSnookerPlayer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="MyFantasyPlaceBundle\Entity\User", inversedBy="snookerPlayers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="MyFantasyPlaceBundle\Entity\SnookerPlayer", inversedBy="users")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $playerId;

    /**
     * @var float
     *
     * @ORM\Column(name="level", type="float")
     */
    private $level = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value = 1000;

    /**
     * @var float
     *
     * @ORM\Column(name="progress", type="float")
     */
    private $progress = 0;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserSnookerPlayer
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set playerId
     *
     * @param integer $playerId
     *
     * @return UserSnookerPlayer
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

    /**
     * Get playerId
     *
     * @return int
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * Set level
     *
     * @param float $level
     *
     * @return UserSnookerPlayer
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return float
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return UserSnookerPlayer
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set progress
     *
     * @param float $progress
     *
     * @return UserSnookerPlayer
     */
    public function setProgress($progress)
    {
        $this->progress = $progress;

        return $this;
    }

    /**
     * Get progress
     *
     * @return float
     */
    public function getProgress()
    {
        return $this->progress;
    }
}

