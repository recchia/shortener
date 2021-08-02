<?php

namespace App\Doctrine;

use App\Contract\UrlShortenerProviderInterface;
use App\Entity\ShortUrl;
use App\Model\SystemClock;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Exception;

class ShortUrlListener
{
    private UrlShortenerProviderInterface $urlShortenerProvider;
    private SystemClock $clock;

    public function __construct(UrlShortenerProviderInterface $urlShortenerProvider, SystemClock $clock)
    {
        $this->urlShortenerProvider = $urlShortenerProvider;
        $this->clock = $clock;
    }

    /**
     * @throws Exception
     */
    public function prePersist(ShortUrl $shortUrl, LifecycleEventArgs $eventArgs): void
    {
        $short = $this->urlShortenerProvider->reduceUrl($shortUrl->getLongUrl());
        $shortUrl->setShortUrl($short)->setCreatedAt($this->clock->currentTime());
    }

}