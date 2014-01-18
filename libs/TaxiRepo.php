<?php

class TaxiRepo {

    /**
     * List of taxi
     * @var array
     */
    private $data;

    public function __construct() {
        $this->data = array();
    }

    /**
     * Create taxi entity
     * @param string $name
     * @param array $name [0] => mean; [1] => sd
     */
    public function createTaxi($name, $speed) {
        $this->data[] = new Taxi($name, $speed);
    }

    /**
     * Return all taxis
     * @return array
     */
    public function getTaxis() {
        return $this->data;
    }

    /**
     * One round of simalation
     * @param array $speed
     */
    public function round(array $speed) {
        foreach ($this->data as $taxi) {
            $taxi->round($speed);
        }
    }

}

?>
