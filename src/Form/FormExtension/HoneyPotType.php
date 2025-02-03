<?php

namespace App\Form\FormExtension;

use App\EventSubscriber\HoneyPotSubscriber;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;

// Classe pour ajouter les champs 'phone' et 'faxNumber' au formulaire
class HoneyPotType extends AbstractType
{

    // LoggerInterface pour la gestion des logs et RequestStack pour récupérer la requête HTTP actuelle
    public function __construct(private readonly LoggerInterface $honeyPotLogger, private readonly RequestStack $requestStack)
    {
    }

    // Constantes pour les champs 'phone' et 'faxNumber'
    protected const INCREDIBLE_HONEY_POT_FOR_BOT = 'phone';
    protected const FABULOUS_HONEY_POT_FOR_BOT = "faxNumber";

    // Fonction pour construire le formulaire et ajouter les champs 'phone' et 'faxNumber'
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(self::INCREDIBLE_HONEY_POT_FOR_BOT, TextType::class, $this->setHoneyPotFieldOptions())
            ->add(self::FABULOUS_HONEY_POT_FOR_BOT, TextType::class, $this->setHoneyPotFieldOptions())
            // Ajouter l'event subscriber pour surveiller les formulaires et verifier si les champs 'phone' et 'faxNumber' sont remplis
            ->addEventSubscriber(new HoneyPotSubscriber($this->honeyPotLogger, $this->requestStack));
    }

    // Fonction pour configurer les options des champs 'phone' et 'faxNumber'
    protected function setHoneyPotFieldOptions(): array
    {
        return [
            'attr' => [
                'autocomplete' => 'off',
                'tabindex' => '-1',
                'style' => 'opacity: 0; pointer-events: none; width: 0; height: 0; position: absolute; top: 0; left: 0;'
            ],
            'mapped' => false,
            'label' => false,
            'required' => false
        ];
    }

}
