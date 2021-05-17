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

    /**
     * @var string $noreplyMail
     */
    private $noreplyMail;

    public function __construct(\Swift_Mailer $mailer, string $noreplyMail)
    {
        $this->mailer = $mailer;
        $this->noreplyMail = $noreplyMail;
    }

    public function sendMail(string $mailSubject, string $userEmail, string $mailBody): void
    {

        $message = (new \Swift_Message($mailSubject))
            ->setFrom($this->noreplyMail)
            ->setTo($userEmail)
            ->setBody($mailBody)
            ;

        $this->mailer->send($message);

    }

}
