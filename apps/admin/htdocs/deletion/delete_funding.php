<?php

	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres")
    or die('Could not connect: ' . pg_last_error());
	
	if ($_REQUEST['delete']) {
		
		$fundId = $_REQUEST['delete'];
		$query = 'UPDATE Trans 
					SET softDelete = TRUE
					WHERE transactionNo= '.$fundId.'	';
		$result = pg_query($query) or die('Query failed: ' . pg_last_error());
		
		if ($result) {
			echo "Funding Deleted Successfully ...";
		}
		
	}
?>