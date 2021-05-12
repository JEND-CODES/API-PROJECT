<?php

namespace App\Controller;

use Symfony\Component\Security\Core\Security;

class ConsumerAccount
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function __invoke()
    {
        $current_consumer = $this->security->getUser();
        return $current_consumer;
    }


}
