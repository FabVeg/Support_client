<?php
 
namespace App\DataFixtures;
 
use App\Entity\Service;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
 
class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On desactive les logs pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
 
        $services = [
             'Support Client', 'Comptabilité', 
             'Commercial', 'Développement', 
             'Administration réseau', 'Graphisme', 'Référencement'
       ];
        foreach($services as $service) {
            $oService = new Service();
            $oService
                    ->setName($service)
                    ->setCreatedAt(new \DateTime());
 
            $manager->persist($oService);
        }
        $manager->flush();
     }
}
