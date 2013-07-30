<?php



//<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
//<script src="bundles/datatables/js/jquery.dataTables.js"></script>

//paging

//obtaining limit from table, and using it for SPARQL query
$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) //Get_ variables are given by server/DataTables
	{
		$sLimit = 
			( $_GET['iDisplayLength'] );
	}



	

$myQuery = "SELECT ?drug ?drugname ?target ?indication
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .
			?drug <http://bio2rdf.org/drugbank_vocabulary:target> ?t .
			?t rdfs:label ?target .
			OPTIONAL{
			?drug <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication .}
			}";

$query_for_count = "SELECT (COUNT(?drug) AS ?count)
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			?drug rdfs:label ?drugname .
			?drug <http://bio2rdf.org/drugbank_vocabulary:target> ?t .
			?t rdfs:label ?target .
			OPTIONAL{
			?drug <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication .}
			}";


$myQuery2 = $myQuery;


$aColumns = array( 'drugname', 'target', 'indication');



						// :::::::::::::::::::::
						// :: Function calls ::: 
						// :::::::::::::::::::::



/////////////////// 1st Query //////////////////////////

// no limit|order by|offset - used later on to determine offset for 2nd query (the one brought back to the client)

$general_result = getBasic_FromEndpoint(urlencode($myQuery2));
 
if($general_result != null){
        //print_r($general_result);
} 

//number of entries in endpoint (using <json> to denote new row)
$new_row = '"drug"';

//place of user (needs to be an integer) 
$offset = "";

if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$offset = ( $_GET['iDisplayStart'] );
	}

//$offset = ($GET_['iDisplayStart']); //iDisplayStart given by server/DataTables

//number of query results in total
$total_record_count = substr_count ($general_result, $new_row);



//next results to show - or OFFSET
//$offset = ($total_record_count)-($pointer_user);
$offset = 5;




/////////////////// 2nd Query //////////////////////////


//2nd QUERY (to obtain results)
	//Limit query matches returned


//order by (?variable)
$orderby = '?drug';

//query

$filtered_result = getFromEndpoint(urlencode($myQuery), $orderby, $sLimit, $offset);
 
if($filtered_result != null){
       print_r($filtered_result);
$f2 = json_encode($filtered_result);

}

//number of FILTERED query results in total
$total_filtered_count = substr_count ($filtered_result, $new_row);

//$total_filtered_record_count = settype($total_filtered_count, "integer");






					// :::::::::::::::::::::
					// ::::: Functions ::::: 
					// :::::::::::::::::::::

 
//final query used to get the results with the desired limit and offset -> to be returned to table
function getFromEndpoint($query, $orderby, $slimit, $offset){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."+order+by+".$orderby."+limit+".$slimit."+offset+".$offset."&format=json%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}

 //used to get the total number of possible results
function getBasic_FromEndpoint($query){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."&format=json%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
} 

$output = array(
"sEcho" => intval($_GET['sEcho']),
"iTotalRecords" => intval($total_record_count),
"iTotalDisplayRecords" => intval($total_filtered_record_count),
"aaData" => array(),
);

while ( $aRow = ( $f2 ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == !null )
			{
				/* Special output formatting for 'version' column */
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				/* General output */
				$row[] = ($aRow[ $aColumns[$i] ]);
			}
		}
		$output['aaData'][] = $row;
	}

echo json_encode( $output );
	
/*
SPARQL for total endpoint results

//$get_total_record_count = intval(getBasic_FromEndpoint(urlencode($query_for_count)));

//preg_match ("/\#integer\\\">(\d{4,5})\</", $get_total_record_count, $total_record_c);

//$total_record_count = settype($total_record_c, "integer");


//echo "query count is".$total_record_count."\n";

*/
?>
