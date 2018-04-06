<?php

/* 
	Ray Egan
	06/04/18
	GM Exercise Steps 1 - 3
*/

// step 1
// creating a new variable to hold xml dom
$dom = new DOMDocument;

// loading our data.xml file into the dom
$dom->load('postData.xml'); 

// finding the room name by searching for the xml tag 'SystemName'    
$roomName = $dom->getElementsByTagName('SystemName');
for ($i=0; $i<$roomName->length; $i++)
{
	// getting the first roomName element
	$item = $roomName->item($i);

	// setting the value to a variable
	$room = $item->nodeValue;
	//echo $room;
}

// finding the ip address by searching for the xml tag 'IPAddress'    
$ipAddress = $dom->getElementsByTagName('IPAddress');
for ($i=0; $i<$ipAddress->length; $i++)
{
	$item = $ipAddress->item($i);
	$ip = $item->nodeValue;
	//echo $ip;

}

// finding the hand status by searching for the xml tag 'Value'
$handStatus = $dom->getElementsByTagName('Value');
for ($i=0; $i<$handStatus->length; $i++)
{
	$item = $handStatus->item($i);
	$hand = $item->nodeValue;
	//echo $hand;
}

// setting timezone to Europe/Dublin
date_default_timezone_set("Europe/Dublin");

// getting current date
$date = date("d/m/y");

// getting current time
$time = strftime(date("h:i:sa"));

// creating a new file in root directory
$fileName = "data.txt";


// step 2
// opening the new file and writing csv data to it
$f = fopen($fileName, 'w');
fwrite($f, $date);
fwrite($f, ', ');
fwrite($f, $time);
fwrite($f, ', ');
fwrite($f, $room);
fwrite($f, ', ');
fwrite($f, $ip);
fwrite($f, ', ');
fwrite($f, $hand);

// closing file
fclose($f);


// step 3
// opening the text file created in step 2
$row = 1;
if (($f1 = fopen("data.txt", "r")) !== FALSE) 
{
    while (($data = fgetcsv($f1, 1000, ",")) !== FALSE) 
	{
        $num = count($data);
        
        $row++;
		
        for ($c=0; $c < $num; $c++) 
		{
			// checking for the hand status "up"
			// if it is found, a message is echoed to the screen
			if(strcasecmp(trim($data[$c]), 'up') == 0)
			{
				echo "ALERT: Somebody in " . $data[2] . " has their hand up";
			}
        }
		
    }
    fclose($f1);
}

?>