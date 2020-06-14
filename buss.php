<?php

$urlGetRoutes="http://test-api.bussystem.eu/server/curl/get_routes.php?";

$parameters['login']="dudakvo";
$parameters['password']="i6JX7CzbRZ6H";
$parameters['lang']='ua';
//$parameters['country_id']=1;
//$parameters['point_id_from']=1;
//$parameters['point_id_to']=90;
//$parameters['autocomplete']="Льв";
$parameters['boundLatSW']=45.46;
$parameters['boundLonSW']=52.64;
$parameters['boundLatNE']=52.29;
$parameters['boundLotNE']=44.71;
//$parameters['trans']="all";
$parameters['viev']="get_coutnry";
$parameters['all']="1";

//========================================== XML string =============================================

$requestXMLString="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<root>
    <item>
        <point_id>2</point_id>
        <point_latin_name>Minsk</point_latin_name>
        <point_ru_name>Минск</point_ru_name>
        <point_ua_name>Мінськ</point_ua_name>
        <point_name>Минск</point_name>
        <country_name>Беларусь</country_name>
        <country_kod>BLR</country_kod>
        <country_kod_two>BY</country_kod_two>
        <country_id>4</country_id>
        <latitude>53.8911344853093</latitude>
        <longitude>27.5510821236877</longitude>
        <population>1836808</population>
        <point_name_detail>Минск, Минск ош, Минскай</point_name_detail>
    </item>
    <item>
        <point_id>3</point_id>
        <point_latin_name>Praha</point_latin_name>
        <point_ru_name>Прага</point_ru_name>
        <point_ua_name>Прага</point_ua_name>
        <point_name>Прага</point_name>
        <country_name>Чехия</country_name>
        <country_kod>CZE</country_kod>
        <country_kod_two>CZ</country_kod_two>
        <country_id>1</country_id>
        <latitude>50.0890963217133</latitude>
        <longitude>14.4405707716942</longitude>
        <population>1285000</population>
        <point_name_detail>Prag, Pràg, Prág, Prâg, prag, Praga, Prága, Prāga, praga, Pragae, Prago, Prague</point_name_detail>
    </item>
</root>";

//=========================================== end XML string ==========================================


function getCityInfo(array $parameter_set)
{
    $urlGetPoints="https://test-api.bussystem.eu/server/curl/get_points.php?";

        foreach ($parameter_set as $key=> $parmeter_value )
        {
            //echo $key."=".$parmeter_value."<br>";
            $urlGetPoints=$urlGetPoints."&".$key."=".$parmeter_value;
        }

        $urlGetPoints=str_ireplace("?&", "?", $urlGetPoints);

        echo"<br>". $urlGetPoints ."<hr>";

        $ch = curl_init();

    // установка URL и других необходимых параметров

        curl_setopt($ch, CURLOPT_URL, $urlGetPoints);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $body = curl_exec($ch);

    // завершение сеанса и освобождение ресурсов
        curl_close($ch);
    //echo "<br> jopta <br>";
        echo $body;
}

$parsingXML=new SimpleXMLElement($requestXMLString);

echo "<hr>";

foreach ($parsingXML->item as $item)
{
    echo"point_id=".$item->point_id."<br>";
    echo"point_latin_name=".$item->point_latin_name."<br>";
    echo"point_ru_name=".$item->point_ru_name."<br>";
    echo"point_ua_name=".$item->point_ua_name."<br>";
    echo"point_name=".$item->point_name."<br>";
    echo"country_name=".$item->country_name."<br>";
    echo"country_kod=".$item->country_kod."<br>";
    echo"country_kod_two=".$item->country_kod_two."<br>";
    echo"country_id=".$item->country_id."<br>";
    echo"latitude=".$item->latitude."<br>";
    echo"longitude=".$item->longitude."<br>";
    echo"population=".$item->population."<br>";
    echo"point_name_detail=".$item->point_name_detail."<br>";
    echo "<hr>";
}

getCityInfo($parameters);

?>
