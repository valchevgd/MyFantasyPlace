<?php

namespace MyFantasyPlaceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull()
     * @Assert\Length(
     *     min=4,
     *     max=20,
     *     exactMessage="Username should be between 4 and 20 symbols!"
     * )
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @Assert\NotNull()
     * @Assert\Email(
     *     message="Invalid email!"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\Length(
     *     min=3,
     *     max=20,
     *     exactMessage="Password should be between 3 and 20 symbols!"
     * )
     *
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
    private $dartsTeamValue = 28;


    /**
     * @var float
     *
     * @ORM\Column(name="darts_season_points", type="float")
     */
    private $dartsSeasonPoints = 0;

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
    private $snookerTeamValue = 28;


    /**
     * @var float
     *
     * @ORM\Column(name="snooker_season_points", type="float")
     */
    private $snookerSeasonPoints = 0;

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
     * @var ArrayCollection|DartsPlayer[]
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserDartsPlayer", mappedBy="userId", cascade={"remove"})
     */
    private $dartsPlayers;

    /**
     * @var bool
     *
     * @ORM\Column(name="darts_transfer", type="boolean")
     */
    private $dartsTransfer = true;

    /**
     * @var ArrayCollection|SnookerPlayer[]
     *
     * @ORM\OneToMany(targetEntity="MyFantasyPlaceBundle\Entity\UserSnookerPlayer", mappedBy="userId", cascade={"remove"})
     */
    private $snookerPlayers;

    /**
     * @var bool
     *
     * @ORM\Column(name="snooker_transfer", type="boolean")
     */
    private $snookerTransfer = true;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", nullable=true)
     */
    private $image = null;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="MyFantasyPlaceBundle\Entity\Role")
     * @JoinTable(name="users_roles",
     *     joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@JoinColumn(name="role_id", referencedColumnName="id")})
     */
    private $roles;

    public function __construct()
    {
        $this->dartsPlayers = new ArrayCollection();
        $this->snookerPlayers = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
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
     * Set dartsSeasonPoints
     *
     * @param float $dartsSeasonPoints
     *
     * @return User
     */
    public function setDartsSeasonPoints($dartsSeasonPoints)
    {
        $this->dartsSeasonPoints = $dartsSeasonPoints;

        return $this;
    }

    /**
     * Get dartsSeasonPoints
     *
     * @return float
     */
    public function getDartsSeasonPoints()
    {
        return $this->dartsSeasonPoints;
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
     * Set snookerSeasonPoints
     *
     * @param float $snookerSeasonPoints
     *
     * @return User
     */
    public function setSnookerSeasonPoints($snookerSeasonPoints)
    {
        $this->snookerSeasonPoints = $snookerSeasonPoints;

        return $this;
    }

    /**
     * Get snookerSeasonPoints
     *
     * @return float
     */
    public function getSnookerSeasonPoints()
    {
        return $this->snookerSeasonPoints;
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
     * @return bool
     */
    public function getDartsTransfer()
    {
        return $this->dartsTransfer;
    }

    /**
     * @param bool $dartsTransfer
     */
    public function setDartsTransfer(bool $dartsTransfer)
    {
        $this->dartsTransfer = $dartsTransfer;
    }

    /**
     * @return bool
     */
    public function getSnookerTransfer()
    {
        return $this->snookerTransfer;
    }

    /**
     * @param bool $snookerTransfer
     */
    public function setSnookerTransfer(bool $snookerTransfer)
    {
        $this->snookerTransfer = $snookerTransfer;
    }


    /**
     * @param \MyFantasyPlaceBundle\Entity\Role $role
     * @return User
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;

        return $this;
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
        $stringRoles = [];
        foreach ($this->roles as $role){
            /** @var $role Role */
            $stringRoles[] = $role->getRole();
        }
        return $stringRoles;
    }

    public function isAdmin()
    {
        return in_array("ROLE_ADMIN", $this->getRoles());
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

