<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Client;
use App\Entity\Product;

use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\ProductRepository;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

// Pour générer les Fixtures entrer : "php bin/console doctrine:fixtures:load"

class AppFixtures extends Fixture
{
    
    public function __construct(ClientRepository $clientRepository, ProductRepository $productRepository, UserRepository $userRepository /*, UserPasswordEncoderInterface $encoder */)
	{
		$this->clientRepository = $clientRepository;
		$this->productRepository = $productRepository;
		$this->userRepository = $userRepository;

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
		$this->userRepository->fixtureIndex();

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

        // Utilisateurs

        // Utilisateur Admin FREE
        $user = new User();
        $client = $this->getReference('Free');
        $user->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setAddress('10 rue Liberté')
            ->setCity('Paris')
            ->setPhoneNbr('06205687XX')
            ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
            ->setCreatedAt($faker->dateTimeBetween('-1 months'))
            ->setRole('ROLE_ADMIN')
            ->setClient($client)
            ;
        $manager->persist($user);

        // Utilisateur Admin BOUYGUES
        $user = new User();
        $client = $this->getReference('Bouygues');
        $user->setUsername('admin'.$client->getName())
            ->setEmail('admin'.$client->getName().'@test.com')
            ->setAddress('10 rue Liberté')
            ->setCity('Paris')
            ->setPhoneNbr('06468679XX')
            ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
            ->setCreatedAt($faker->dateTimeBetween('-1 months'))
            ->setRole('ROLE_ADMIN')
            ->setClient($client)
            ;
        $manager->persist($user);
        
        // 10 utilisateurs de Free Mobile
        for($i=1; $i<=8; $i++)
        {
            $user = new User();
            $client = $this->getReference('Free');
            $user->setUsername('user'.$i.$client->getName())
                ->setEmail('user'.$i.$client->getName().'@test.com')
                ->setAddress('10 rue Liberté')
                ->setCity('Paris')
                ->setPhoneNbr('06554433XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_USER')
                ->setClient($client)
                ;
            $manager->persist($user);
        }
        
        // 10 utilisateurs de Bouygues Telecom
        for($i=1; $i<=8; $i++)
        {
            $user = new User();
            $client = $this->getReference('Bouygues');
            $user->setUsername('user'.$i.$client->getName())
                ->setEmail('user'.$i.$client->getName().'@test.com')
                ->setAddress('10 rue Liberté')
                ->setCity('Paris')
                ->setPhoneNbr('06182443XX')
                ->setPassword('$2y$13$MdeK0Bpcugk25rsRO2HhiuVqCNt2YCKmimre18mQ0IHnjQtVbN6l.')
                ->setCreatedAt($faker->dateTimeBetween('-1 months'))
                ->setRole('ROLE_USER')
                ->setClient($client)
            ;
            $manager->persist($user);
        }

        

        $manager->flush();

    }

}
