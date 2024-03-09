<?php

use Symfony\Component\HttpFoundation\Response;

class DefaultController
{
    public function main(): Response
    {
        return new Response('');
    }
}
