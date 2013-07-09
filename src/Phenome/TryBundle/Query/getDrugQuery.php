<?php
// src/Phenome/TryBundle/Query/getDrugQuery.php

namespace Phenome\TryBundle\Query;

use Phenome\TryBundle\Entity\Drug;




class getDrugQuery 
{
	private $endpoint = "http://cu.drugbank.bio2rdf.org/sparql";
	private $test_number = 10;



public function getDrugsQuery ()

{

//this function performs the SPARQL query and saves the result in a EasyRDF array (mixed objects - literals  and ressources (uri))

$sparql = new \EasyRdf_Sparql_Client(self::endpoint);


$result = $sparql->query('SELECT ?drug ?drugname ?target ?indication
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .
			?drug <http://bio2rdf.org/drugbank_vocabulary:target> ?t .
			?t rdfs:label ?target .
			OPTIONAL{
			?drug <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication .}
			} LIMIT 10');

    echo '<pre>';

return $result;

} //closes function 

public function getDrugs()
{
 $sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');
 $result = $sparql->query ('SELECT ?drug ?drugname WHERE {?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug>; rdfs:label ?drugname .} LIMIT 10');
 return $result;
}

public function getTargets($drug_uri)
{
 $sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');
 $result = $sparql->query ('SELECT ?target_uri ?target_name 
WHERE {
  <'.$drug_uri.'> <http://bio2rdf.org/drugbank_vocabulary:target> ?target_uri .
  ?target_uri rdfs:label ?target_name .
}');
 return $result;
}

public function getIndications($drug_uri)
{
 $sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql');
 $result = $sparql->query ('SELECT ?indication_uri
WHERE {
  <'.$drug_uri.'> <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication_uri .
}');
 return $result;
}



public function getAllDrugInfo ()

{

//$get_drugs_service = $this->container->get('phenome_try.query');
$drug = new Drug;  
	$drugs = array();
	$drugs = $this-> getDrugs();
	foreach($drugs AS $i => $drug) {
		$o = '';
		$o['drug_uri'] = $drugs[$i]->{'drug'};
		$o['drug_name'] = $drugs[$i]->{'drugname'};

	// fetch targets
	$targets = array();
	$targets = $this->getTargets($o['drug_uri']);
	
	foreach ($targets AS $j => $target) {
		$t = '';
		$t['target_name'] = $targets[$j]->{'target_name'};
		$t['target_uri'] = $targets[$j]->{'target_uri'};
		$o['targets'][] = $t;
//print_r ($t);
	}

	// fetch indications
	$indications = array ();
	$indications = $this->getIndications($o['drug_uri']);

	foreach ($indications AS $x => $indication) {
		//var_dump ($indications); 
		$y = '';
		$y['indication_uri'] = $indications[$x]->{'indication_uri'};
		$o['indications'][] = $y; 
		//print_r ($y);
	//echo '<pre>';

					    } //closes foreach


	//$o->indications = $get_drugs_service->getIndications($o->drug_uri); 
	$results[] = $o;
	
	//print_r($results);
				} //closes

	
return $results;

} //closes function


public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
	{
	    $this->container = $container;

	} //closes function

} //closes class


















/* .::: EXTRA CODE (previous attempts) :::.



//works!
        $drugs = array();
	$drug = new Drug;

	foreach($result AS $key => $o) {
	   
  	
 	        //$drug->setDrugname($o->drugname);
		
		for($i=0;$i<count($result);$i++){
		$drug->setDrugname($o->drugname);


					  	} //closes for
			$drugs[]=$drug;



					}//closes foreach 

			//return $drug; 

