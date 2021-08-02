<?php

namespace App\Controller;

use App\Entity\ShortUrl;
use App\Exception\UrlShortenerProviderException;
use App\Form\UrlShortenerType;
use App\Message\RecordHitMessage;
use App\Model\ShortUrlRequest;
use App\Service\UrlShortenerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        $form = $this->createForm(UrlShortenerType::class);

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/add', name: 'add_new', methods: ['POST'])]
    public function addNew(Request $request, UrlShortenerService $urlShortenerService): RedirectResponse
    {
        $form = $this->createForm(UrlShortenerType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $shortUrlRequest = new ShortUrlRequest($data['url']);

            try {
                $urlShortenerService->create($shortUrlRequest);
            } catch (\Throwable $exception) {
                $this->addFlash('danger', $exception->getMessage());

                return $this->redirectToRoute('home');
            }

            $this->addFlash('success', 'The new Url was added');

            return $this->redirectToRoute('home');
        }

        $this->addFlash('danger', 'Failed adding new URL');

        return $this->redirectToRoute('home');
    }

    #[Route('/view/{urlId}', name: 'show_url')]
    public function show(string $urlId, UrlShortenerService $urlShortenerService): Response
    {
        $shortUrl = $urlShortenerService->getOneByShortUrl($urlId);

        return $this->render('home/show_url.html.twig', [
            'shortUrl' => $shortUrl,
        ]);
    }

    #[Route('/{urlId}', name: 'redirection', requirements: ['urlId' => '^(?!api).*$'])]
    public function redirectToLongUrl(
        string $urlId,
        UrlShortenerService $urlShortenerService,
        MessageBusInterface $bus
    ): RedirectResponse
    {
        $shortUrl = $urlShortenerService->getOneByShortUrl($urlId);

        $bus->dispatch(new RecordHitMessage($shortUrl->getId()));

        return $this->redirect($shortUrl->getLongUrl());
    }
}
