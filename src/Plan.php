<?php

class Plan
{
    private int $id;
    private string $name;
    private string $quality;
    private int $screens;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getQuality(): string
    {
        return $this->quality;
    }

    /**
     * @param string $quality
     */
    public function setQuality(string $quality): void
    {
        $this->quality = $quality;
    }

    /**
     * @return int
     */
    public function getScreens(): int
    {
        return $this->screens;
    }

    /**
     * @param int $screens
     */
    public function setScreens(int $screens): void
    {
        $this->screens = $screens;
    }
}