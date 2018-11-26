<?php
    try{
        $client = new SoapClient('https://www.cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL');
        date_default_timezone_set ('Europe/Moscow');
        $dateForAPI = date('Y-m-d').'T'.date('H:i:s');
        $dateForPeople = date('Y-m-d H:i:s');
        $result = $client->GetCursOnDateXML(['On_date'=>$dateForAPI])->GetCursOnDateXMLResult->any;
        $sxml = simplexml_load_string($result);

    } catch (SoapFault $e) {
        echo $e->getMessage();
    }
    echo '<br>';
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Курсы валют</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="main.css">
    </head>
    <body>
        <h1>Курс Центробанка на <?=$dateForPeople?></h1>
        <table>
            <tr>
                <th>Валюта</th>
                <th>Букв.код</th>
                <th>Единиц</th>
                <th>Курс</th>
            </tr>
                <?php
                    foreach ($sxml as $item) {
                        echo '<tr>';
                        echo '<td>' . $item->Vname . '</td>';
                        echo '<td>' . $item->VchCode . '</td>';
                        echo '<td>' . $item->Vnom . '</td>';
                        echo '<td>' . $item->Vcurs . '</td>';
                        echo '</tr>';
                    }
                ?>
        </table>
    </body>
</html>