<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $subjectId;

    #[ORM\Column(type: 'integer')]
    private $userId;

    #[ORM\Column(type: 'array', nullable: true)]
    private $tags = [];

    #[ORM\Column(type: 'float')]
    private $rating;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 20)]
    private $reviewGroup;

    #[ORM\Column(type: 'text')]
    private $text;

    #[ORM\Column(type: 'datetime')]
    private $creationTime;

    #[ORM\Column(type: 'array')]
    private $likes = [];

    #[ORM\Column(type: 'array')]
    private $dislikes = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
    }

    public function setSubjectId(int $subjectId): self
    {
        $this->subjectId = $subjectId;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getReviewGroup(): ?string
    {
        return $this->reviewGroup;
    }

    public function setReviewGroup(string $reviewGroup): self
    {
        $this->reviewGroup = $reviewGroup;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }


    public function getCreationTime(): ?\DateTimeInterface
    {
        return $this->creationTime;
    }

    public function setCreationTime(\DateTimeInterface $creationTime): self
    {
        $this->creationTime = $creationTime;

        return $this;
    }

    public function __toString(): string
    {
        return '';
    }

    public function getLikes(): ?array
    {
        return $this->likes;
    }

    public function setLikes(array $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getDislikes(): ?array
    {
        return $this->dislikes;
    }

    public function setDislikes(array $dislikes): self
    {
        $this->dislikes = $dislikes;

        return $this;
    }

}
