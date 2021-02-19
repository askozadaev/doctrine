<?php

namespace App\Action;

use Interop\Container\ContainerInterface;

class HomePageFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $em = $container->get(EntityManagerInterface::class);
//        $em = $container->get('doctrine.entity_manager.orm_default');

        return new HomePageAction($em);
    }
}