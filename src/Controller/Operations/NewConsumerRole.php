<?php

namespace App\Controller\Operations;

use App\Entity\Consumer;
use Symfony\Component\Security\Core\Security;

class NewConsumerRole
{
   /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

   public function __invoke(Consumer $data): Consumer
   {
      $data->setRole('ROLE_USER');

      $data->setClient($this->security->getUser()->getClient());

      return $data;

   }

}
