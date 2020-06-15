<?php

$urlGetRoutes="http://test-api.bussystem.eu/server/curl/get_routes.php?";

$parameters['login']="dudakvo";
$parameters['password']="i6JX7CzbRZ6H";
$parameters['lang']='ua';
//$parameters['country_id']=1;
//$parameters['point_id_from']=1;
//$parameters['point_id_to']=90;
//$parameters['autocomplete']="Киев";
//$parameters['boundLatSW']=45.46;
//$parameters['boundLonSW']=52.64;
//$parameters['boundLatNE']=52.29;
//$parameters['boundLotNE']=44.71;
//$parameters['trans']="air";
$parameters['viev']="get_coutnry";
$parameters['all']="1";

function getCityInfo(array $parameter_set)
{
    $urlGetPoints="https://test-api.bussystem.eu/server/curl/get_points.php";

        echo"<br>". $urlGetPoints ."<hr>";
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $urlGetPoints,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($parameter_set)
        ));

    $requestXMLString = curl_exec($ch);
    curl_close($ch);

    //===================================== парсинг полученого ответа ============================================

    $parsingXML=new SimpleXMLElement($requestXMLString);

    $count=0;
    foreach ($parsingXML->item as $item)
    {
        foreach ($item as $key=> $XMLElementValue)
        {
            $result[$count][$key]=$XMLElementValue;
        }
        $count++;
    }
    return $result;
}

$searchArray=getCityInfo($parameters);
echo count($searchArray);

foreach ($searchArray as $row =>  $column)
{
    foreach ($column as $columnName => $columnValue)
    {
        echo "[".$row."][".$columnName."]=".$columnValue."<br>";
    }
    echo"<hr>";
}

?>
