<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\AddLikeToShorUrl;
use App\Repository\ShortUrlRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ShortUrlRepository::class)
 * @ORM\EntityListeners({"App\Doctrine\ShortUrlListener"})
 */
#[ApiResource(itemOperations: [
    'get',
    'put',
    'patch',
    'delete',
    'add_like' => [
        'method' => 'POST',
        'path' => '/short_urls/{id}/like',
        'controller' => AddLikeToShorUrl::class,
        'denormalization_context' => ['groups' => 'like'],
    ]
], attributes: [
    'normalization_context' => ['groups' => ['read']],
    'denormalization_context' => ['groups' => ['write']],
])]
class ShortUrl
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read", "write"})
     */
    private ?string $longUrl;

    /**
     * @ORM\Column(type="string", length=9)
     * @Groups({"read"})
     */
    private ?string $shortUrl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     */
    private ?int $hits = 0;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"read"})
     */
    private ?int $likes = 0;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"read"})
     */
    private ?\DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongUrl(): ?string
    {
        return $this->longUrl;
    }

    public function setLongUrl(string $longUrl): self
    {
        $this->longUrl = $longUrl;

        return $this;
    }

    public function getShortUrl(): ?string
    {
        return $this->shortUrl;
    }

    public function setShortUrl(string $shortUrl): self
    {
        $this->shortUrl = $shortUrl;

        return $this;
    }

    public function getHits(): ?int
    {
        return $this->hits;
    }

    public function setHits(?int $hits): self
    {
        $this->hits = $hits;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(?int $likes): self
    {
        $this->likes = $likes;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function addLike(): self
    {
        ++$this->likes;

        return $this;
    }
}
