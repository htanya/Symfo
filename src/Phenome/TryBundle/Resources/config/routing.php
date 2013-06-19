<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('phenome_try_homepage', new Route('/', array(
    '_controller' => 'PhenomeTryBundle:Try:index',
)));

return $collection;
