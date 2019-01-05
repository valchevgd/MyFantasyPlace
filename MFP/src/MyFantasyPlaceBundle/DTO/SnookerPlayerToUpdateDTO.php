<?php

namespace MyFantasyPlaceBundle\DTO;


class SnookerPlayerToUpdateDTO
{
    private $id;


    private $status = null;

    /** @var integer */
    private $pointsScored = 0;


    /** @var string */
    private $breaks = 0;

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
     * @return null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param null $status
     */
    public function setStatus($status): void
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
     * @return string
     */
    public function getBreaks(): string
    {
        return $this->breaks;
    }

    /**
     * @param string $breaks
     */
    public function setBreaks(string $breaks): void
    {
        $this->breaks = $breaks;
    }



}