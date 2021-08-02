<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Service\UrlShortenerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class AddLikeToShorUrl extends AbstractController
{
    private UrlShortenerService $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function __invoke(ShortUrl $data): ShortUrl
    {
        $this->urlShortenerService->addLike($data);

        return $data;
    }
}
