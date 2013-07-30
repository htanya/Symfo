<?php
/*
This script is able to print a list of results obtained from a 2nd query that makes use of ORDER BY, LIMIT and OFFSET. The offset is obtained from the 1st query to get the total number of results in the endpoint (which would normally ALL be rendered to the table), as well as the current place in the table of results (to know where to start).

Running this script, you should have 10 results being printed out to you; drugs DB03995 - DB04004 (some drugs are repeated as they have multiples - ex. multiple targets due to one-to-many relationships).

*/

 
						// :::::::::::::::::::::
						// :::::: Queries :::::: 
						// :::::::::::::::::::::

$myQuery = "SELECT ?drug ?drugname ?target ?indication
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .
			?drug <http://bio2rdf.org/drugbank_vocabulary:target> ?t .
			?t rdfs:label ?target .
			OPTIONAL{
			?drug <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication .}
			}";

$myQuery2 = $myQuery;





						// :::::::::::::::::::::
						// :: Function calls ::: 
						// :::::::::::::::::::::



/////////////////// 1st Query //////////////////////////

// no limit|order by|offset - used later on to determine offset for 2nd query (the one brought back to the client)

$general_result = getBasic_FromEndpoint(urlencode($myQuery2));
 
if($general_result != null){
        //print_r($result);
} 

//number of entries in endpoint (using <xml> to denote new row)
$row = '<binding name="drug">';

//place of user (needs to be an integer) -> *MUST FIND OUT HOW TO OBTAIN THIS FROM TABLE REQUEST TO THIS SERVER_SCRIPT*
$pointer_user = 20; //20 is just for the test

//number of query results in total
$record_count = substr_count ($general_result, $row);

//next results to show - or OFFSET
$offset2 = ($record_count)-($pointer_user);



/////////////////// 2nd Query //////////////////////////


//2nd QUERY (to obtain results)

//Limit query matches returned
$limit = 10;

//order by (?variable)
$orderby = '?drug';

//query
$result = getFromEndpoint(urlencode($myQuery), $orderby, $limit, $offset2);
 
if($result != null){
       print_r($result);

}




					// :::::::::::::::::::::
					// ::::: Functions ::::: 
					// :::::::::::::::::::::

 
//final query used to get the results with the desired limit and offset -> to be returned to table
function getFromEndpoint($query, $orderby, $limit, $offset2){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."+order+by+".$orderby."+limit+".$limit."+offset+".$offset2."&format=xml%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}

 //used to get the total number of possible results
function getBasic_FromEndpoint($query){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."&format=xml%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
} 







/*

EXTRA

//echo "num of rows is".$record_count."!"."\n";

/*
if (is_object($result)){
echo "I'm an object!"."\n";
} else {
echo "NOT an object!"."\n";
} 

//original function WITH offset
function getFromEndpoint($query, $orderby, $limit, $offset){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."+order+by+".$orderby."+limit+".$limit."+offset+".$offset."&format=text%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}


// html table to array

function make_array ($table){
$result = array();

$dom = new DOMDocument;
$dom->loadHTML($table);
$xPath = new DOMXPath($dom);

$td = $xPath->query('//table/tr');

foreach($td as $val){
    $result[] = $val->nodeValue;
}

print_r($result);

}

*/
?>


