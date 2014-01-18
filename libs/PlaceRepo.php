<?php

class PlaceRepo {

    /**
     * List of places
     * @var array
     */
    private $data;

    public function __construct() {
        $this->data = array();
    }

    /**
     * Create Place entity
     * @param string $name
     * @param array $dis
     */
    public function createPlace($name, $dis) {
        $this->data[] = new Place($name, $dis);
    }

    /**
     * Assign free taxi to Place with the biggest count people
     * @param TaxiRepo $repo
     */
    public function assignFreeTaxis(TaxiRepo $repo) {
        foreach ($repo->getTaxis() as $key => $taxi) {
            if (($taxi->getDistanceLeft() === 0) && !($taxi->getPlace() instanceOf Place) ){
                $place = $this->mostPeople();
                $repo->getTaxis()[$key]->setPlace($place);
                $repo->getTaxis()[$key]->setOnRoad(FALSE);
                $place->addTaxi($repo->getTaxis()[$key]);
            }
        }
    }

    /**
     * Return place with biggest quelle
     * @return Place     
     */
    public function mostPeople() {
        $max = -1;
        $index = -1;
        foreach ($this->data as $key => $place) {
            if ($place->getPeople() > $max) {
                $max = $place->getPeople();
                $index = $key;
            }
        }
        if($this->data[$index]->getPeople() == 0 ){
          $min = 999999;
          foreach ($this->data as $key => $place) {
              if ($place->countTaxis() < $min) {
                  $min = $place->countTaxis();
                  $index = $key;
              }
          } 
        }
        return $this->data[$index];
    }

    /**
     * One round
     * @param integer $time Seconds from start
     * @param array $distance
     */
    public function round($time, $distance) {
        foreach ($this->data as $place) {
            $place->entrance($distance);
            $place->round($time); 
        }
    }

    /**
     * Return all places
     * @return array
     */
    public function getPlaces() {
        return $this->data;
    }

}

?>
