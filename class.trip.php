<?php

class driver_trip {
	private $driver; //driver name
	private $start_time; // HH24:MM
	private $stop_time; // HH24:MM
	private $miles_driven;
	
	private $trip_time; // calculated from stop - start -- in hours (minutes/60)
	private $speed; //calculated speed in miles per hour 
	
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
	
	public function calculateTripTime(){
		//need to make times calculatable
			//convert to minutes
			//this is minutes past midnight - can't drive past midnight
			
		$start_parts = explode(':', $this->start_time);
		$stop_parts = explode(':', $this->stop_time);
		
		//validate times are valid
		//valid hours (1-23)
		//valid minutes (0-59)
		
		if($start_parts[0] > 23
		|| $start_parts[1] > 59
		|| $stop_parts[0] > 23
		|| $stop_parts[1] > 59){
			return FALSE;
		}
		
		$start_minutes = $start_parts[0]*60 + $start_parts[1];
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
		//need this to ensure speed is greater than 5mph
		
		//speed = distance/time - (miles/hour)
			//$this->miles_driven is provided in miles
			//$this->trip_time was calculated to hours
		
		$miles = floatval($this->miles_driven);
		$time = floatval($this->trip_time);
		
		if($time > 0){
			$this->speed = $miles/$time;
		}else{
			$this->speed = 0;
		}
		
		return TRUE;
	}
	
	public function populateOutput(){
		//there are many ways to do this; but why? this is simpler and easier to follow
		global $output;
		
		// output is
			//total miles driven (sum) 
			//average speed (ave)
		
		//Discard any trips that average a speed of less than 5 mph 
			//or greater than 100 mph.
		if($this->speed < 5.0 || $this->speed > 100.00){
			return FALSE;
		}
		
		//see if driver name is already in array
		if(empty($output[$this->driver]['name']) ){
			//if not create
			$output[$this->driver]['name'] = $this->driver;
			$output[$this->driver]['miles'] = floatval($this->miles_driven);
			$output[$this->driver]['time'] = floatval($this->trip_time);
			$output[$this->driver]['trip_count'] = 1;
			$output[$this->driver]['speed'] = 0.0;
		}else{
			//else add values to existing array
			$output[$this->driver]['name'] = $this->driver;
			$output[$this->driver]['miles'] = floatval($output[$this->driver]['miles'] + floatval($this->miles_driven));
			$output[$this->driver]['time'] = floatval($output[$this->driver]['time'] + floatval($this->trip_time));
			$output[$this->driver]['trip_count']++;
			//will average speed after processing all rows
			$output[$this->driver]['speed'] = 0.0;
		}
		return TRUE;
	}

}
?>