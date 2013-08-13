<?php
// /var/www/Symfony/src/Phenome/TryBundle/Resources/config



use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();
$collection->add('phenome_try_homepage', new Route('/', array(
    '_controller' => 'PhenomeTryBundle:Try:index',
)));


$collection->add('drug', new Route('/drug/{drug_name}', array(
    '_controller' => 'PhenomeTryBundle:Try:get_drugs',
 'drug_name'        => 1,

), array(
    'drug_name' => '\w.+\s\[drugbank:\D{2}\d{5}]',
 // 'drug_uri' => 'http://bio2rdf.org/drugbank:\D{2}\d{5}',

)));


$collection->add('target', new Route('/target/{target_id}', array(
    '_controller' => 'PhenomeTryBundle:Try:get_TargetInfo',
 //'target_name'        => 1,
   'target_id' => 1
), array(
  //  'target_name' => '\w.+\s\[drugbank_target:\d{2,4}\]',
    'target_id' => '\d{2,4}'
)));

$collection->add('indication', new Route('/indication/{indication}', array(
    '_controller' => 'PhenomeTryBundle:Try:get_IndicationInfo',
 'indication'        => 1,
)));  




return $collection;
