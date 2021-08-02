<?php

namespace App\Service;

use App\Entity\ShortUrl;
use App\Model\ShortUrlRequest;
use App\Repository\ShortUrlRepository;

class UrlShortenerService
{

    private ShortUrlRepository $shortUrlRepository;

    public function __construct(
        ShortUrlRepository $shortUrlRepository
    )
    {
        $this->shortUrlRepository = $shortUrlRepository;
    }

    public function create(ShortUrlRequest $shortUrlRequest): ShortUrl
    {
        $shortUrl = new ShortUrl();
        $shortUrl
            ->setLongUrl($shortUrlRequest->getUrl());

        $this->shortUrlRepository->create($shortUrl);

        return $shortUrl;
    }

    public function getOneByShortUrl(string $shortUrl): ShortUrl
    {
        return $this->shortUrlRepository->findOneBy(['shortUrl' => $shortUrl]);
    }

    public function list(int $firstResult = 0, $maxResult = 10)
    {
        $shortUrls = $this->shortUrlRepository->listPaginated($firstResult, $maxResult);
    }

    public function addLike(ShortUrl $shortUrl): void
    {
        $shortUrl->addLike();
        $this->shortUrlRepository->update($shortUrl);
    }
}