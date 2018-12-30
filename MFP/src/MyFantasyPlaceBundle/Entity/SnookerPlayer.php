<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SnookerPlayer
 *
 * @ORM\Table(name="snooker_players")
 * @ORM\Entity(repositoryClass="MyFantasyPlaceBundle\Repository\SnookerPlayerRepository")
 */
class SnookerPlayer
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=true)
     */
    private $status = null;

    /**
     * @var int
     *
     * @ORM\Column(name="tournament_over_seventy", type="integer")
     */
    private $tournamentOverSeventy = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tournament_centuries", type="integer")
     */
    private $tournamentCenturies = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="tournament_fantasy_points", type="float")
     */
    private $tournamentFantasyPoints = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="season_over_seventy", type="integer")
     */
    private $seasonOverSeventy = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="season_centuries", type="integer")
     */
    private $seasonCenturies = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="season_fantasy_points", type="float")
     */
    private $seasonFantasyPoints = 0;

    /**
     * @var ArrayCollection|User
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserSnookerPlayer", mappedBy="playerId")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection|User $users
     */
    public function addUsers($users)
    {
        $this->users[] = $users;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return SnookerPlayer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param float $value
     *
     * @return SnookerPlayer
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
     * Set status
     *
     * @param string $status
     *
     * @return SnookerPlayer
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set tournamentOverSeventy
     *
     * @param integer $tournamentOverSeventy
     *
     * @return SnookerPlayer
     */
    public function setTournamentOverSeventy($tournamentOverSeventy)
    {
        $this->tournamentOverSeventy = $tournamentOverSeventy;

        return $this;
    }

    /**
     * Get tournamentOverSeventy
     *
     * @return int
     */
    public function getTournamentOverSeventy()
    {
        return $this->tournamentOverSeventy;
    }

    /**
     * Set tournamentCenturies
     *
     * @param integer $tournamentCenturies
     *
     * @return SnookerPlayer
     */
    public function setTournamentCenturies($tournamentCenturies)
    {
        $this->tournamentCenturies = $tournamentCenturies;

        return $this;
    }

    /**
     * Get tournamentCenturies
     *
     * @return int
     */
    public function getTournamentCenturies()
    {
        return $this->tournamentCenturies;
    }

    /**
     * Set tournamentPoints
     *
     * @param float $tournamentFantasyPoints
     *
     * @return SnookerPlayer
     */
    public function setTournamentFantasyPoints($tournamentFantasyPoints)
    {
        $this->tournamentFantasyPoints = $tournamentFantasyPoints;

        return $this;
    }

    /**
     * Get tournamentFantasyPoints
     *
     * @return float
     */
    public function getTournamentFantasyPoints()
    {
        return $this->tournamentFantasyPoints;
    }

    /**
     * Set seasonOverSeventy
     *
     * @param integer $seasonOverSeventy
     *
     * @return SnookerPlayer
     */
    public function setSeasonOverSeventy($seasonOverSeventy)
    {
        $this->seasonOverSeventy = $seasonOverSeventy;

        return $this;
    }

    /**
     * Get seasonOverSeventy
     *
     * @return int
     */
    public function getSeasonOverSeventy()
    {
        return $this->seasonOverSeventy;
    }

    /**
     * Set seasonCenturies
     *
     * @param integer $seasonCenturies
     *
     * @return SnookerPlayer
     */
    public function setSeasonCenturies($seasonCenturies)
    {
        $this->seasonCenturies = $seasonCenturies;

        return $this;
    }

    /**
     * Get seasonCenturies
     *
     * @return int
     */
    public function getSeasonCenturies()
    {
        return $this->seasonCenturies;
    }

    /**
     * Set seasonFantasyPoints
     *
     * @param float $seasonFantasyPoints
     *
     * @return SnookerPlayer
     */
    public function setSeasonPoints($seasonFantasyPoints)
    {
        $this->seasonFantasyPoints = $seasonFantasyPoints;

        return $this;
    }

    /**
     * Get seasonFantasyPoints
     *
     * @return float
     */
    public function getSeasonFantasyPoints()
    {
        return $this->seasonFantasyPoints;
    }
}

