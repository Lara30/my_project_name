<?php
// src/NH/PlatformBundle/DataFixtures/ORM/LoadSkill.php

namespace NH\PlatformBundle\DataFixtureORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NH\PlatformBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        //liste des noms de compétences à ajouter
        $names = array('PHP', 'Symfony', 'C++', 'Java', 'Photoshop');

        foreach ($names as $name) {
            //on crée la compétence
            $skill = new Skill();
            $skill->setName($name);

            //on la persiste
            $manager->persist($skill);
        }
        //on déclenche l'enregistrement de toutes les catégories
        $manager->flush();
    }
}