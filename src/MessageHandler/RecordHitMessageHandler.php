<?php

namespace App\MessageHandler;

use App\Message\RecordHitMessage;
use App\Repository\ShortUrlRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RecordHitMessageHandler implements MessageHandlerInterface
{
    private ShortUrlRepository $shortUrlRepository;

    public function __construct(ShortUrlRepository $shortUrlRepository)
    {
        $this->shortUrlRepository = $shortUrlRepository;
    }

    public function __invoke(RecordHitMessage $message)
    {
        $shortUrl = $this->shortUrlRepository->find($message->getShortUrlId());
        $shortUrl->setHits($shortUrl->getHits() + 1);
        $this->shortUrlRepository->update($shortUrl);
    }
}
