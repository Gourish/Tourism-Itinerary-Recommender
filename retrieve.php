<?php
	extract($_GET);
	//echo $category;

	$conn = mysql_connect('127.0.0.1','root','');
	if(!$conn)
	{	
		die("Could not connect to database server");
	}

	$db = mysql_select_db('test1');
	if(!$db)
	{
		die("Could not select database");
	}
	$temp = explode(";",$category,-1);
	$ids = join("','",$temp); 
	$query = "SELECT p.place_name, p.latitude, p.longitude, p.url,p.rating,p.review,p.avg_time FROM place AS p, category AS c, placeToCategory AS pc WHERE p.place_id = pc.place_id AND c.category_id = pc.category_id AND c.category_name IN ('$ids') GROUP BY p.place_name ORDER BY p.rating DESC, p.review DESC;";


	$results = mysql_query($query);
	if(!$results)
	{
		die("Problem in querying.." . mysql_error());
	}

	/*
	$found = false;
	while($row = mysql_fetch_array($results,MYSQL_ASSOC))
	{
		$found = true;
		echo "<ul>";
		foreach($row as $key=>$value)
		{
			echo "<li>";
			echo $key;
			echo $value;
			echo "</li>";
		}
		echo "</ul>";
	}*/


	$toSend = array();
	$found = false;
	while($row = mysql_fetch_array($results,MYSQL_ASSOC))
	{
		$found = true;
		$toSend[] = $row;
	}
	echo json_encode(array('place' =>$toSend));
	if(!$found)
	{
		//echo '<h2>NO RESULTS..SORRY :( </h2>';
	}
?>