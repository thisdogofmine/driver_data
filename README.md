# driver_data

What to do:
#Please include a README with your submission describing your approach to solving the problem. 
	#Do not include your name or any personally identifiable information in your readme. 

 
#Package your code as 
	#a tarball (tar zcvf your-code.tgz your-code-dir) 
	#or a gitbundle (GIT_DIR=your-code-dir/.git git bundle create your-code.gitbundle --all)

#Send the file to us via the Dropbox link in the email we sent to you about this coding exercise


#Should be representative of code that you would write on a real project, including tests

________________________________________________________________________
Problem Statement: write code to track driving history for people.
	
	accept the input via stdin (e.g. if you're using Ruby cat input.txt | ruby yourcode.rb)
	or 
	as a file name given on the command line (e.g. ruby yourcode.rb input.txt)
	
_______________________________________________________________________________
Input file:
	run from command line:
		php driver_data.php <input_file> 
	If input file is omited, it will default to driver_data.txt in the same directory as the script
Output File:
	results.txt
	This will be placed in the same directory as the script.
	There is no specification of where to send the output file, so I left it with the script (Less complicated).
_______________________________________________________________________________

--Language:
	You can use any programming language that you want
	*Please choose a language that allows you to best demonstrate your programming ability.


I am using PHP as this is what I have the most experience with.


Details of request:
-- Each line in the input file will start with a command. 
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
			
--Generate a report containing each driver with 
	total miles driven 
	and average speed. 
	Sort the output by most miles driven to least. 
	Round miles and miles per hour to the nearest integer.
	
--Example input:
	
	Driver Dan
	Driver Lauren
	Driver Kumi
	Trip Dan 07:15 07:45 17.3
	Trip Dan 06:12 06:32 21.8
	Trip Lauren 12:01 13:16 42.0

--Expected output:
	Lauren: 42 miles @ 34 mph
	Dan: 39 miles @ 47 mph
	Kumi: 0 miles
_____________________________________________________________________________

Questions and assumptions:
	It is not specified that the Driver line must come before the Trip line. 
	Therefore I made it accept the driver as valid as long as the Driver line is in the file.
	
	Be sure to check for blank lines.
	
	Validate hours and minutes; 0-23, 0-59.
	Validate that start is before stop.
	Check for too low of too high speed; <5 or >100.
	Sort by Miles Driven.
	
_____________________________________________________________________________

Expectations and Evaluation Criteria
	demonstrate expertise with domain modeling and testing.
	We're interested in the thought process behind your choices
		so please take some time to capture that in your README.
	
	For example, you can represent your data using primitives, structs, or objects.
	We don't consider any one of those options better than the others.
	However, we expect you to make an intentional choice
	, implement it consistently
	, and communicate why you chose that approach.
	
# a little more structure than what the problem actually necessitates. 
# Don't go overboard with this — we don't want to see a complex overabundance of abstraction.
# We also don't want to see all of the code in a single function
	
We'll be evaluating solutions on:
	object modeling / software design
	testing approach
	use of language idioms relative to expertise with that language
	thought process captured in the README
	
##########################################################

Thoughts:
Normally I would dump the data into a database and do the processing via triggers and SQL.
	It is better to have a copy of the data in the database for future/history etc.
	Use a DB trigger to calculate the speed.
	Write a SQL query to generate the report.
	Save the query in a view to export the data.
	Write a short PHP script to query the view and output in a CSV/txt file.
	But this violates command line input/output and excessive code (going overboard).

The simplest way would be to use an array to store each type row (driver/trip) and do calculations on the array.
	This doesn't model the data and is too simplistic (per instructions).
	

Alternatly I would create a web page to upload the import file, then have the export file downloaded.
	This is a better user experience than command line.
	But this is also excessive.

So:
A command line program.
	Input a file specified in the command line.
		I wil also allow for a default file in case input file is omitted.
	
Parse file:
	Space deliminated
	List of drivers
	List of trips
	Driver name
	Start time
	Stop time
	Miles driven
	
Model the data
	Class for driver and trip
		No - driver doesn't have enough purpose to be a seperate class. 
			List of drivers can be captured in an array and validated before writing to file.  
			This allows for Driver line after Trip line.
	
PHP allows both procedurale and object oriented coding. You have the freedom to write 
it in whichever way works best for situation. So I am making use of this by writing the 
code in a mix of both. It is simple to follow and should show the advantages of the language and 
my familiarity with it. The Data model is a bit simple, but it is still more complex than the 
problem requires. But it should show the concepts.
	

Processing the data:
	Calculate speed per trip 
	Sum Miles driven per Driver
	Calculate average speed per Driver
	
	Check for issue:
		valid driver 
			- this is not specified, but clearly intended since we have a driver command
			- what if driver is added after trip?
				should be ok as long as driver is added at some point
		Time format: hours:minutes
		valid hours (1-23)
		valid minutes (0-59)
		
		The start time will always be before the end time. Requirments say not to worry about this. -- No need to check.
		Ignore if average a speed less than 5 mph or greater than 100 mph.
		Sort by miles driven.

Question about the Average speed?
	Do we calculate speed per trip then average the speeds together 
	or 
	add up all the miles and then divide by trip count? 

option 1:
	Trip Dan 07:15 07:45 17.3
	30min .5 hour
	17.3/.5 = 34.6 -- trip speed
	
	Trip Dan 06:12 06:32 21.8
	20min .33 hour
	21.8/.33 = 66.06 -- trip speed
	
	34.6 + 66.06 = 100.66 / 2(trips) = ave speed = 50.33 - round to 50mph

option 2:

	50 min .83 hour (total time)
	39.1 miles (total miles)
	39.1/.83 = 47.11 round to 47mph

example shows:
	Dan: 39 miles @ 47 mph

Conclusion:
	I will follow what the example shows (option 2), but I don't know if this is right. 
	In a production environment, I would question this with the user to verify we are using the 
	correct calculation. users often ask for things in a different way than they how they actually want it.
	A few minutes clarifying the request at the beginning of a project can save a lot of time and frustration
	at the end. It also builds a good relationship with the users. I find they bare usually happy to 
	answer such questions. Since this is a coding challenge(not a math challenge), I will just follow 
	the example in the instructions.
	
/end