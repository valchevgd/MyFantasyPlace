<?php

namespace MyFantasyPlaceBundle\DTO;


class SnookerPlayerToUpdateDTO
{
    private $id;

    /** @var float */
    private $value;

    private $status = null;

    /** @var integer */
    private $pointsScored = 0;

    /** @var integer */
    private $overFifty = 0;

    /** @var integer */
    private $overSixty = 0;

    /** @var integer */
    private $overSeventy = 0;

    /** @var integer */
    private $overEighty = 0;

    /** @var integer */
    private $overNinety = 0;

    /** @var string */
    private $overHundred = 0;


    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }


    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getPointsScored(): int
    {
        return $this->pointsScored;
    }

    /**
     * @param int $pointsScored
     */
    public function setPointsScored(int $pointsScored): void
    {
        $this->pointsScored = $pointsScored;
    }

    /**
     * @return int
     */
    public function getOverFifty(): int
    {
        return $this->overFifty;
    }

    /**
     * @param int $overFifty
     */
    public function setOverFifty(int $overFifty): void
    {
        $this->overFifty = $overFifty;
    }

    /**
     * @return int
     */
    public function getOverSixty(): int
    {
        return $this->overSixty;
    }

    /**
     * @param int $overSixty
     */
    public function setOverSixty(int $overSixty): void
    {
        $this->overSixty = $overSixty;
    }

    /**
     * @return int
     */
    public function getOverSeventy(): int
    {
        return $this->overSeventy;
    }

    /**
     * @param int $overSeventy
     */
    public function setOverSeventy(int $overSeventy): void
    {
        $this->overSeventy = $overSeventy;
    }

    /**
     * @return int
     */
    public function getOverEighty(): int
    {
        return $this->overEighty;
    }

    /**
     * @param int $overEighty
     */
    public function setOverEighty(int $overEighty): void
    {
        $this->overEighty = $overEighty;
    }

    /**
     * @return int
     */
    public function getOverNinety(): int
    {
        return $this->overNinety;
    }

    /**
     * @param int $overNinety
     */
    public function setOverNinety(int $overNinety): void
    {
        $this->overNinety = $overNinety;
    }

    /**
     * @return string
     */
    public function getOverHundred()
    {
        return $this->overHundred;
    }

    /**
     * @param string $overHundred
     */
    public function setOverHundred(string $overHundred): void
    {
        $this->overHundred = $overHundred;
    }


}