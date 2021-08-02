<?php

namespace App\Tests\Service;

use App\Contract\UrlShortenerProviderInterface;
use App\Entity\ShortUrl;
use App\Model\ShortUrlRequest;
use App\Repository\ShortUrlRepository;
use App\Service\UrlShortenerService;
use PHPUnit\Framework\TestCase;

class UrlShortenerServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itCanCreateAShortUrl(): void
    {
        $url = 'https://www.pierorecchia.com';
        $shortUrlRepository = $this->createMock(ShortUrlRepository::class);
        $urlShortenerService = new UrlShortenerService($shortUrlRepository);

        $shortUrl = $urlShortenerService->create(new ShortUrlRequest($url));

        $this->assertEquals($url, $shortUrl->getLongUrl());
    }
}
