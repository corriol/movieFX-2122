<?php
declare(strict_types=1);

namespace App;

use Webmozart\Assert\Assert;

class Movie
{
    const POSTER_PATH = "posters";
    public ?int $id = null;
    private string $title;
    private string $overview;
    private string $releaseDate;
    private float $rating;
    private int $voters;
    private string $poster;

    /**
     * @param ?int $id
     * @param string $title
     * @param string $overview
     * @param string $releaseDate
     * @param float $rating
     * @param string $poster
     */
    public function __construct(?int $id, string $title, string $overview, string $releaseDate, float $rating, string $poster)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setOverview($overview);
        $this->setReleaseDate($releaseDate);
        $this->setRating($rating);
        $this->setPoster($poster);
    }


    /**
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param ?int $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        Assert::lengthBetween($title, 1, 100);
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }

    /**
     * @param string $overview
     */
    public function setOverview(string $overview): void
    {
        Assert::lengthBetween($overview, 1, 500);
        $this->overview = $overview;
    }

    /**
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * @param string $releaseDate
     */
    public function setReleaseDate(string $releaseDate): void
    {
        if (!validate_date($releaseDate))
            throw new \WebMozart\Assert\InvalidArgumentException("date invalid");
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating(float $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @return string
     */
    public function getPoster(): string
    {
        return $this->poster;
    }

    /**
     * @param string $poster
     */
    public function setPoster(string $poster): void
    {
        Assert::notEmpty($poster);
        $this->poster = $poster;
    }

    /**
     * @return int
     */
    public function getVoters(): int
    {
        return $this->voters;
    }

    /**
     * @param int $voters
     */
    public function setVoters(int $voters): void
    {
        $this->voters = $voters;
    }

    public static function fromArray(array $data): Movie
    {
        if (empty($data["id"])) 
            $id = null;
        else
            $id = (int)$data["id"];
                
        return new Movie(
            $id,
            $data["title"],
            $data["overview"],
            $data["release_date"],
            (float)$data["rating"],
            $data["poster"]
        );
    }

    public function toArray(): array
    {
        return [
            "id" => $this->getId(),
            "title" => $this->getTitle(),
            "overview" => $this->getOverview(),
            "release_date" => $this->getReleaseDate(),
            "rating" => $this->getRating(),
            "poster" => $this->getPoster()
        ];
    }
}