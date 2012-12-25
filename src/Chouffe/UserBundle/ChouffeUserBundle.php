<?php

namespace Chouffe\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ChouffeUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
