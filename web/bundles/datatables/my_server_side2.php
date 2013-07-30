<?php

//paging

//obtaining limit from table, and using it for SPARQL query
$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) //Get_ variables are given by server/DataTables
	{
		$sLimit = "sLimit ".( $_GET['iDisplayStart'] ).", ".
			( $_GET['iDisplayLength'] );
	}


$orderby = '?drug';



	

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
        //print_r($general_result);
} 

//number of entries in endpoint (using <xml> to denote new row)
$row = '<binding name="drug">';

//place of user (needs to be an integer) 
$pointer_user = ($GET_['iDisplayStart']); //iDisplayStart given by server/DataTables

//number of query results in total
$total_record_count = substr_count ($general_result, $row);

//next results to show - or OFFSET
$offset = ($total_record_count)-($pointer_user);

} 


/////////////////// 2nd Query //////////////////////////


//2nd QUERY (to obtain results)
	//Limit query matches returned


//order by (?variable)
$orderby = '?drug';

//query
$filtered_result = getFromEndpoint(urlencode($myQuery), $orderby, $sLimit, $offset);
 
if($filtered_result != null){
       print_r($filtered_result);

}

//number of FILTERED query results in total
$total_filtered_record_count = substr_count ($filtered_result, $row);






					// :::::::::::::::::::::
					// ::::: Functions ::::: 
					// :::::::::::::::::::::

 
//final query used to get the results with the desired limit and offset -> to be returned to table
function getFromEndpoint($query, $orderby, $slimit, $offset){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."+order+by+".$orderby."+limit+".$slimit."+offset+".$offset."&format=xml%2Fhtml&timeout=0");
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

$output = array(
"sEcho" => intval($_GET['sEcho']),
"iTotalRecords" => $total_record_count,
"iTotalDisplayRecords" => $total_filtered_record_count,
"aaData" => array($filtered_result)
"sColumns" =>
);


	
?>
