<!DOCTYPE html>
<html>
<head>
	<title>Vehicle Information</title>
</head>
<body>
	<h1>Enter Vehicle Registration Number</h1>
	<form action="get_vehicle_info.php" method="post">
		<label for="reg_num">Registration Number:</label>
		<input type="text" id="reg_num" name="reg_num">
		<label for="post_code">Postcode:</label>
		<input type="text" id="post_code" name="post_code">
		<input type="submit" value="Get Information">
	</form>
</body>
</html>
