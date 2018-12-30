<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * UserService
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="MyFantasyPlaceBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * @var string
     *
     * @ORM\Column(name="full_name", type="string", length=255)
     */
    private $fullName;

    /**
     * @var float
     *
     * @ORM\Column(name="darts_team_value", type="float")
     */
    private $dartsTeamValue = 35;

    /**
     * @var float
     *
     * @ORM\Column(name="darts_tournament_team_value", type="float")
     */
    private $dartsTournamentTeamValue = 20;

    /**
     * @var float
     *
     * @ORM\Column(name="darts_total_points", type="float")
     */
    private $dartsTotalPoints = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="darts_tournament_points", type="float")
     */
    private $dartsTournamentPoints = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="snooker_team_value", type="float")
     */
    private $snookerTeamValue = 35;

    /**
     * @var float
     *
     * @ORM\Column(name="snooker_tournament_team_value", type="float")
     */
    private $snookerTournamentTeamValue = 20;

    /**
     * @var float
     *
     * @ORM\Column(name="snooker_total_points", type="float")
     */
    private $snookerTotalPoints = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="snooker_tournament_points", type="float")
     */
    private $snookerTournamentPoints = 0;

    /**
     * @var float
     *
     * @ORM\Column(name="fantasy_tokens", type="float")
     */
    private $fantasyTokens = 0;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_admin", type="boolean")
     */
    private $isAdmin = false;

    /**
     * @var ArrayCollection|DartsPlayer[]
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserDartsPlayer", mappedBy="userId")
     */
    private $dartsPlayers;

    /**
     * @var ArrayCollection|SnookerPlayer[]
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserSnookerPlayer", mappedBy="userId")
     */
    private $snookerPlayers;

    public function __construct()
    {
        $this->dartsPlayers = new ArrayCollection();
        $this->snookerPlayers = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|SnookerPlayer[]
     */
    public function getSnookerPlayers()
    {
        return $this->snookerPlayers;
    }

    /**
     * @param ArrayCollection|SnookerPlayer[] $snookerPlayers
     */
    public function addSnookerPlayers($snookerPlayers)
    {
        $this->snookerPlayers[] = $snookerPlayers;
    }



    /**
     * @return ArrayCollection|DartsPlayer[]
     */
    public function getDartsPlayers()
    {
        return $this->dartsPlayers;
    }

    /**
     * @param ArrayCollection|DartsPlayer[] $dartsPlayers
     */
    public function addDartsPlayers($dartsPlayers)
    {
        $this->dartsPlayers[] = $dartsPlayers;
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set dartsTeamValue
     *
     * @param float $dartsTeamValue
     *
     * @return User
     */
    public function setDartsTeamValue($dartsTeamValue)
    {
        $this->dartsTeamValue = $dartsTeamValue;

        return $this;
    }

    /**
     * Get dartsTeamValue
     *
     * @return float
     */
    public function getDartsTeamValue()
    {
        return $this->dartsTeamValue;
    }

    /**
     * Set dartsTournamentTeamValue
     *
     * @param float $dartsTournamentTeamValue
     *
     * @return User
     */
    public function setDartsTournamentTeamValue($dartsTournamentTeamValue)
    {
        $this->dartsTournamentTeamValue = $dartsTournamentTeamValue;

        return $this;
    }

    /**
     * Get dartsTournamentTeamValue
     *
     * @return float
     */
    public function getDartsTournamentTeamValue()
    {
        return $this->dartsTournamentTeamValue;
    }

    /**
     * Set dartsTotalPoints
     *
     * @param float $dartsTotalPoints
     *
     * @return User
     */
    public function setDartsTotalPoints($dartsTotalPoints)
    {
        $this->dartsTotalPoints = $dartsTotalPoints;

        return $this;
    }

    /**
     * Get dartsTotalPoints
     *
     * @return float
     */
    public function getDartsTotalPoints()
    {
        return $this->dartsTotalPoints;
    }

    /**
     * Set dartsTournamentPoints
     *
     * @param float $dartsTournamentPoints
     *
     * @return User
     */
    public function setDartsTournamentPoints($dartsTournamentPoints)
    {
        $this->dartsTournamentPoints = $dartsTournamentPoints;

        return $this;
    }

    /**
     * Get dartsTournamentPoints
     *
     * @return float
     */
    public function getDartsTournamentPoints()
    {
        return $this->dartsTournamentPoints;
    }

    /**
     * Set snookerTeamValue
     *
     * @param float $snookerTeamValue
     *
     * @return User
     */
    public function setSnookerTeamValue($snookerTeamValue)
    {
        $this->snookerTeamValue = $snookerTeamValue;

        return $this;
    }

    /**
     * Get snookerTeamValue
     *
     * @return float
     */
    public function getSnookerTeamValue()
    {
        return $this->snookerTeamValue;
    }

    /**
     * Set snookerTournamentTeamValue
     *
     * @param float $snookerTournamentTeamValue
     *
     * @return User
     */
    public function setSnookerTournamentTeamValue($snookerTournamentTeamValue)
    {
        $this->snookerTournamentTeamValue = $snookerTournamentTeamValue;

        return $this;
    }

    /**
     * Get snookerTournamentTeamValue
     *
     * @return float
     */
    public function getSnookerTournamentTeamValue()
    {
        return $this->snookerTournamentTeamValue;
    }

    /**
     * Set snookerTotalPoints
     *
     * @param float $snookerTotalPoints
     *
     * @return User
     */
    public function setSnookerTotalPoints($snookerTotalPoints)
    {
        $this->snookerTotalPoints = $snookerTotalPoints;

        return $this;
    }

    /**
     * Get snookerTotalPoints
     *
     * @return float
     */
    public function getSnookerTotalPoints()
    {
        return $this->snookerTotalPoints;
    }

    /**
     * Set snookerTournamentPoints
     *
     * @param float $snookerTournamentPoints
     *
     * @return User
     */
    public function setSnookerTournamentPoints($snookerTournamentPoints)
    {
        $this->snookerTournamentPoints = $snookerTournamentPoints;

        return $this;
    }

    /**
     * Get snookerTournamentPoints
     *
     * @return float
     */
    public function getSnookerTournamentPoints()
    {
        return $this->snookerTournamentPoints;
    }

    /**
     * Set fantasyTokens
     *
     * @param float $fantasyTokens
     *
     * @return User
     */
    public function setFantasyTokens($fantasyTokens)
    {
        $this->fantasyTokens = $fantasyTokens;

        return $this;
    }

    /**
     * Get fantasyTokens
     *
     * @return float
     */
    public function getFantasyTokens()
    {
        return $this->fantasyTokens;
    }

    /**
     * Set isAdmin
     *
     * @param boolean $isAdmin
     *
     * @return User
     */
    public function setIsAdmin($isAdmin)
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    /**
     * Get isAdmin
     *
     * @return bool
     */
    public function getIsAdmin()
    {
        return $this->isAdmin;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}

