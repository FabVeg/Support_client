<?php
 
namespace App\DataFixtures;
 
use Faker;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Service;
use App\Entity\Customer;
use App\DataFixtures\ServiceFixtures;
use App\DataFixtures\CustomerFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
 
class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On desactive les logs pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
    
        // on récupére la liste des services
        $services = $manager->getRepository(Service::class)->findAll();
        // on récupére la liste des customers
        $customers = $manager->getRepository(Customer::class)->findAll();
         
        $roles = [
            ['ROLE_USER', 'ROLE_ADMIN'], // 0
            ['ROLE_USER', 'ROLE_CUSTOMER_ADMIN', 'ROLE_CUSTOMER'], // 1
            ['ROLE_USER', 'ROLE_CUSTOMER'], // 2
        ];
 
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 100; $i++) {
            $type = $faker->numberBetween(0,2);
            $user = new User();
            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword('12345678')
                ->setRoles($roles[$type])
                ->setCreatedAt(new \DateTime());
            
            // on doit l'associer à un service
            if($type == 0) {
                $user->setService($services[array_rand($services)]);                
            } 
            // on doit l'associer à un customer
            else {
                $user->setCustomer($customers[array_rand($customers)]);  
            }  
            $manager->persist($user); 
        }
        $manager->flush();
    }
 
    public function getDependencies()
    {
        return array(
            ServiceFixtures::class,
            CustomerFixtures::class,
        );
    }
}
