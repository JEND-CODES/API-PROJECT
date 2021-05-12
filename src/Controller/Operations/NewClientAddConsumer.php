<?php

namespace App\Controller\Operations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Client;
use App\Entity\Consumer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\MailSender;

class NewClientAddConsumer extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var MailSender
     */
    private $mailSender;

    public function __construct(
        EntityManagerInterface $manager, 
        UserPasswordEncoderInterface $encoder, 
        MailSender $mailSender
        )
    {
        $this->manager = $manager;
        $this->encoder = $encoder;
        $this->mailSender = $mailSender;
    }

   public function __invoke(Client $data): Client
   {
        $consumer = new Consumer();

        $consumer->setUsername('consumer'.$data->getName())
            ->setEmail('consumer'.$data->getName().'@test.com')
            // ici mettre plutôt l'adresse email du client ??
            ->setAddress($data->getAddress())
            ->setCity($data->getCity())
            ->setPhoneNbr($data->getPhoneNbr())
            ->setPassword($this->encoder->encodePassword($consumer, 'testtest'))
            ->setRole('ROLE_ADMIN')
            ->setClient($data)
            ;

        $this->manager->persist($consumer);

        $data->addConsumer($consumer);

        // ENVOI D'UN EMAIL À L'UTILISATEUR
        $message = "Le compte client {$data->getName()} vient d'être ajouté au répertoire Bilemo. Vous pouvez vous connecter avec le pseudo suivant : consumer{$data->getName()} ; et le mot de passe par défaut : testtest . Nous vous remercions pour votre confiance !";

        $this->mailSender->sendMail($this->mailSender::NEW_API_CLIENT, 'consumer'.$data->getName().'@test.com', $message);
      
        return $data;

   }


}
