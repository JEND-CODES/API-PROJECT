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

// Pour générer les Fixtures entrer : "php bin/console doctrine:fixtures:load"

class AppFixtures extends Fixture
{
    
    public function __construct(ClientRepository $clientRepository, ProductRepository $productRepository, ConsumerRepository $consumerRepository, UserPasswordEncoderInterface $encoder)
	{
		$this->clientRepository = $clientRepository;
		$this->productRepository = $productRepository;
		$this->consumerRepository = $consumerRepository;
		$this->encoder = $encoder;
	}

    public function load(ObjectManager $manager)
    {

        // https://packagist.org/packages/fakerphp/faker
        // composer require fakerphp/faker
        // https://fakerphp.github.io/locales/fr_FR/
        $faker = \Faker\Factory::create('FR-fr');

        // Pour remettre l'Index de départ au lancement de chaque nouvelle fixture
        $this->clientRepository->fixtureIndex();
		$this->productRepository->fixtureIndex();
		$this->consumerRepository->fixtureIndex();

        // TÉLÉPHONES PROPOSÉS PAR BILEMO
        $product = new Product();
        $product->setPhone('Galaxy')
                ->setTrademark('Samsung')
                ->setSummary('Caractéristiques : '.$faker->paragraph(3))
                ->setPrice(799.99)
                ->setColor('White')
                // ->setCreatedAt(new \DateTime)
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        $product = new Product();
        $product->setPhone('iPhone')
                ->setTrademark('Apple')
                ->setSummary('Caractéristiques : '.$faker->paragraph(3))
                ->setPrice(751.55)
                ->setColor('Black')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        $product = new Product();
        $product->setPhone('Xperia')
                ->setTrademark('Sony')
                ->setSummary('Caractéristiques : '.$faker->paragraph(3))
                ->setPrice(369.00)
                // ->setColor('Gold')
                ->setColor($faker->colorName())
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        // COMPTE CLIENT BILEMO
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
        // COMPTE UTILISATEUR ADMIN BILEMO
        $consumer = new Consumer();
        $client = $this->getReference('bilemo-ref');
        $consumer->setUsername('admin')
            ->setEmail('admin@test.com')
            ->setAddress($faker->secondaryAddress())
            ->setCity('Paris')
            ->setPhoneNbr('06491076XX')
            ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
            ->setCreatedAt($faker->dateTimeBetween('-1 months'))
            ->setRole('ROLE_ADMIN')
            ->setClient($client)
            ;
        $manager->persist($consumer);
 
        // UTILISATEUR ADMIN FREE
        $consumer = new Consumer();
        $client = $this->getReference('free-ref');
        $consumer->setUsername('freeadmin')
            ->setEmail('freeadmin@test.com')
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
        $consumer->setUsername('orangeadmin')
            ->setEmail('orangeadmin@test.com')
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
        $consumer->setUsername('bouyghesadmin')
            ->setEmail('bouyghesadmin@test.com')
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
                // Equivalent de "testtest" en algorithme bcrypt
                // ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
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
                // ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
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
                // ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
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
