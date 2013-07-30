<?php

				//get server variables for table
	//sEcho
if(isset($_GET['sEcho'])) {
 $echo_value = intval($_GET['sEcho']);
} else $echo_value = 1;

	//iDisplayStart (offset)
if(isset($_GET['iDisplayStart'])) {
 $offset = $_GET['iDisplayStart'];
} else $offset = 0;

	//iDisplayLength (limit)
if(isset($_GET['iDisplayLength'])) {
 $limit = $_GET['iDisplayLength'];
} else $limit = 20;


				// get the total number of results

$q = "SELECT (count(?drug) AS ?count) WHERE { ?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug>}";
$r = getBasic_FromEndpoint($q);
$o = json_decode($r);
$total_record_count = (int) ($o->results->bindings[0]->count->value);

/*
				// get the total number of results AFTER filtering (iTotalDisplayRecords)

$q = "SELECT (count(?drug) AS ?count) WHERE { ?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug>}";
$r = getBasic_FromEndpoint($q);
$o = json_decode($r);
$total_record_count = (int) ($o->results->bindings[0]->count->value); */


				// now fetch what is wanted to populate the table

//Query to get drug_uri's and drug
$q = "SELECT ?drug ?drugname 
WHERE { 
 ?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
 ?drug rdfs:label ?drugname .
 $filter
}";

//makes column 1 to be filterable
if($_GET['iSortCol_0'] == 0) {
  $sort_order = $_GET['sSortDir_0']."(?drug)";
} else $sort_order = "ASC(?drug)";


//makes column 1 searchable (in search box above table)
if(isset($_GET['sSearch_0'])) {
  $filter = " filter regex(?drugname,\"".$_GET['sSearch']."\", \"i\")";
}

//Query to get drug_uri's
$r = getFromEndpoint($q, $sort_order, $limit, $offset);
$o = json_decode($r);
$record_count = count($o->results->bindings);


//get drugname object to put into JSON array rendered to table
$rows = array();
foreach($o->results->bindings AS $result) {
  $drug_uri = (string) ($result->drug->value);
  $drug_name = (string) ($result->drugname->value);

  $row = array();
  $row[] = $drug_name;

// Query to get drug targets (with reference to drug_uri)
  $q = "SELECT ?target_uri ?target_name 
WHERE {
 <$drug_uri> <http://bio2rdf.org/drugbank_vocabulary:target> ?target_uri .
 ?target_uri rdfs:label ?target_name .
} 
ORDER BY ASC(?target_name)";
  $r = getBasic_FromEndpoint($q);
  $o2 = json_decode($r);

//create a list of targets to display in table
  $target_list = '<ul>';
  foreach($o2->results->bindings AS $result2) {
   $target_list .= "<li>";
   $target_list .= (string) ($result2->target_name->value);
  }
  $target_list .= '</ul>';
  $row[] = $target_list;



// Query to get drug indications (with reference to drug_uri)
  $q = "SELECT ?indication 
WHERE {
 <$drug_uri> <http://bio2rdf.org/drugbank_vocabulary:indication> ?indication  .
} 
ORDER BY ASC(?indication)";
  $r = getBasic_FromEndpoint($q);
  $o3 = json_decode($r);

//create a list of indications to display in table
  $indication_list = '<ul>';
  foreach($o3->results->bindings AS $result3) {
   $indication_list .= "<li>";
   $indication_list .= (string) ($result3->indication->value);
  }
  $indication_list .= '</ul>';
  $row[] = $indication_list;

// creating the rendering array
  $row[] = '';
  $rows[] = $row;

}

$record_count = (int) 4000;

$output = array(
"sEcho" => $echo_value,
"iTotalRecords" => intval($total_record_count),
"iTotalDisplayRecords" => intval($total_record_count),
"aaData" => $rows,
);

echo json_encode($output);
exit;//don't delete



					// :::::::::::::::::::::
					// ::::: Functions ::::: 
					// :::::::::::::::::::::

 
//final query used to get the results with the desired limit and offset -> to be returned to table
function getFromEndpoint($query, $orderby, $slimit, $offset)
{
 $url = "http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".urlencode($query)."+order+by+".$orderby."+limit+".$slimit."+offset+".$offset."&format=json&timeout=0";
file_put_contents('/tmp/test.out',$url);
        $f = file_get_contents($url);
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}

 //used to get the total number of possible results
function getBasic_FromEndpoint($query){
        //$f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."&format=xml%2Fhtml&timeout=0");
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".urlencode($query)."&format=json&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
} 

//$test_records = (int) 4000;


	
/*
SPARQL for total endpoint results

//$get_total_record_count = intval(getBasic_FromEndpoint(urlencode($query_for_count)));

//preg_match ("/\#integer\\\">(\d{4,5})\</", $get_total_record_count, $total_record_c);

//$total_record_count = settype($total_record_c, "integer");


//echo "query count is".$total_record_count."\n";

OLD CODE
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

$query_for_count = "SELECT (COUNT(?drug) AS ?count)
			WHERE {
			?drug a <http://bio2rdf.org/drugbank_vocabulary:Drug> .
			";


$myQuery2 = $myQuery;


$aColumns = array( 'drugname', 'target', 'indication');


/////////////////// 1st Query //////////////////////////

// no limit|order by|offset - used later on to determine offset for 2nd query (the one brought back to the client)

$general_result = getBasic_FromEndpoint(urlencode($myQuery2));
 
if($general_result != null){
        //print_r($general_result);
} 

//number of entries in endpoint (using <xml> to denote new row)
//$new_row = '<binding name="drug">';

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
      // print_r($filtered_result);


}

//number of FILTERED query results in total
$total_filtered_count = substr_count ($filtered_result, $new_row);

//$total_filtered_record_count = settype($total_filtered_count, "integer");


$output = array(
"sEcho" => intval($_GET['sEcho']),
"iTotalRecords" => intval($total_record_count),
"iTotalDisplayRecords" => intval($test_records),
"aaData" => array(),
);

while ( $aRow = ( $filtered_result ) )
	{
		$row = array();
		for ( $i=0 ; $i<count($aColumns) ; $i++ )
		{
			if ( $aColumns[$i] == !null )
			{
				// Special output formatting for 'version' column 
				$row[] = ($aRow[ $aColumns[$i] ]=="0") ? '-' : $aRow[ $aColumns[$i] ];
			}
			else if ( $aColumns[$i] != ' ' )
			{
				 //General output 
				$row[] = ($aRow[ $aColumns[$i] ]);
			}
		}
		$output['aaData'][] = $row;
	}

echo json_encode( $output );

*/
?>