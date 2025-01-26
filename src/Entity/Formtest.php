<?php

namespace App\Entity;

use App\Repository\FormtestRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormtestRepository::class)]
class Formtest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Assert\NotBlank(message: 'Your name must be at least 2 characters long')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Your name must be at least {{ limit }} characters long',
        maxMessage: 'Your name cannot be longer than {{ limit }} characters',
    )]
    private ?string $name = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'The kilometers must be between 1 and 1000')]
    #[Assert\Type(
        type: 'integer',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(1000)]
    private ?int $kilometers = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'The price must be valid between 0.01 and 999.9')]
    #[Assert\Type(
        type: 'float',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    #[Assert\GreaterThanOrEqual(0.01)]
    #[Assert\LessThanOrEqual(999.99)]
    private ?float $price = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Assert\NotBlank(message: 'The datetime must be valid')]
    #[Assert\GreaterThanOrEqual('today')]
    private ?\DateTimeInterface $creation = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Your email must be at least 2 characters long')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Your email must be at least {{ limit }} characters long',
        maxMessage: 'Your email cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    #[Assert\Count(
        min: 1,
        max: 2,
        minMessage: 'You must specify at least one category',
        maxMessage: 'You cannot specify more than {{ limit }} categories',
    )]
    private ?array $categories = null;

    #[ORM\Column(length: 20, nullable: true)]
    #[Assert\NotBlank(message: 'The phone number must be valid')]
    #[Assert\Regex(
        pattern: '/^(\+?\d{0,2})?[\D]?\(?(\d{3})\)?[\D]?(\d{3})[\D]?(\d{4})$/',
        match: true,
        message: 'Your phone number is not valid',
    )]
    private ?string $phonenumber = null;

    #[ORM\Column(nullable: true)]
    private ?bool $good = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $season = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $pdf = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getKilometers(): ?int
    {
        return $this->kilometers;
    }

    public function setKilometers(int $kilometers): static
    {
        $this->kilometers = $kilometers;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getCreation(): ?\DateTimeInterface
    {
        return $this->creation;
    }

    public function setCreation(?\DateTimeInterface $creation): static
    {
        $this->creation = $creation;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCategories(): ?array
    {
        return $this->categories;
    }

    public function setCategories(?array $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    public function setPhonenumber(?string $phonenumber): static
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public function isGood(): ?bool
    {
        return $this->good;
    }

    public function setGood(?bool $good): static
    {
        $this->good = $good;

        return $this;
    }

    public function getSeason(): ?string
    {
        return $this->season;
    }

    public function setSeason(?string $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getPdf(): ?string
    {
        return $this->pdf;
    }

    public function setPdf(string $pdf): static
    {
        $this->pdf = $pdf;

        return $this;
    }
}
