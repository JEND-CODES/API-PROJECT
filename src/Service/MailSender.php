<?php

namespace App\Service;

class MailSender
{
    const NEW_API_USER = 'NOUVEAU COMPTE UTILISATEUR';

    const NEW_API_CLIENT = 'NOUVEAU COMPTE CLIENT';

    const NEW_API_PRODUCT = 'NOUVEAU TÉLÉPHONE DISPONIBLE';

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param string $mailSubject
     * @param string $userEmail
     * @param string $mailBody
     */
    public function sendMail(string $mailSubject, string $userEmail, string $mailBody): void
    {

        $message = (new \Swift_Message($mailSubject))
            ->setFrom('noreply@bilemo.com')
            ->setTo($userEmail)
            ->setBody($mailBody)
            ;

        $this->mailer->send($message);

    }

}
