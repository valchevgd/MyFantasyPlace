<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * DartsPlayer
 *
 * @ORM\Table(name="darts_players")
 * @ORM\Entity(repositoryClass="MyFantasyPlaceBundle\Repository\DartsPlayerRepository")
 */
class DartsPlayer
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
     * @ORM\Column(name="tournament_over_hundred", type="integer")
     */
    private $tournamentOverHundred = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tournament_over_oneHundredAndForty", type="integer")
     */
    private $tournamentOverOneHundredAndForty = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tournament_maximums", type="integer")
     */
    private $tournamentMaximums = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="tournament_checkout_percentage", type="float")
     */
    private $tournamentCheckoutPercentage = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="tournament_average_three_darts", type="float")
     */
    private $tournamentAverageThreeDarts = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="tournament_games_played", type="integer")
     */
    private $tournamentGamesPlayed = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="tournament_fantasy_points", type="float")
     */
    private $tournamentFantasyPoints = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="season_over_hundred", type="integer")
     */
    private $seasonOverHundred = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="season_over_oneHundredAndForty", type="integer")
     */
    private $seasonOverOneHundredAndForty = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="season_maximums", type="integer")
     */
    private $seasonMaximums = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="season_checkout_percentage", type="float")
     */
    private $seasonCheckoutPercentage = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="season_average_three_darts", type="float")
     */
    private $seasonAverageThreeDarts = 0;

    /**
     * @var ArrayCollection|User
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserDartsPlayer", mappedBy="playerId")
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
     * @return int
     */
    public function getTournamentGamesPlayed()
    {
        return $this->tournamentGamesPlayed;
    }

    /**
     * @param int $tournamentGamesPlayed
     * @return DartsPlayer
     */
    public function setTournamentGamesPlayed(int $tournamentGamesPlayed)
    {
        $this->tournamentGamesPlayed = $tournamentGamesPlayed;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeasonGamesPlayed()
    {
        return $this->seasonGamesPlayed;
    }

    /**
     * @param int $seasonGamesPlayed
     * @return DartsPlayer
     */
    public function setSeasonGamesPlayed(int $seasonGamesPlayed)
    {
        $this->seasonGamesPlayed = $seasonGamesPlayed;

        return $this;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="season_games_played", type="integer")
     */
    private $seasonGamesPlayed = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="season_fantasy_points", type="float")
     */
    private $seasonFantasyPoints = 0;


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
     * @return DartsPlayer
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
     * @return DartsPlayer
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
     * @return DartsPlayer
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
     * Set tournamentOverHundred
     *
     * @param integer $tournamentOverHundred
     *
     * @return DartsPlayer
     */
    public function setTournamentOverHundred($tournamentOverHundred)
    {
        $this->tournamentOverHundred = $tournamentOverHundred;

        return $this;
    }

    /**
     * Get tournamentOverHundred
     *
     * @return int
     */
    public function getTournamentOverHundred()
    {
        return $this->tournamentOverHundred;
    }

    /**
     * Set tournamentOverOneHundredAndForty
     *
     * @param integer $tournamentOverOneHundredAndForty
     *
     * @return DartsPlayer
     */
    public function setTournamentOverOneHundredAndForty($tournamentOverOneHundredAndForty)
    {
        $this->tournamentOverOneHundredAndForty = $tournamentOverOneHundredAndForty;

        return $this;
    }

    /**
     * Get tournamentOverOneHundredAndForty
     *
     * @return int
     */
    public function getTournamentOverOneHundredAndForty()
    {
        return $this->tournamentOverOneHundredAndForty;
    }

    /**
     * Set tournamentMaximums
     *
     * @param integer $tournamentMaximums
     *
     * @return DartsPlayer
     */
    public function setTournamentMaximums($tournamentMaximums)
    {
        $this->tournamentMaximums = $tournamentMaximums;

        return $this;
    }

    /**
     * Get tournamentMaximums
     *
     * @return int
     */
    public function getTournamentMaximums()
    {
        return $this->tournamentMaximums;
    }

    /**
     * Set tournamentCheckoutPercentage
     *
     * @param float $tournamentCheckoutPercentage
     *
     * @return DartsPlayer
     */
    public function setTournamentCheckoutPercentage($tournamentCheckoutPercentage)
    {
        $this->tournamentCheckoutPercentage = $tournamentCheckoutPercentage;

        return $this;
    }

    /**
     * Get tournamentCheckoutPercentage
     *
     * @return float
     */
    public function getTournamentCheckoutPercentage()
    {
        return $this->tournamentCheckoutPercentage;
    }

    /**
     * Set tournamentAverageThreeDarts
     *
     * @param float $tournamentAverageThreeDarts
     *
     * @return DartsPlayer
     */
    public function setTournamentAverageThreeDarts($tournamentAverageThreeDarts)
    {
        $this->tournamentAverageThreeDarts = $tournamentAverageThreeDarts;

        return $this;
    }

    /**
     * Get tournamentAverageThreeDarts
     *
     * @return float
     */
    public function getTournamentAverageThreeDarts()
    {
        return $this->tournamentAverageThreeDarts;
    }

    /**
     * Set tournamentFantasyPoints
     *
     * @param float $tournamentFantasyPoints
     *
     * @return DartsPlayer
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
     * Set seasonOverHundred
     *
     * @param integer $seasonOverHundred
     *
     * @return DartsPlayer
     */
    public function setSeasonOverHundred($seasonOverHundred)
    {
        $this->seasonOverHundred = $seasonOverHundred;

        return $this;
    }

    /**
     * Get seasonOverHundred
     *
     * @return int
     */
    public function getSeasonOverHundred()
    {
        return $this->seasonOverHundred;
    }

    /**
     * Set seasonOverOneHundredAndForty
     *
     * @param integer $seasonOverOneHundredAndForty
     *
     * @return DartsPlayer
     */
    public function setSeasonOverOneHundredAndForty($seasonOverOneHundredAndForty)
    {
        $this->seasonOverOneHundredAndForty = $seasonOverOneHundredAndForty;

        return $this;
    }

    /**
     * Get seasonOverOneHundredAndForty
     *
     * @return int
     */
    public function getSeasonOverOneHundredAndForty()
    {
        return $this->seasonOverOneHundredAndForty;
    }

    /**
     * Set seasonMaximums
     *
     * @param integer $seasonMaximums
     *
     * @return DartsPlayer
     */
    public function setSeasonMaximums($seasonMaximums)
    {
        $this->seasonMaximums = $seasonMaximums;

        return $this;
    }

    /**
     * Get seasonMaximums
     *
     * @return int
     */
    public function getSeasonMaximums()
    {
        return $this->seasonMaximums;
    }

    /**
     * Set seasonCheckoutPercentage
     *
     * @param float $seasonCheckoutPercentage
     *
     * @return DartsPlayer
     */
    public function setSeasonCheckoutPercentage($seasonCheckoutPercentage)
    {
        $this->seasonCheckoutPercentage = $seasonCheckoutPercentage;

        return $this;
    }

    /**
     * Get seasonCheckoutPercentage
     *
     * @return float
     */
    public function getSeasonCheckoutPercentage()
    {
        return $this->seasonCheckoutPercentage;
    }

    /**
     * Set seasonAverageThreeDarts
     *
     * @param float $seasonAverageThreeDarts
     *
     * @return DartsPlayer
     */
    public function setSeasonAverageThreeDarts($seasonAverageThreeDarts)
    {
        $this->seasonAverageThreeDarts = $seasonAverageThreeDarts;

        return $this;
    }

    /**
     * Get seasonAverageThreeDarts
     *
     * @return float
     */
    public function getSeasonAverageThreeDarts()
    {
        return $this->seasonAverageThreeDarts;
    }

    /**
     * Set seasonFantasyPoints
     *
     * @param float $seasonFantasyPoints
     *
     * @return DartsPlayer
     */
    public function setSeasonFantasyPoints($seasonFantasyPoints)
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

