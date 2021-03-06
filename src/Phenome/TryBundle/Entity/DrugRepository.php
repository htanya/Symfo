<?php
// src/Phenome/TryBundle/Entity/DrugRepository.php

namespace Phenome\TryBundle\Entity;

/**
 * Phenome\TryBundle\Entity\DrugRepository
 */

class DrugRepository 
{

public function getDrugsQuery ()
{

	$sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');


        $result = $sparql->query('SELECT ?drug ?drugname
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .}');

	foreach($result AS $o) {
  		$drug = new Drug;
 		 $drug->setDrugname($o->drugname);
 		 $drugs[] = $drug;

		return $drug;
				} //closes foreach

	} //closes function
} //closes class
