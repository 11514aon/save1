<?php
// connect to database
$hostName = "localhost";
$userName = "root";
$password = "";
$databaseName = "rfid";
$conn = new mysqli($hostName, $userName, $password, $databaseName);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Open the uploaded CSV file for reading
$handle = fopen('C:\xampp\htdocs\rfid\data\attendance.csv', 'r');

// Loop through the file and insert records into the database
while (($row = fgetcsv($handle, 0, ',')) !== false) {
    $date = $row[0];
    $time = $row[1];
    $tag = $row[2];
    $checkin_type = $row[3];
    $name = $row[4];

    // Check if a record with the same date, time, and tag already exists
    $query = "SELECT * FROM trainee WHERE date = '$date' AND time = '$time' AND tag = '$tag'";
    $result = $conn->query($query);

    if ($result->num_rows == 0) {
        // Insert the record into the database
        $query = "INSERT INTO trainee (date, time, tag, checkin_type, name) VALUES ('$date', '$time', '$tag', '$checkin_type', '$name')";
        $conn->query($query);
    }
}

fclose($handle);
error_reporting(0);
unlink('C:\xampp\htdocs\rfid\data\attendance.csv');
if (isset($_POST['id'])) {
   $id = $_POST['id'];
   $sql = "DELETE FROM trainee WHERE id = $id";
   
   if ($conn->query($sql) === TRUE) {
     // Record deleted successfully
   } else {
     echo "Error deleting record: " . $conn->error;
   }
 }


// Extract the filename from the uploaded CSV file path
$filename = basename('C:\xampp\htdocs\rfid\data\attendance.csv');

// Generate the output file path
$output_file_path = 'C:/xampp/htdocs/rfid/data/' . $filename;

// Export the data to the output CSV file
$query = "SELECT date, time, tag, checkin_type, name
          INTO OUTFILE '$output_file_path'
          FIELDS TERMINATED BY ',' 
          ENCLOSED BY '\"'
          LINES TERMINATED BY '\n'
          FROM trainee ;";
$conn->query($query);


//show data
$sql = "SELECT * FROM trainee";
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
</form>

</div>
   <table class="scrolldown">
      <thead>
         <tr>
            <th>Date</th>
            <th>Time</th>
            <th>ID tag</th>
            <th>Status</th>
            <th>Name</th>
            <th>Option</th>
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
            <td><form method="post">
            <input type="hidden" name="id" value="<?php echo $rows['id']; ?>">
            <button type="submit">Delete</button>
            </form>
            </td>
      </tr>
      <?php
                } 
            ?>
      </tbody>
    
   </table>
</body>   
</html>