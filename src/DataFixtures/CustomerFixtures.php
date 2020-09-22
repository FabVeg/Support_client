<?php
 
namespace App\DataFixtures;
 
use Faker;
use App\Entity\User;
use App\Entity\Customer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
 
class CustomerFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // On desactive les logs pour accélerer le processus
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);
 
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 30; $i++) {
            $customer = new Customer();
            $customer
                ->setName($faker->company)
                ->setSiret(str_replace(' ', '',$faker->siret))
                ->setAddress1($faker->address)
                ->setCity($faker->city)
                ->setZipCode($faker->postcode)
                ->setCreatedAt(new \DateTime());
            
            // on doit créer l'utilisateur admin pour cette société
            $user = new User();
            $user
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
                ->setEmail($faker->email)
                ->setPassword('12345678')
                ->setRoles(['ROLE_USER', 'ROLE_CUSTOMER_ADMIN', 'ROLE_CUSTOMER'])
                ->setCreatedAt(new \DateTime());
            
            $manager->persist($user);
 
            $customer->addUser($user);
            $manager->persist($customer); 
        }
        $manager->flush();
    }
}
