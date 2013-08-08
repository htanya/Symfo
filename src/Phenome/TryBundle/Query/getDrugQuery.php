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
			} LIMIT 20');

    echo '<pre>';

return $result;

} //closes function 

public function getDrugs()
{
 $sparql = new \EasyRdf_Sparql_Client('http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=');
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

////

public function getTargetName($target_id) 
{
  $sparql = new \EasyRdf_Sparql_Client($this->endpoint);
  $target_uri = 'http://bio2rdf.org/drugbank_target:'.$target_id;

  $result = $sparql->query (
'SELECT ?target_uri ?target_name
WHERE {
  ?target_uri rdfs:label ?target_name .
  FILTER (?target_uri = <'.$target_uri.'>)
}');
  return $result;
}

public function getDrugsFromTargetId($target_id)
{
  $sparql = new \EasyRdf_Sparql_Client($this->endpoint);
  $target_uri = 'http://bio2rdf.org/drugbank_target:'.$target_id;

  $query = 
'SELECT ?drug_uri ?drug_name
WHERE {
  ?drug_uri <http://bio2rdf.org/drugbank_vocabulary:target> <'.$target_uri.'>  .
  ?drug_uri rdfs:label ?drug_name .
}';
$result = $sparql->query ($query);

  return $result;
}


public function getTarget($target_id)
{
	// fetch the basic target info
	$r = $this->getTargetName($target_id);

	$o = '';
	$o['target_uri'] = (string) $r[0]->{'target_uri'};
	$o['target_name'] = (string) $r[0]->{'target_name'};

	// fetch the drugs that target it
	$drugs = $this->getDrugsFromTargetId($target_id);
	foreach($r AS $i => $drug) {
		$d = '';
		$d['drug_uri'] = (string) $drugs[$i]->{'drug_uri'};
		$d['drug_name'] = (string) $drugs[$i]->{'drug_name'};

		$o['drugs'][] = $d;
	}
	//$results[] = $o;

	return $o;
}

////


///// **** //////

public function getDrugID($drug_name) 
{

//echo '<pre>';
$result = array();
//$result[] = $drug_name;


	  $sparql = new \EasyRdf_Sparql_Client($this->endpoint);
	  

	  $result = $sparql->query (
		'SELECT ?drug_uri ?drug_name
		WHERE {
		  ?drug_uri rdfs:label ?drug_name .
		  FILTER (?drug_name = "'.$drug_name.'"@en)
		}');
	  return $result; 
}
 
public function getTargetsFromDrugId($drug_name)
{
  $sparql = new \EasyRdf_Sparql_Client($this->endpoint);
  preg_match ("/drugbank:DB\d{4,6}/", $drug_name, $d);
  $drug_id = $d[0];
  $drug_uri = "http://bio2rdf.org/"."$drug_id";

$result = array();
//$result[] = $drug_uri;


$query = 
'SELECT ?target_uri ?target_name
WHERE {
  <'.$drug_uri.'> <http://bio2rdf.org/drugbank_vocabulary:target> ?target_uri  .
  ?target_uri rdfs:label ?target_name .
}'; 

$result = $sparql->query ($query);

  return $result;
}


public function getRenderedDrug($drug_name)
{
	// fetch the basic drug info
	$r = $this->getDrugID($drug_name);

	$o = '';
	$o['drug_uri'] = (string) $r[0]->{'drug_uri'};
	$o['drug_name'] = (string) $r[0]->{'drug_name'};

	// fetch the drugs that target it
	$targets = $this->getTargetsFromDrugId($drug_name);
	foreach($r AS $i => $target) {
		$d = '';
		$d['target_uri'] = (string) $targets[$i]->{'target_uri'};
		$d['target_name'] = (string) $targets[$i]->{'target_name'};

		$o['targets'][] = $d;
	}
	//$results[] = $o;

	return $o;
}

///// **** //////



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
		}

		// fetch indications
		$indications = array ();
		$indications = $this->getIndications($o['drug_uri']);

		foreach ($indications AS $x => $indication) {
			//var_dump ($indications); 
			$y = '';
			$y['indication_uri'] = $indications[$x]->{'indication_uri'};
			$o['indications'][] = $y; 

		} //closes foreach
		$results[] = $o;
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

			//return $drug; */

