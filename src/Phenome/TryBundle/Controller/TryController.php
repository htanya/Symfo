<?php
// src/Phenome/TryBundle/Controller/TryController.php

namespace Phenome\TryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Phenome\TryBundle\Entity\Drug;
use Phenome\TryBundle\Entity\DrugRepository;
use Phenome\TryBundle\Query\getDrugQuery;




//$result =  $this->get('phenome_try.query');

class TryController extends Controller
  {


  public function indexAction()
    {
	
 	$drug = new getDrugQuery;  
	$drugs[]=$drug;


  echo '<pre>';
       // echo $obj->getDrugsQuery();


	  //$this->get('phenome_try.query');
        // $this->container->get('phenome_try.query');
	//$drug =  $this->container->get('phenome_try.query');
                  //$this->getRepository('PhenomeTryBundle:DrugRepository');
	         //$this-> getDrugsQuery ();

/*
foreach($result AS $o) {
  		$drug = new Drug;
 		 $drug->setDrugname($o->drugname);
 		 $drugs[] = $drug;

		return $drug;} */
	 
	
    


  

  return $this->render('PhenomeTryBundle:Try:index.html.twig', 
		array('drugs'=>$drug)
		);
    } //closes function

  } //closes class
