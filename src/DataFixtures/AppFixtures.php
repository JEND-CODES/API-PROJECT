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
    /**
     * @var ClientRepository
     */
    private $clientRepo;

    /**
     * @var ProductRepository
     */
    private $productRepo;

    /**
     * @var ConsumerRepository
     */
    private $consumerRepo;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var string $managerMail
     */
    private $managerMail;
   
    public function __construct(
        ClientRepository $clientRepo, 
        ProductRepository $productRepo, 
        ConsumerRepository $consumerRepo, 
        UserPasswordEncoderInterface $encoder,
        string $managerMail
        )
    {
        $this->clientRepo = $clientRepo;
        $this->productRepo = $productRepo;
        $this->consumerRepo = $consumerRepo;
        $this->encoder = $encoder;
        $this->managerMail = $managerMail;
    }

    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('FR-fr');

        $this->clientRepo->fixtureIndex();
        $this->productRepo->fixtureIndex();
        $this->consumerRepo->fixtureIndex();

        // TÉLÉPHONES PROPOSÉS PAR BILEMO
        $phones = ['Galaxy', 'iPhone', 'Xperia', 'MX154', 'P40pro', 'FindX3', 'BZ789', '3080G'];

        $brands = ['Samsung', 'Apple', 'Sony', 'Xiaomi', 'Huawei', 'Oppo', 'Nokia', 'Alcatel'];

        $images = ['<DOMAIN_NAME>/images/smartphones/samsung.jpg','<DOMAIN_NAME>/images/smartphones/iphone.jpg','<DOMAIN_NAME>/images/smartphones/xperia.jpg','<DOMAIN_NAME>/images/smartphones/xiaomi.jpg','<DOMAIN_NAME>/images/smartphones/huawei.jpg','<DOMAIN_NAME>/images/smartphones/oppo.jpg','<DOMAIN_NAME>/images/smartphones/nokia.jpg','<DOMAIN_NAME>/images/smartphones/alcatel.jpg'];
        
        $colors = ['Silver', 'White', 'Black', 'Blue', 'Orange', 'Grey', 'Black', 'Black'];

        foreach ($phones as $key => $value)
        {
           $product = new Product();
           $product->setPhone($value)
                ->setTrademark($brands[$key])
                ->setSummary('Caractéristiques : '.$faker->paragraph(3))
                ->setImage($images[$key])
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
                ->setCity('Marseille')
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
                ->setCity('Lyon')
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
                ->setEmail($this->managerMail)
                ->setAddress($faker->secondaryAddress())
                ->setCity('Marseille')
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
                ->setCity('Lyon')
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
