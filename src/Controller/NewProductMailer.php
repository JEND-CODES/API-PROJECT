<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;
use App\Entity\Product;

class NewProductMailer
{
    
    /**
     * @var Security
     */
    private $security;

    private $mailer;

    public function __construct(Security $security, \Swift_Mailer $mailer)
    {
        $this->security = $security;
        $this->mailer = $mailer;
    }

    public function __invoke(Product $data): Product
    {
        
        $current_consumer = $this->security->getUser()->getUsername();

        $message = (new \Swift_Message("NOUVEAU TÉLÉPHONE AJOUTÉ AU RÉPERTOIRE BILEMO"))
                ->setFrom('noreply@bilemo.com')
                ->setTo('manager.bilemo@test.com')
                ->setBody("Le smarthpone {$data->getPhone()} de {$data->getTrademark()} est désormais disponible sur l'Api Bilemo. Il vient d'être ajouté par l'utilisateur suivant : {$current_consumer} .");

        $this->mailer->send($message);

        return $data;
    
   }


}
