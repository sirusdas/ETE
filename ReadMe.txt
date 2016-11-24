By Sirus

This file contains description of what a specific file does and how the flow goes.

We have created a Email Tracking Engine using the REST based API which means there are basic 3 layers

1. The Client Side

2. The  Server Side 

3. The Database Side.

Using REST APT when the Client request for something from Track.php,
It is send gets the USER request using GET and then calls to a MAIN PAGE(index.php). Which contains MODE=tracker and other user info.
Using CURL POST request the index.php takes the input and routes it to the controller known as TrackerController() inside tracker.php
The controller checks what type of data is send from the client and then as per the specific request it call the tracker.post.php page function.
The tracker.post.php now talks with the Database class known as data.class.php to execute the request or send a respone in json.
  

Things to note:
1. Never invoke the database directly from anyhere except from the tracker.post.php
2. Never write code such as redirect into the core file only the file which the user call( Here its Track.php ) will have the redirect code.

<<<<<<<<<-----------THE BASIC WORKING----------->>>>>>>>>>>>>>>>>>
1. The system inserts a new row into the db and 
   gets its id encrypts and then sends it to the user in the mail with an image and urls which has this id's.
2. When the image gets automatically loaded. The image call a file known as track.php with this specific encrypted id.
	The track.php decrypts the id and then send the request as a POST again to the server with the URL and the true decrypted ID.
	Hence the true ID is never revealed, but for future we can make it a bit more secure too.
3. The index.php gets this request and analyses the paramater mode=tracker. Then it calls the specific controller to handle this request. 
4. The controller is in file tracker.php which check all the other paramaters of the post request and then call the specific method in the tracker.post.php
5. The tracker.post.php now calls the specific function in the data.class.php file to store this data.
Hence we now have some data.

Disaster Recover
Incase of dB down. Maintain a 2 log file. One for the data and the other for the error.