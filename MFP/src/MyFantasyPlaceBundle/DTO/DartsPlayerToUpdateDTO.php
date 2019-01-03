<?php

namespace MyFantasyPlaceBundle\DTO;


class DartsPlayerToUpdateDTO
{
    private $id;

    private $status = null;

    private $overHundred = 0;

    private $overOneHundredAndForty = 0;

    private $maximums = 0;

    private $checkoutPercentage = 0;

    private $averageThreeDarts = 0;

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
    public function getOverHundred(): int
    {
        return $this->overHundred;
    }

    /**
     * @param int $overHundred
     */
    public function setOverHundred(int $overHundred): void
    {
        $this->overHundred = $overHundred;
    }

    /**
     * @return int
     */
    public function getOverOneHundredAndForty(): int
    {
        return $this->overOneHundredAndForty;
    }

    /**
     * @param int $overOneHundredAndForty
     */
    public function setOverOneHundredAndForty(int $overOneHundredAndForty): void
    {
        $this->overOneHundredAndForty = $overOneHundredAndForty;
    }

    /**
     * @return int
     */
    public function getMaximums(): int
    {
        return $this->maximums;
    }

    /**
     * @param int $maximums
     */
    public function setMaximums(int $maximums): void
    {
        $this->maximums = $maximums;
    }

    /**
     * @return int
     */
    public function getCheckoutPercentage(): int
    {
        return $this->checkoutPercentage;
    }

    /**
     * @param int $checkoutPercentage
     */
    public function setCheckoutPercentage(int $checkoutPercentage): void
    {
        $this->checkoutPercentage = $checkoutPercentage;
    }

    /**
     * @return int
     */
    public function getAverageThreeDarts(): int
    {
        return $this->averageThreeDarts;
    }

    /**
     * @param int $averageThreeDarts
     */
    public function setAverageThreeDarts(int $averageThreeDarts): void
    {
        $this->averageThreeDarts = $averageThreeDarts;
    }



}