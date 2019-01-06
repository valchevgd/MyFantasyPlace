<?php

namespace MyFantasyPlaceBundle\DTO;


class PlayerToViewDTO
{
    private $id;

    private $name;

    private $value;

    private $seasonFantasyPoints;

    private $level;

    private $nextLevelValue;

    private $progress;

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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getSeasonFantasyPoints()
    {
        return $this->seasonFantasyPoints;
    }

    /**
     * @param mixed $seasonFantasyPoints
     */
    public function setSeasonFantasyPoints($seasonFantasyPoints): void
    {
        $this->seasonFantasyPoints = $seasonFantasyPoints;
    }

    /**
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param mixed $level
     */
    public function setLevel($level): void
    {
        $this->level = $level;
    }

    /**
     * @return mixed
     */
    public function getNextLevelValue()
    {
        return $this->nextLevelValue;
    }

    /**
     * @param mixed $nextLevelValue
     */
    public function setNextLevelValue($nextLevelValue): void
    {
        $this->nextLevelValue = $nextLevelValue;
    }

    /**
     * @return mixed
     */
    public function getProgress()
    {
        return $this->progress;
    }

    /**
     * @param mixed $progress
     */
    public function setProgress($progress): void
    {
        $this->progress = $progress;
    }


}