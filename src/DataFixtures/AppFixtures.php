<?php

namespace App\DataFixtures;

use App\Entity\Consumer;
use App\Entity\Client;
use App\Entity\Product;
use App\Repository\ConsumerRepository;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
   
    public function __construct(
        ClientRepository $clientRepository, 
        ProductRepository $productRepository, 
        ConsumerRepository $consumerRepository, 
        UserPasswordEncoderInterface $encoder
        )
    {
        $this->clientRepository = $clientRepository;
        $this->productRepository = $productRepository;
        $this->consumerRepository = $consumerRepository;
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('FR-fr');

        $this->clientRepository->fixtureIndex();
        $this->productRepository->fixtureIndex();
        $this->consumerRepository->fixtureIndex();

        // TÉLÉPHONES PROPOSÉS PAR BILEMO
        $phones = ['Galaxy', 'iPhone', 'Xperia', 'MX154', 'P40pro', 'FindX3', 'BZ789', '3080G'];
        $brands = ['Samsung', 'Apple', 'Sony', 'Xiaomi', 'Huawei', 'Oppo', 'Nokia', 'Alcatel'];
        $colors = ['Silver', 'White', 'Black', 'Gold', 'Orange', 'Grey', 'Black', 'White'];

        foreach ($phones as $key => $value)
        {
           $product = new Product();
           $product->setPhone($value)
                ->setTrademark($brands[$key])
                ->setSummary('Caractéristiques : '.$faker->paragraph(3))
                ->setPrice($faker->numberBetween(400, 900))
                ->setColor($colors[$key])
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
                
           $manager->persist($product);

        }

        // COMPTE MANAGER BILEMO
        $client = new Client();
        $client->setName('Bilemo')
                ->setAddress('154 rue de Belleville')
                ->setCity('Paris')
                ->setPhoneNbr('01345912XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('bilemo-ref', $client);
        $manager->persist($client);
        
        // CLIENTS DE BILEMO
        // CLIENT FREE
        $client = new Client();
        $client->setName('Free')
                ->setAddress('15 rue de la Liberté')
                ->setCity('Paris')
                ->setPhoneNbr('01554433XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('free-ref', $client);
        $manager->persist($client);

        // CLIENT ORANGE
        $client = new Client();
        $client->setName('Orange')
                ->setAddress('43 boulevard des Capucines')
                ->setCity('Paris')
                ->setPhoneNbr('01731238XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('orange-ref', $client);
        $manager->persist($client);

        // CLIENT BOUYGHES
        $client = new Client();
        $client->setName('Bouygues')
                ->setAddress('132 avenue de Verdun')
                ->setCity('Bordeaux')
                ->setPhoneNbr('05554433XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('bouygues-ref', $client);
        $manager->persist($client);

        // UTILISATEURS = CONSUMERS
        // COMPTE UTILISATEUR MANAGER BILEMO
        $consumer = new Consumer();
        $client = $this->getReference('bilemo-ref');
        $consumer->setUsername('manager')
                ->setEmail('manager.bilemo@test.com')
                ->setAddress($faker->secondaryAddress())
                ->setCity('Paris')
                ->setPhoneNbr('06491076XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_SUPER_ADMIN')
                ->setClient($client)
                ;
        $manager->persist($consumer);
 
        // UTILISATEUR ADMIN FREE
        $consumer = new Consumer();
        $client = $this->getReference('free-ref');
        $consumer->setUsername('adminFree')
                ->setEmail('admin.free@test.com')
                ->setAddress($faker->secondaryAddress())
                ->setCity('Paris')
                ->setPhoneNbr('06205687XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_ADMIN')
                ->setClient($client)
                ;
        $manager->persist($consumer);

        // UTILISATEUR ADMIN ORANGE
        $consumer = new Consumer();
        $client = $this->getReference('orange-ref');
        $consumer->setUsername('adminOrange')
                ->setEmail('admin.orange@test.com')
                ->setAddress($faker->secondaryAddress())
                ->setCity('Marseille')
                ->setPhoneNbr('06205687XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_ADMIN')
                ->setClient($client)
                ;
        $manager->persist($consumer);

        // UTILISATEUR ADMIN BOUYGUES
        $consumer = new Consumer();
        $client = $this->getReference('bouygues-ref');
        $consumer->setUsername('adminBouygues')
                ->setEmail('admin.bouygues@test.com')
                ->setAddress($faker->secondaryAddress())
                ->setCity('Bordeaux')
                ->setPhoneNbr('06468679XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_ADMIN')
                ->setClient($client)
                ;
        $manager->persist($consumer);
        
        // 3 UTILISATEURS DE FREE MOBILE
        for($i=1; $i<=3; $i++)
        {
            $consumer = new Consumer();
            $client = $this->getReference('free-ref');
            $consumer->setUsername('consumer'.$i.$client->getName())
                    ->setEmail('consumer'.$i.$client->getName().'@test.com')
                    ->setAddress($faker->secondaryAddress())
                    ->setCity('Paris')
                    ->setPhoneNbr('06554433XX')
                    ->setPassword($this->encoder->encodePassword($consumer, 'testtest'))
                    ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                    ->setRole('ROLE_USER')
                    ->setClient($client)
                    ;
            $manager->persist($consumer);
        }

        // 3 UTILISATEURS ORANGE
        for($i=1; $i<=3; $i++)
        {
            $consumer = new Consumer();
            $client = $this->getReference('orange-ref');
            $consumer->setUsername('consumer'.$i.$client->getName())
                    ->setEmail('consumer'.$i.$client->getName().'@test.com')
                    ->setAddress($faker->secondaryAddress())
                    ->setCity('Marseille')
                    ->setPhoneNbr('06182443XX')
                    ->setPassword($this->encoder->encodePassword($consumer, 'testtest'))
                    ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                    ->setRole('ROLE_USER')
                    ->setClient($client)
                    ;
            $manager->persist($consumer);
        }
        
        // 3 UTILISATEURS DE BOUYGUES TELECOM
        for($i=1; $i<=3; $i++)
        {
            $consumer = new Consumer();
            $client = $this->getReference('bouygues-ref');
            $consumer->setUsername('consumer'.$i.$client->getName())
                    ->setEmail('consumer'.$i.$client->getName().'@test.com')
                    ->setAddress($faker->secondaryAddress())
                    ->setCity('Bordeaux')
                    ->setPhoneNbr('06182443XX')
                    ->setPassword($this->encoder->encodePassword($consumer, 'testtest'))
                    ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                    ->setRole('ROLE_USER')
                    ->setClient($client)
                    ;
            $manager->persist($consumer);
        }

        $manager->flush();

    }

}
