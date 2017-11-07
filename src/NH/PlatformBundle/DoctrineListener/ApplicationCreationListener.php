<?php
// src/NH/PlatformBundle/DoctrineListener/ApplicationCreationListener.php

namespace NH\PlatformBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use NH\PlatformBundle\Email\ApplicationMailer;
use NH\PlatformBundle\Entity\Application;

class ApplicationCreationListener
{
    /**
     * @var ApplicationMailer
     */
    private $applicationMailer;

    public function __construct(ApplicationMailer $applicationMailer)
    {
        $this->applicationMailer = $applicationMailer;
    }
//LE SEUL argument donné à la méthode est Lifecycleeventargs qui offre 2 méthodes
    public function postPersist(LifecycleEventArgs $args)
    {
        //la méthode getObject retourne l'entité sur
        // laquelle l'événement est en train de se produire
        $entity = $args->getObject();
        // On ne veut envoyer un email que pour les entités Application qui sont créées
        //d'où le if pour vérifier le type d'entité
        if (!$entity instanceof Application) {
            return;
        }
        $this->applicationMailer->sendNewNotification($entity);
    }
}