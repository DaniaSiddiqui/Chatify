<?php
if (isset($_POST['submit']) && $_POST['msg'] != '') {
	$host = "127.0.0.1";
	$port = 80811;
	$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die('Not Created');
	socket_connect($socket, $host, $port) or die('Not connect');
	$msg = $_POST['msg'];
	    
	// do{
	// 	socket_write($socket, $msg, strlen($msg));
	// 	$reply = socket_read($socket, 1024);
	// 	$reply = trim($reply);
	// 	echo $reply;
	// }    
	// while(true);
	try {
		do {
			// Send the message to the server
			socket_write($socket, $msg, strlen($msg));
	
			// Read the reply from the server
			$reply = socket_read($socket, 1024);
	
			// Check if the server closed the connection
			if ($reply === false) {
				echo "Server closed the connection.";
				break;
			}
	
			// Trim any whitespace from the reply
			$reply = trim($reply);
	
			// Display the server's reply
			echo $reply . PHP_EOL;
	
		} while (true);
	
		// Close the socket when communication is done
		socket_close($socket);
	
	} catch (Exception $e) {
		// Handle any exceptions that may occur during communication
		echo "Error: " . $e->getMessage();
	}
}
?>
<form method="post">
	<input type="text" name="msg">
	<input type="submit" name="submit">
</form>