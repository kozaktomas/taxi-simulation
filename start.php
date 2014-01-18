<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>Simulace</title>
  </head>
  <body>
<div style="background-color: #DDD; border: #AAA 1px solid; padding: 5px; margin-bottom: 10px;">
U míst je evidováno, kolik v danou chvíli čeká na taxi skupin (kolikrát musí taxi jet)<br />
U taxi je evidován zbývající počet kilometrů
</div>

<?php
$libs = dirname(__FILE__) . '/libs';
include dirname(__FILE__) . '/function.php';
include $libs . '/Taxi.php';
include $libs . '/Place.php';
include $libs . '/PlaceRepo.php';
include $libs . '/TaxiRepo.php';

$speed = array(80, 40);
$distance = array(40, 75);
$taxi_count = intval(15);
$place_repo = new PlaceRepo();
$taxi_repo = new TaxiRepo();

$places = array(
    array(array('mean' => 14, 'sd' => 9), array('mean' => 15, 'sd' => 8), array('mean' => 12, 'sd' => 4), array('mean' => 19, 'sd' => 17), array('mean' => 12, 'sd' => 4), array('mean' => 3, 'sd' => 1)),
    array(array('mean' => 3, 'sd' => 22), array('mean' => 7, 'sd' => 17), array('mean' => 13, 'sd' => 7), array('mean' => 21, 'sd' => 7), array('mean' => 26, 'sd' => 14), array('mean' => 1, 'sd' => 1)),
);

foreach ($places as $key => $p) {
    $place_repo->createPlace($key, $p);
}
unset($places);

for ($i = 0; $i < $taxi_count; $i++) {
    $taxi_repo->createTaxi($i, $speed);
}


echo "<table border='1' cellpadding='2'>";
echo "<tr>";
echo "<th>Čas</th>";
foreach ($place_repo->getPlaces() as $place) {
    echo "<th>" . $place->getName()  . ". místo</th>";
}
foreach ($taxi_repo->getTaxis() as $taxi) {
    echo "<th>" . $taxi->getName() . ". taxi</th>";
}
echo "</tr>";
echo "</tr>";

for ($i = 1; $i < (60 * 12); $i++) {
    echo "<tr>";
    $ts = 64800 + 18000 + 25200 - 3600;
    echo "<td>" . date('h:i', $ts + ($i*60)) . "</td>";
    foreach ($place_repo->getPlaces() as $place) {
        echo "<td style='background-color: #7F7'>" . $place->getPeople() . " (+ " . $place->getNewpeople() . ")</td>";
    }
    foreach ($taxi_repo->getTaxis() as $taxi) {
        $text = " style='background-color: #77F'";
        if($taxi->getDistanceLeft() == 0){
            $text = " style='background-color: #DDD'";
        }
        echo "<td$text>" . round($taxi->getDistanceLeft(), 2) . " km</td>";
    }
    echo "</tr>";

    $place_repo->assignFreeTaxis($taxi_repo);
    $place_repo->round($i, $distance);
    $taxi_repo->round($speed);
    
}
echo "</table>";

?>



  </body>
</html>
