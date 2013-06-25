<?php
// src/Phenome/TryBundle/Controller/TryController.php

namespace Phenome\TryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Phenome\TryBundle\Entity\Drug;
use Phenome\TryBundle\Entity\DrugRepository;
use Phenome\TryBundle\Query\getDrugQuery;






class TryController extends Controller
  {


  public function indexAction()
    {
	
	$get_drugs_service = $this->container->get('phenome_try.query');
 	$drug = new Drug;  
	$drug = $get_drugs_service-> getDrugsQuery('drugname');
        $drugs[]=$drug;
	
 // echo '<pre>';
  
  
  return $this->render('PhenomeTryBundle:Try:index.html.twig', 
		array('drugs'=>$drugs)
		);

    } //closes function



  } //closes class
