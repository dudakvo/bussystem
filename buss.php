<?php

//============================================= набор параметров =======================================================
$parameters['login']="dudakvo";
$parameters['password']="i6JX7CzbRZ6H";
$parameters['lang']='ua';
//$parameters['country_id']=1;
//$parameters['point_id_from']=1;
//$parameters['point_id_to']=90;
$parameters['autocomplete']="Киев";
//$parameters['boundLatSW']=45.46;
//$parameters['boundLonSW']=52.64;
//$parameters['boundLatNE']=52.29;
//$parameters['boundLotNE']=44.71;
$parameters['trans']="bus";
//$parameters['viev']="get_coutnry";
$parameters['all']="1";

//**********************************************************************************************************************

$parametersRoute['login']="dudakvo";
$parametersRoute['password']="i6JX7CzbRZ6H";
//$parametersRoute['v']="1.1";
//$parametersRoute['id_from']="6";
//$parametersRoute['id_to']="7";
//$parametersRoute['point_train_from_id']=2004000;
//$parametersRoute['point_train_to_id']=2062428;
//$parametersRoute['id_iata_from']="LWO";
//$parametersRoute['id_iata_to']="KBP";
$parametersRoute['date']="2014-08-21";
//$parametersRoute['currency']="EUR";
$parametersRoute['period']=3;
//$parametersRoute['interval_id']=45475;
//$parametersRoute['route_id']=90;
//$parametersRoute['trans']="all";
//$parametersRoute['search_type']=1;
//$parametersRoute['find_order_id']=10527554;
//$parametersRoute['find_ticket_id']=90005;
//$parametersRoute['find_security']=5735838;
//$parametersRoute['change']=1;
//$parametersRoute['direct']=1;
//$parametersRoute['baggage_no']=1;
//$parametersRoute['service_class']="E";
//$parametersRoute['adt']=2;
//$parametersRoute['chd']=1;
//$parametersRoute['inf']=1;
//$parametersRoute['sort_type']="price";
//$parametersRoute['ws']=1;
//$parametersRoute['lang']="ru";
//**********************************************************************************************************************

//======================================================================================================================

function getSubElements ($XMLElement)
{
    $elementCount=0;
    foreach($XMLElement as $elementList=>$elementItem)
    {
        if(count($elementItem)==0)
        {
            $elementArray[$elementCount][$elementList]=$elementItem;
        }
        else
        {
            foreach ($elementItem as $elementKey=>$elementValue)
            {
                if(count($elementValue)>0)
                {
                    $elementNumber=0;
                    foreach ($elementValue as $element)
                    {
                        $elementSet[$elementNumber]=$element;
                        $elementNumber++;
                    }
                    $elementArray[$elementCount][$elementKey]=$elementSet;
                }
                else{
                    $elementArray[$elementCount][$elementKey]=$elementValue;
                }

            }
        }
        $elementCount++;
        unset($elementItem);
    }
    unset($XMLElement);
    return $elementArray;
}

function getCityInfo(array $parameter_set)
{
    $urlGetPoints="https://test-api.bussystem.eu/server/curl/get_points.php";

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

    return $result=getSubElements($parsingXML);
}

function getCityRoute(array $parameter_set)
{
    $urlGetRoutes="https://test-api.bussystem.eu/server/curl/get_routes.php?";

    $ch = curl_init();

    curl_setopt_array($ch, array(
        CURLOPT_URL => $urlGetRoutes,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($parameter_set)
    ));

    $requestXMLString = curl_exec($ch);
    curl_close($ch);
    // echo $requestXMLString;
    //echo"<hr> Результат". $requestXMLString."<hr>";
    //===================================== парсинг полученого ответа ============================================
    $parsingXML=new SimpleXMLElement($requestXMLString);
    $countRow=0;
    //echo"<hr>Результат пошуку маршрутів<hr>";
    foreach ($parsingXML->item as $item)
    {
        foreach ($item as $key=> $XMLElementValue)
        {
            //       $result[$count][$key]=$XMLElementValue;

            if ( $key=="discounts")
            {
                $discountList = getSubElements($XMLElementValue);
                $result[$countRow][$key]=$discountList;
            }
            if($key=="free_seats")
            {
                $countSeats=0;
                foreach ($XMLElementValue as $freeSeatsItem => $freeSeatsValue)
                {
                    $freeSeats[$countSeats]=$freeSeatsValue;
                    $countSeats++;
                }
                $result[$countRow][$key]=$freeSeats;
            }
            if($key=="cancel_hours_info")
            {
                $cancelHoursInfo = getSubElements($XMLElementValue);
                $result[$countRow][$key]=$cancelHoursInfo;
            }
            if($key=="change_route")
            {
                $changeRoute = getSubElements($XMLElementValue);
                $result[$countRow][$key] = $changeRoute;
            }
            else {
                $result[$countRow][$key]=$XMLElementValue;
            }
            // ================== end operator SWITCH+++++++++++++++++++++++++++++++++++++++++
            //echo $key."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$XMLElementValue." &nbsp;&nbsp;Element Count=".count($XMLElementValue)."<br>";
        }
        $countRow++;
    }

    return $result;
}

//----------------------------------------------------------- "Установка параметров-------------------------------------
$searchArrayKiev=getCityInfo($parameters);
$parameters['autocomplete']="Львов";
$searchArrayLvov=getCityInfo($parameters);

$parametersRoute['id_from']=$searchArrayKiev[0]['point_id']*1;
$parametersRoute['id_to']=$searchArrayLvov[0]['point_id']*1;

$parametersRoute['date']="2020-08-21";

$searchArrayRoute=getCityRoute($parametersRoute);

$countRoute=0;

foreach ($searchArrayRoute as $row => $column)

{
    foreach ($column as $columnName => $columnValue)
    {
        if(count($columnValue)>0)
        {
            //for($i=0;$i<=count($columnValue);$i++)
            foreach ($columnValue as $columnValues)
            {
              //  echo "&nbsp;&nbsp;&nbsp;&nbsp;[" . $row . "][" . $columnName . "]=" . $columnValues . "<br>";
                //**********************************************************************************************
                foreach ($columnValues as $elementKey=>$elementValue)
                {
                    if(count($elementValue)>0)
                    {
                        foreach ($elementValue as $subElementKey=>$subElementValue)
                        {
                            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $subElementKey . "=" . $subElementValue . "<br>";
                        }
                        echo"<hr>";
                    }
                    else{
                        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" . $elementKey . "=" . $elementValue . "<br>";
                    }
                }
                //**********************************************************************************************
            }
        }
        else {
               echo $columnName . ":" . $columnValue . "<br>";
        }
    }

    echo "<hr><hr><hr>";
}



?>

