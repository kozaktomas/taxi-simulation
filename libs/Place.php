<?php

class Place {

    /**
     * Name of place
     * @var string $name
     */
    private $name;

    /**
     * Distribution of poisson in array structure
     * [0] => 18 - 20
     * [1] => 20 - 22
     * [2] => 22 - 24
     * [3] => 0 - 2
     * [4] => 2 - 4
     * [5] => 4 - 6
     * Each of item in array contains array of ['mean', 'sd'] ; SD => Standard deviation
     * @var array
     */
    private $distribution;

    /**
     * Count of people
     * @var integer
     */
    private $people;

    /**
     * Structure of avaible taxis
     * @var array
     */
    private $taxis;

    /**
     * Count of new people
     * @var integer
     */
    private $new_people;

    /**
     * Index of new people
     * @var float
     */
    private $peopleIndex;

    /**
     * 
     * @param string $name
     * @param array $dis
     */
    public function __construct($name, array $dis) {
        $this->name = trim($name);
        $this->distribution = $dis;
        $this->people = 0;
        $this->taxis = array();
        $this->new_people = 0;
        $this->peopleIndex = 0;
    }

    /**
     * One round of simulation
     * @param integer $time
     */
    public function round($time) {
        $index = time_index($time);
        $newPeople = abs(gauss_random($this->distribution[$index]['mean'], $this->distribution[$index]['sd']));
        $this->peopleIndex += $newPeople / 60;
        $this->new_people = abs(floor($this->peopleIndex));
        $this->peopleIndex -= $this->new_people;
        $this->people += $this->new_people;
    }

    /**
     * Entrance to taxi
     * @param array $distance
     */
    public function entrance(array $distance) {
        if ($this->people > 0 && (count($this->taxis) > 0)) {
            $taxi = array_shift($this->taxis);
            if(!$taxi->getOnRoad()){
              $taxi->setDistanceLeft(abs(gauss_random($distance[0], $distance[1])));
              $taxi->removePlace();
              $this->people--;
              $this->entrance($distance);  
            }          
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getPeople() {
        return $this->people;
    }

    public function addTaxi(Taxi $taxi) {
        $this->taxis[] =  $taxi;
    }

    public function getNewpeople() {
        return $this->new_people;
    }
    
    public function countTaxis(){
      return count($this->taxis);
    }

}
