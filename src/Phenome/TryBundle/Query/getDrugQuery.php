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
			?drug rdfs:label ?drugname .} LIMIT 3');

    echo '<pre>';
/*
//print_r($result->getFields());
echo "Loop starts here <br>";
for($i=0;$i<count($result);$i++){

    $dn = $result[$i]->{'drugname'};
    $d = $result[$i]->{'drug'};

    if(is_object($dn)){
        //see http://www.easyrdf.org/docs/api/EasyRdf_Literal.html
        print_r($dn->getValue());
        //echo $dn->
$drugs[] = $dn;

    }

    if(is_object($d)){
    //see http://www.easyrdf.org/docs/api/EasyRdf_Resource.html
        //print_r($d->get('uri'));    
    }
	
	
	



} //closes for */

//print_r ($dn);

return $result;
} //closes function 



/*

//works!
        $drugs = array();
	$drug = new Drug;

	foreach($result AS $key => $o) {
	   
  	
 	        //$drug->setDrugname($o->drugname);
		
		for($i=0;$i<count($result);$i++){
		$drug->setDrugname($o->drugname);


					  	} //closes for
			$drugs[]=$drug;



					}//closes foreach */

			//return $drug; 







public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
{
    $this->container = $container;
} //closes function


} //closes class
