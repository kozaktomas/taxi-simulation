<?php

class Taxi {

    /**
     * Name of taxi  
     * @var string
     */
    private $name;

    /**
     * Time left in minutes  
     * @var integer
     */
    private $timeLeft;

    /**
     * Distance left in km
     * @var integer    
     */
    private $distanceLeft;

    /**
     * Avarage speed[0] with standart deviation[1]
     * @var array
     */
    private $speed;

    /**
     * Where tax is?
     * @var Place|null
     */
    private $place;
    
    /**
     * Is car pakred on place    
     * @var boolean
     */         
    private $onRoad;

    public function __construct($name) {
        $this->name = trim($name);
        $this->distanceLeft = 0;
        $this->speed = array();
        $this->place = NULL;
        $this->onRoad = FALSE;
    }

    /**
     * One round
     * @param array $speed
     */
    public function round(array $speed) {
        if ($this->getDistanceLeft() !== 0) {
            $distance = gauss_random($speed[0], $speed[1]);
            $this->distanceLeft -= $distance / 60;
            if ($this->distanceLeft <= 0) {
                $this->distanceLeft = 0;
                $this->place = NULL;
                $this->onRoad = FALSE;
            }
        }
    }

    public function getName() {
        return $this->name;
    }

    public function getDistanceLeft() {
        return $this->distanceLeft;
    }

    public function setDistanceLeft($distanceLeft) {
        $this->distanceLeft = intval($distanceLeft);
    }

    public function getPlace() {
        return $this->place;
    }

    public function setPlace(Place $place) {
        $this->place = $place;
    }
    
    public function removePlace(){
      $this->place = NULL;
    }
    
    public function setOnRoad($b){
      $this->onRoad = $b;
    }
    
    public function getOnRoad(){
      return $this->onRoad;
    }

}