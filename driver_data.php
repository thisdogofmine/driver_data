<?php

require_once('class.trip.php');

// driver data input from file driver_data.txt
	// input a file specified in the command line? is this needed

// create global output array
	// total miles driven 
	// and average speed. 
	
$output = array();
//$output['<driver_name>'] = array('driver', 'miles', 'speed');
$valid_drivers = array();

if(!empty($argv[1])){
	$file = $argv[1];
}else{
	$file = 'driver_data.txt';
}

$contents = file($file);

foreach($contents as $row){
	// parse file 
		// space deliminated
		// 0 type: driver or trip
		// 1 driver name
		// 2 start time
		// 3 stop time
		// 4 miles driven
		
		// list of drivers
		// list of trips
	$vals = explode(' ', $row);
	
	// each line will start with <driver> or <trip>
		//ignore case
	if(strtoupper($vals[0]) == 'DRIVER'){
		$driver = trim($vals[1]);
		// if driver add driver to list of valid drivers
		$valid_drivers[] = $driver;
		//add to output array
		if(empty($output[$driver])){
			$output[$driver] = array();
			$output[$driver]['name'] = $driver;
			$output[$driver]['miles'] = 0.0;
			$output[$driver]['time'] = 0.0;
			$output[$driver]['speed'] = 0.0;
			$output[$driver]['trip_count'] = 0;
		}
	}elseif(strtoupper($vals[0]) == 'TRIP'){
		
		// if trip
		// Round miles and miles per hour to the nearest integer.
		
		//create object add properties based on parsed fields:
		$trip = new driver_trip();
		$trip->setDriver(trim($vals[1]));
		$trip->setStartTime(trim($vals[2]));
		$trip->setStopTime(trim($vals[3]));
		$trip->setMiles(trim($vals[4]));
		
		
		//the start time will always be before the end time
		if($trip->calculateTripTime()){
			if($trip->calculateSpeed()){
				// add to global output array
				$trip->populateOutput();
			}
		}
	}else{
		//anything else is a bad row
	}
}

//now need to average the speed
foreach ($output as $driver => $data) {
	
	$name = $data['name'];
	
	if($data['trip_count'] > 0 && $data['time'] > 0.0){
		$output[$name]['speed'] = $data['miles']/$data['time'];
	}
	$output[$name]['speed'] = round($output[$name]['speed'], 0);
	$output[$name]['miles'] = round($data['miles'], 0);
	
}

function build_sorter($key) {
	return function ($a, $b) use ($key) {
		return strnatcmp($b[$key], $a[$key]);
	};
}

//Sort the output by most miles driven to least.
usort($output, build_sorter('miles'));

//echo var_dump($valid_drivers);

$text = '';
foreach ($output as $driver => $data) {
	//verify driver is valid
	if(in_array($output[$driver]['name'], $valid_drivers)){
		$text .= $output[$driver]['name'].': '.$output[$driver]['miles'].' miles @ '.$output[$driver]['speed']." mph \r\n";
	}
}

file_put_contents('results.txt', $text );

?>