<?php

//no DataTables code, PHP only (works) - has a made-up "pointer_user" value (place where the results in current table end)
 
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

 
function getFromEndpoint($query, $orderby, $limit, $offset2){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."+order+by+".$orderby."+limit+".$limit."+offset+".$offset2."&format=xml%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}

 
function getBasic_FromEndpoint($query){
        $f = file_get_contents("http://cu.drugbank.bio2rdf.org/sparql?default-graph-uri=&query=".$query."&format=xml%2Fhtml&timeout=0");
        if($f != null && strlen($f)>0){
                return $f;
        }else{
                return null;
        }
}

?>
