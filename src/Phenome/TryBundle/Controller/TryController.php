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
 	$drug = new Drug;  
	$result = $get_drugs_service-> getDrugsQuery('result');

$drugs= array();

for($i=0;$i<count($result);$i++){

    $dn = $result[$i]->{'drugname'};
    $d = $result[$i]->{'drug'};

    if(is_object($dn)){
        //see http://www.easyrdf.org/docs/api/EasyRdf_Literal.html
        //print_r($dn->getValue());
    $drugs[] = $dn->getValue();

    }

    if(is_object($d)){
    //see http://www.easyrdf.org/docs/api/EasyRdf_Resource.html
        //print_r($d->get('uri'));    
    }


} //closes for


	
 // echo "\n".'controller'."\n";
//var_dump($drugs);
  

  
  return $this->render('PhenomeTryBundle:Try:index.html.twig', 
		array('drugs'=>$drugs)
		);

    } //closes function



public function __toString()
    {
        return strval($this->drugname);
    }



  } //closes class
