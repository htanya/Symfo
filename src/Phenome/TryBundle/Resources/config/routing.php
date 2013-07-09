<?php
// /var/www/Symfony/src/Phenome/TryBundle/Resources/config

// regEx for drugname "(\D+)\[\D

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('phenome_try_homepage', new Route('/', array(
    '_controller' => 'PhenomeTryBundle:Try:index',
)));

$collection->add('drug', new Route('/drug/{drug_uri}', array(
    '_controller' => 'PhenomeTryBundle:Try:get_drugs',
 'drug_uri'        => 1,

), array(
    'drug_uri' => 'http://bio2rdf.org/drugbank:\D{2}\d{5}',

)));

return $collection;
