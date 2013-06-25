<?php
// src/Phenome/TryBundle/Query/getDrugQuery.php

namespace Phenome\TryBundle\Query;

use Phenome\TryBundle\Entity\Drug;




class getDrugQuery 
{


private $drugname = null;



public function getDrugsQuery ()
{



	$sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');


        $result = $sparql->query('SELECT ?drug ?drugname
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .} ');
	

	foreach($result AS $o) {
	 
  		 $drug = new Drug;
 		 $drug->setDrugname($o->drugname);
 		 $drugs[] = $drug;

				}//closes foreach
		return $drug;

	} //closes function



} //closes class
