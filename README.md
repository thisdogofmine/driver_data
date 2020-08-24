# driver_data


#Please include a README with your submission describing your approach to solving the problem. 
	#Do not include your name or any personally identifiable information in your readme. 

#representative of code that you would write on a real project, including tests
 
#Package your code as 
	#a tarball (tar zcvf your-code.tgz your-code-dir) 
	#or a gitbundle (GIT_DIR=your-code-dir/.git git bundle create your-code.gitbundle --all)
#Send the file to us via the Dropbox link in the email we sent to you about this coding exercise

Problem Statement
Let's write some code to track driving history for people.

// The code will process an input file
	You can either choose to accept the input via stdin (e.g. if you're using Ruby cat input.txt | ruby yourcode.rb)
	or as a file name given on the command line (e.g. ruby yourcode.rb input.txt)
	You can use any programming language that you want
	Please choose a language that allows you to best demonstrate your programming ability.

// Each line in the input file will start with a command. 
	There are two possible commands.
		The first command is Driver, which will register a new Driver in the app. 
			Example: Driver Dan
		
		The second command is Trip, which will record a trip attributed to a driver. 
			The line will be space delimited 
			with the following fields:
				  the command (Trip)
				, driver name
				, start time
				, stop time
				, miles driven
			Times will be given in the format of hours:minutes
			We'll use a 24-hour clock
			will assume that drivers never drive past midnight
				(the start time will always be before the end time)
			Example:
				Trip Dan 07:15 07:45 17.3
			
			Discard any trips that average a speed of less than 5 mph 
				or greater than 100 mph.
			
Generate a report containing each driver with 
	total miles driven 
	and average speed. 
	Sort the output by most miles driven to least. 
	Round miles and miles per hour to the nearest integer.
	
Example input:
	
	Driver Dan
	Driver Lauren
	Driver Kumi
	Trip Dan 07:15 07:45 17.3
	Trip Dan 06:12 06:32 21.8
	Trip Lauren 12:01 13:16 42.0

Expected output:
	Lauren: 42 miles @ 34 mph
	Dan: 39 miles @ 47 mph
	Kumi: 0 miles

// Expectations and Evaluation Criteria
	demonstrate expertise with domain modeling and testing.
	We're interested in the thought process behind your choices
		so please take some time to capture that in your README.
	
	For example, you can represent your data using primitives, structs, or objects.
	We don't consider any one of those options better than the others.
	However, we expect you to make an intentional choice
	, implement it consistently
	, and communicate why you chose that approach.

// In general, we're looking for a little more structure than what the problem 
 actually necessitates. 
 Although we understand the principle of YAGNI and the desire to keep code simple
	, we didn't want to add so many requirements to this exercise that it'd take 
	a massive amount of time. 
	Don't go overboard with this — we don't want to see a complex overabundance of abstraction.
	We also don't want to see all of the code in a single function
		, even though this problem is simple enough to reasonably implement it that way.
	
// We'll be evaluating solutions on:
	object modeling / software design
	testing approach
	use of language idioms relative to expertise with that language
	thought process captured in the README
	
##########################################################

thoughts:
// normally I would dump the data into a database 
//	 and do the processing via triggers and SQL
	// better to have a copy of the data in the database for future/history
	// trigger to calculate the speed
	// sql query to generate the report
	// write a view to export the data
	// write a PHP script to query the view and case the output in a CSV
	// but this violates command line input/output and excessive code (going overboard)

// the simplest way would be to use an array to store each type row (driver/trip)
	// this doesn't model the data
	// should use a class to show data model

// alternatly I would create a web page to upload the import file,
//	 then have the export file downloaded
	// better user experience than command line
	// this is also excessive

So:
// a command line program
	// input a file specified in the command line
	
// parse file
	// space deliminated
	// list of drivers
	// list of trips
		  driver name
		, start time
		, stop time
		, miles driven
	// calculate speed
	
	
	
	
// model the data
	// class for driver and trip
		no - driver doesn't have enough purpose to be a seperate class. 
			list of drivers will be a class attribute for the trip class
			then we can compare trip driver to list to validate driver
			
	
	// process
		// check for issue:
			valid driver 
				- this is not specified, but clearly intended since we have a driver command
				- what if driver is added after trip?
					should be ok as long as driver is added at some point
			format: hours:minutes
			valid hours (1-24)
			valid minutes (0-59)
			
			the start time will always be before the end time
			ignore if average a speed less than 5 mph or greater than 100 mph.
			
average speed?
	so do we calculate speed per trip then average the speeds together 
	or
	add up all the miles and then divide by trip count?
	
option 1:
	// trip speeds are inde
	Trip Dan 07:15 07:45 17.3
	30min .5 hour
	17.3/.5 = 34.6 -- trip speed
	
	Trip Dan 06:12 06:32 21.8
	20min .33 hour
	21.8/.33 = 66.06 -- trip speed
	
	34.6 + 66.06 = 100.66 / 2(trips) = ave speed = 50.33 -0 round to 50mph
	
option 2:
	
	50 min .83 hour (total time)
	39.1 miles (total miles)
	39.1/.83 = 47.11 round to 47mph
	
example shows:
	Dan: 39 miles @ 47 mph

conclusion:
	I will follow what the example shows, but I don't know if this is right
	In a production environment I would question this with the user to verify we are using the correct calculation
	as this is a coding challenge(not a math challenge), I will just follow the example in the instructions
	
/end