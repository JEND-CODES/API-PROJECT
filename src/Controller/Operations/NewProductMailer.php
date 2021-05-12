<?php

namespace App\Controller\Operations;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use App\Entity\Product;
use App\Service\MailSender;

class NewProductMailer extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    /**
     * @var MailSender
     */
    private $mailSender;

    public function __construct(Security $security, MailSender $mailSender)
    {
        $this->security = $security;
        $this->mailSender = $mailSender;
    }

    public function __invoke(Product $data): Product
    {
        $mailList = $this->getDoctrine()->getRepository('App:Consumer')->getAllEmail();

        $current_consumer = $this->security->getUser()->getUsername();
        
        // ENVOIS DE MAILS À TOUS LES UTLISATEURS
        foreach ($mailList as $key => $value)
        {

            $message = "Le smarthpone {$data->getPhone()} de {$data->getTrademark()} est désormais disponible sur l'Api Bilemo. Il a été ajouté par l'utilisateur suivant : {$current_consumer} .";

            $this->mailSender->sendMail($this->mailSender::NEW_API_PRODUCT, $mailList[$key], $message);

        }

        return $data;
    
   }


}
