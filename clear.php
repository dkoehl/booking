<?php


$file = file_get_contents('guest.txt');
$lineArray = explode(PHP_EOL, $file);
$check = [];
$houseNameArray = [
    'S' => 'Haus Süd',
    'N' => 'Haus Nord',
    'O' => 'Haus Ost',
    'W' => 'Haus West',
];
$floorArray = [
    '0' => 'EG',
    '1' => 'OG 1',
    '2' => 'OG 2',
    '3' => 'OG 3',
    '4' => 'OG 4',
    '5' => 'OG 5',
];
foreach ($lineArray as $line) {

    $data = substr(trim($line), 0, -1);
    $dataArray = explode(',', str_replace([',', ')', '(', "'"], [], $data));
    $singleValues = explode(' ', $dataArray[0]);
    $houseArray = explode('.', $singleValues[1]);

    if (in_array($singleValues[1], $check) || empty($singleValues[1])) {
        continue;
    }
    $floor = $singleValues[0];
    $name = 'Room: ' .$houseArray[2];
    $house = $houseNameArray[$houseArray[1]];


    $check[] = $singleValues[1];

//    `name`, `floor`, `house`, `hidden`, `deleted`, `crdate`, `tstamp`
//    (1,'0.O.01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
    echo "('" . $name . "', '" . $floorArray[$floor] . "', '" . $house . "',NULL,NULL,NULL,NULL)," . '<br>';


//    echo $data . '<br>';
}