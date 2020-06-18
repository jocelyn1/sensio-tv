<?php

namespace App\Controller;

use App\Security\Guard\FormLoginAuthenticator;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController
{
    /**
     * @Route("/login", name="app_security_login", methods={"POST"})
     */
    public function login(): void
    {
        throw new \LogicException(sprintf('Invalid login route in %s.', FormLoginAuthenticator::class));
    }

    /**
     * @Route("/logout", name="app_security_logout", methods={"GET"})
     */
    public function logout()
    {
        throw new \LogicException('Invalid "main.logout.path" in "security.yaml".');
    }
}
