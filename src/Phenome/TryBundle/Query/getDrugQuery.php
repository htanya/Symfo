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

//print_r($result->getFields());
echo "*****768768686* =><br>";
for($i=0;$i<count($result);$i++){
	$dn = $result[$i]->{'drugname'};
	$d = $result[$i]->{'drug'};
	if(is_object($dn)){
		//see http://www.easyrdf.org/docs/api/EasyRdf_Literal.html
		//print_r($dn->getValue());
	print $drugs[$i]=$dn;
		//echo $dn->
	}
	if(is_object($d)){
	//see:http://www.easyrdf.org/docs/api/EasyRdf_Resource.html
		print_r($d->getUri());	
	}
		
		//var_dump(get_object_vars($d));	
	
	echo "<br>*======*<br>";



}
//    print_r($result[45]->drug); 
 // print_r($result[1]->drugname); 

//$drugname = "";
/*echo "<br>*******<br>";
foreach ($result as $key =>$value) {
	print_r($key);
echo "<br>*======*<br>";
	print_r($value);
	foreach ($value as $index => $o) {
	$drug->setDrugname($o->drugname);
	$drugs[]=$drug;
					}//closes foreach 1
	
//return $drug; 
}//closes foreach 2
*/

/* DOESN'T WORK
$drug= new Drug;
foreach ($result as $o){
$drug=$o->drugname;
}
return $drug; 
*/


/*
//brings back 1 single drugname
$drug= new Drug;
for($i=0;$i<count($result);$i++){
foreach ($result AS $o){
$drug->setDrugname($o->drugname);
$drugs[]=$drug;
			}//closes foreach

}//closes for
return $drug; */


/*
//Doesn't work ...
		$drugs = array();
		$drug = new Drug;
	foreach ($result AS $o){
	$drug->__toString($o->drugname);
		//foreach ($value as $o) {
		//for($i=0;$i<count($result);$i++) {
		//$drug = new Drug;
		//$drug->setDrugname($o->drugname);
		//$drug->setDrugname($o->drugname);
	//foreach ($druggie AS $drug){

		$drugs[]=$drug;
				//}//closes foreach2
		
				      }//closes foreach 1 */






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



} //closes function 





public function setContainer(\Symfony\Component\DependencyInjection\ContainerInterface $container = null)
{
    $this->container = $container;
} //closes function


} //closes class
