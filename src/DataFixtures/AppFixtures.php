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

// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Pour générer les Fixtures entrer : "php bin/console doctrine:fixtures:load"

class AppFixtures extends Fixture
{
    
    public function __construct(ClientRepository $clientRepository, ProductRepository $productRepository, ConsumerRepository $consumerRepository /*, UserPasswordEncoderInterface $encoder */)
	{
		$this->clientRepository = $clientRepository;
		$this->productRepository = $productRepository;
		$this->consumerRepository = $consumerRepository;

		// $this->encoder = $encoder;
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

        // Téléphones
        $product = new Product();
        $product->setPhone('Galaxy')
                ->setTrademark('Samsung')
                ->setSummary($faker->paragraph(3))
                ->setPrice(799.99)
                ->setColor('White')
                // ->setCreatedAt(new \DateTime)
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        $product = new Product();
        $product->setPhone('iPhone')
                ->setTrademark('Apple')
                ->setSummary($faker->paragraph(3))
                ->setPrice(751.55)
                ->setColor('Black')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        $product = new Product();
        $product->setPhone('Xperia')
                ->setTrademark('Sony')
                ->setSummary($faker->paragraph(3))
                ->setPrice(369.00)
                ->setColor('Gold')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $manager->persist($product);

        // Clients
        $client = new Client();
        $client->setName('Free')
                ->setAddress('15 rue Lorem Ipsum')
                ->setCity('Paris')
                ->setPhoneNbr('01554433XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('Free', $client);
        $manager->persist($client);

        $client = new Client();
        $client->setName('Bouygues')
                ->setAddress('143 boulevard de Lorem')
                ->setCity('Bordeaux')
                ->setPhoneNbr('05554433XX')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ;
        $this->addReference('Bouygues', $client);
        $manager->persist($client);

        // Utilisateurs = Consumers

        // Utilisateur Admin FREE
        $consumer = new Consumer();
        $client = $this->getReference('Free');
        $consumer->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setAddress('10 rue Liberté')
            ->setCity('Paris')
            ->setPhoneNbr('06205687XX')
            ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
            ->setCreatedAt($faker->dateTimeBetween('-1 months'))
            ->setRole('ROLE_ADMIN')
            ->setClient($client)
            ;
        $manager->persist($consumer);

        // Utilisateur Admin BOUYGUES
        $consumer = new Consumer();
        $client = $this->getReference('Bouygues');
        $consumer->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setAddress('10 rue Liberté')
            ->setCity('Paris')
            ->setPhoneNbr('06468679XX')
            ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
            ->setCreatedAt($faker->dateTimeBetween('-1 months'))
            ->setRole('ROLE_ADMIN')
            ->setClient($client)
            ;
        $manager->persist($consumer);
        
        // 10 utilisateurs de Free Mobile
        for($i=1; $i<=8; $i++)
        {
            $consumer = new Consumer();
            $client = $this->getReference('Free');
            $consumer->setUsername('consumer'.$i.$client->getName())
                ->setEmail('consumer'.$i.$client->getName().'@test.com')
                ->setAddress('10 rue Liberté')
                ->setCity('Paris')
                ->setPhoneNbr('06554433XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                // Equivalent de "testtest" en algorithme bcrypt
                // ->setPassword($this->passwordEncoder->encodePassword($consumer, 'testtest'))
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_USER')
                ->setClient($client)
                ;
            $manager->persist($consumer);
        }
        
        // 10 utilisateurs de Bouygues Telecom
        for($i=1; $i<=8; $i++)
        {
            $consumer = new Consumer();
            $client = $this->getReference('Bouygues');
            $consumer->setUsername('consumer'.$i.$client->getName())
                ->setEmail('consumer'.$i.$client->getName().'@test.com')
                ->setAddress('10 rue Liberté')
                ->setCity('Paris')
                ->setPhoneNbr('06182443XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_USER')
                ->setClient($client)
            ;
            $manager->persist($consumer);
        }

        

        $manager->flush();

    }

}
