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


$file = 'driver_data.txt';
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
	if(strtoupper($vals[0]) == 'DRIVER'){
		//ignore case
		$valid_drivers[] = $vals[1];
	}else{
		
		$trip = new driver_trip();
		
		
		
		
		
		
	}
}
	

	
		
		// if driver add driver to list of valid drivers
	
	// if trip
		//create object add properties based on parsed fields:
		
		//   driver name
		// , start time
		// , stop time
		// , miles driven
		
		// calculate speed
		// Round miles and miles per hour to the nearest integer.
		
		// add to global output array
		
		
	
// model the data
	// class for driver and trip
// 		no - driver doesn't have enough purpose to be a seperate class. 
// 			list of drivers will be a class attribute for the trip class
// 			then we can compare trip driver to list to validate driver
// 			
// 	
	// process
		// check for issue:
// 			valid driver 
// 				- this is not specified, but clearly intended since we have a driver command
// 				- what if driver is added after trip?
// 					should be ok as long as driver is added at some point
// 			format: hours:minutes
// 			valid hours (1-24)
// 			valid minutes (0-59)
// 			
// 			the start time will always be before the end time
// 			ignore if average a speed less than 5 mph or greater than 100 mph.


	// Sort the output by most miles driven to least. 



?>