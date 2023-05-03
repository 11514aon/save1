<?php

$search = $_POST['search'];
$column = $_POST['column'];

$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "rfid";
 $conn = new mysqli($hostName, $userName, $password, $databaseName);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from trainee where $column like '%$search%'";

$result = $conn->query($sql);

$conn->close();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="/rfid2/checkin_out.css">
   <title>Trainee Timestamp</title>
</head>
<body>
<h1>Trainee Timestamp</h1>
<div class="search">
<form action="search.php" method="post">
    Search <input type="text" name="search">
    Column: <select name="column">
	<option value="date">Date</option>
	<option value="time">Time</option>
	<option value="tag">Tag</option>
    <option value="checkin_type">Checkin_type</option>
	<option value="name">Name</option>
	</select>
<input type ="submit">
<input type="reset">
</div>
   <table class="scrolldown">
      <thead>
         <tr>
            <th>Date</th>
            <th>Time</th>
            <th>ID tag</th>
            <th>Status</th>
            <th>Name</th>
         </tr>
      </thead>
    
      <tbody>
      <?php
                // LOOP TILL END OF DATA
                while($rows=$result->fetch_assoc())
                {
            ?>  
      <tr>
            <td><?php echo $rows['date'];?></td>
            <td><?php echo $rows['time'];?></td>
            <td><?php echo $rows['tag'];?></td>
            <td class="<?php echo $rows['checkin_type'] === 'check-in' ? 'checkin-in' : 'checkin-out'; ?>"><?php echo $rows['checkin_type'];?></td>
            <td><?php echo $rows['name'];?></td>
      </tr>
      <?php
                } 
            ?>
      </tbody>
    
   </table>
</body>   
</html>