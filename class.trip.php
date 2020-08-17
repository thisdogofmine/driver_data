<?php

class driver_trip {
	private $driver; //driver name
	private $start_time; // HH24:MM
	private $stop_time; // HH24:MM
	private $miles_driven;
	
	private $trip_time; // calculated from stop - start -- in hours (minutes/60)
	private $speed; // calculated speed in miles per hour
	
	public $valid_drivers = array(); //public so driver can be added during file parse
	
	
	public function __construct(){
		
	}
	
	//setters?
		// with so few items it seems pointless to have setters, but will add for demo purposes
	
	
	public function setDriver($driver){
		$this->driver = $driver;
	}
	
	public function setStartTime($start){
		$this->start_time = $start;
	}
	
	public function setStopTime($stop){
		$this->stop_time = $stop;
	}
	
	public function setMiles($miles){
		$this->miles_driven = $miles;
	}
	
	private function calculateTripTime(){
		//private since this is only called from calculate speed
			//no real need to be private, but also no need to be public
			//limit access when access is not needed
		
		//need to make times calculatable
			//convert to minutes
			//this is minutes past midnight - can't drive past midnight
			
		$start_parts = explode(':', $this->start_time);
		$start_minutes = $start_parts[0]*60 + $start_parts[1];
		
		$stop_parts = explode(':', $this->stop_time);
		$stop_minutes = $stop_parts[0]*60 + $stop_parts[1];
		
		// validate start is less than stop
		if($start_minutes > $stop_minutes){
			// start time must be before stop time
			return FALSE;
		}
		
		$this->trip_time = $stop_minutes - $start_minutes;
		
		//convert to hours
		$this->trip_time = $this->trip_time/60;
		return TRUE;
	}
	
	
	public function calculateSpeed(){
		
		if(!$this->calculateTripTime()){
			return FALSE;
		}
		//speed = distance/time - (miles/hour)
			//$this->miles_driven is provided in miles
			//$this->trip_time was calculated to hours
		$this->speed = $this->miles_driven/$this->trip_time;
		
		return TRUE;
	}
	
	public function populateOutput($output){
		//there are many ways to do this; use global =keyword, call by reference...
			//but why? this is simpler and easier to follow
		
		// output is
		//total miles driven (sum) 
		//average speed (ave)
		
		//see if driver name is already in array
		if(empty($output[$this->driver]) ){
			//if not create
			$output[$this->driver]['name'] = $this->driver;
			$output[$this->driver]['miles'] = $this->miles_driven;
			$output[$this->driver]['speed'] = $this->speed;
			$output[$this->driver]['trip_count'] = 1;
		}else{
			//else add values to existing array
			$output[$this->driver]['miles'] = $output[$this->driver]['miles'] + $this->miles_driven;
			//will average speed after processing all rows
			$output[$this->driver]['speed'] = $output[$this->driver]['speed'] + $this->speed;
			$output[$this->driver]['trip_count']++;
		}
		
		return $output;
	}
	

}
?>