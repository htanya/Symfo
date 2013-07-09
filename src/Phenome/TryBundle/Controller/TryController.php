<?php
// src/Phenome/TryBundle/Controller/TryController.php

namespace Phenome\TryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Phenome\TryBundle\Entity\Drug;
use Phenome\TryBundle\Query\getDrugQuery;




class TryController extends Controller
  {


  public function indexAction()
    {
	
$get_drugs_service = $this->container->get('phenome_try.query');
$results = array();	
$results = $get_drugs_service->getAllDrugInfo();

return $this->render('PhenomeTryBundle:Try:index.html.twig',  array('results'=>$results));


	} //closes function


 public function get_drugsAction()
    {

$drug_uri = new Drug;
$get_drugs_service = $this->container->get('phenome_try.query');
$results = array();	
$results = $get_drugs_service->getAllDrugInfo();
//var_dump($results);


return $this->render('PhenomeTryBundle:Try:get_drugs.html.twig', array('results'=>$results));

				} //closes function 




	











} //closes class




/* OLD CODE
	$result = $get_drugs_service-> getDrugsQuery('result');

//accessing $result array (from SPARQL query), and getting out the drug attributes (drugname, drug uri, target and indications)
for($i=0;$i<count($result);$i++){

    $drugname = $result[$i]->{'drugname'};
    $drug_uri = $result[$i]->{'drug'};
    $target = $result[$i]->{'target'};
    $indication = $result[$i]->{'indication'};

///creating the arrays ($drugs, $drugs_uri, $drugs_target and $drugs_indication) to pass onto the view

    if(is_object($drugname)){
        //see http://www.easyrdf.org/docs/api/EasyRdf_Literal.html
    $drugs[] = $drugname->getValue();

    }

    if(is_object($drug_uri)){
    /* see http://www.easyrdf.org/docs/api/EasyRdf_Resource.html
	drug_uri is an rdf_ressource, which is why __toString is used instead of getValue 

   $drugs_uri[] = $drug_uri ->__toString();  
    }

if(is_object($target)){
    $drugs_target[] = $target->getValue();

    }

if(is_object($indication)){
    $drugs_indication[] = $indication->getValue();

    }

} //closes for
	
  //renders the arrays of drug attributes to the index template (project homepage)
  return $this->render('PhenomeTryBundle:Try:index.html.twig', 
		array('drugs'=>$drugs, 'drugs_uri'=>$drugs_uri, 'drugs_target'=>$drugs_target, 'drugs_indication'=>$drugs_indication)
		); */

    
