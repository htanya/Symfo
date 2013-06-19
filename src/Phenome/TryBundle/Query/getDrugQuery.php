<?php
// src/Phenome/TryBundle/Query/getDrugQuery.php

namespace Phenome\TryBundle\Query;

use Phenome\TryBundle\Entity\Drug;




class getDrugQuery 
{

public function getDrugsQuery ()
{

//private $drugname = null;

//public $result;

	$sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');


        $result = $sparql->query('SELECT ?drug ?drugname
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .}LIMIT 1');

	foreach($result AS $o) {
  		$drug = new Drug;
 		 $drug->setDrugname($o->drugname);
 		 $drugs[] = $drug;

		return $drug;
				} //closes foreach

	} //closes function



} //closes class
