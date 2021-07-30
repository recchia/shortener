<?php

namespace App\Service;

use App\Contract\UrlShortenerProviderInterface;
use App\Entity\ShortUrl;
use App\Model\ShortUrlRequest;
use App\Repository\ShortUrlRepository;

class UrlShortenerService
{

    private UrlShortenerProviderInterface $urlShortenerProvider;
    private ShortUrlRepository $shortUrlRepository;

    public function __construct(
        UrlShortenerProviderInterface $urlShortenerProvider,
        ShortUrlRepository $shortUrlRepository
    )
    {
        $this->urlShortenerProvider = $urlShortenerProvider;
        $this->shortUrlRepository = $shortUrlRepository;
    }

    public function create(ShortUrlRequest $shortUrlRequest): ShortUrl
    {
        $shortUrl = new ShortUrl();
        $shortUrl
            ->setLongUrl($shortUrlRequest->getUrl())
            ->setShortUrl($this->urlShortenerProvider->reduceUrl($shortUrlRequest->getUrl()));

        $this->shortUrlRepository->create($shortUrl);

        return $shortUrl;
    }
}