<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Exception\HttpException;

class HoneyPotSubscriber implements EventSubscriberInterface
{
    public function __construct(private LoggerInterface $honeyPotLogger, private RequestStack $requestStack)
    {
    }

    public static function getSubscribedEvents(): array
    {
        // Récupérer les données du formulaire avec le FormEvents::PRE_SUBMIT
        return [
            FormEvents::PRE_SUBMIT => 'checkHoneyJar',
        ];
    }

    public function checkHoneyJar(FormEvent $event): void
    {
        // Récupérer la requête actuelle afin de pouvoir récupérer l'IP de l'utilisateur qui a rempli le formulaire
        $request = $this->requestStack->getCurrentRequest();
        if(!$request) {
            return;
        }

        // Récupérer les données du formulaire
        $data = $event->getData();

        // Vérifier si les champs 'phone' et 'faxNumber' sont présents dans les données du formulaire
        if(!array_key_exists('phone', $data) || !array_key_exists('faxNumber', $data)) {
            throw new HttpException(400, "Don't touch my form please!");
        }

        // Tableau contenant les valeurs des champs 'phone' et 'faxNumber'
        [
            'phone' => $phone,
            'faxNumber' => $faxNumber
        ] = $data;

        // Vérifier si les champs 'phone' et 'faxNumber' sont remplis ou non et afficher un message si c'est le cas
        if($phone !== "" || $faxNumber !== "") {
            $this->honeyPotLogger->info("Une tentative de robot spammeur a essayé de remplir le formulaire de contact sur l'adresse IP '{$request->getClientIp()}'. Les champs 'phone' et 'faxNumber' contiennent les valeurs '$phone' et '$faxNumber'.");
            throw new HttpException(403, "Go away dirty robot!");
        }
    }


}
