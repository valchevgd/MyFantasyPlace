<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserDartsPlayer
 *
 * @ORM\Table(name="users_darts_players")
 * @ORM\Entity(repositoryClass="MyFantasyPlaceBundle\Repository\UserDartsPlayerRepository")
 */
class UserDartsPlayer
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
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="MyFantasyPlaceBundle\Entity\User", inversedBy="dartsPlayers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="MyFantasyPlaceBundle\Entity\DartsPlayer", inversedBy="users")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $playerId;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="float")
     */
    private $level = 1;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value = 1000;

    /**
     * @var int
     *
     * @ORM\Column(name="progress", type="float")
     */
    private $progress = 0;


    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return UserDartsPlayer
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
     * @return UserDartsPlayer
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
     * @return UserDartsPlayer
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
     * @return UserDartsPlayer
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
     * @return UserDartsPlayer
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

