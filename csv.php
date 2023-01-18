<?php

$conn=mysqli_connect("localhost", "root", "", "test_db");
if(isset($_POST["import"])){

	$filename=$_FILES["file"]["tmp_name"];
	if($_FILES["file"]["size"]>0)

	{
		$file=fopen($filename, "r");
		while(($column=fgetcsv($file, '10000', ",")) !==FALSE){
			$sql="INSERT INTO  `csv`(`fname`, `lname`, `email`) VALUES('".$column[0]."', '".$column[1]."', '".$column[2]."')";
			$result=mysqli_query($conn, $sql);
			if(!empty($result)){
				echo "CSV data imported in database";

			} else {
				die(mysqli_error($conn));
			}
		}
	}
}


 if(isset($_POST["Export"])){
         
          header('Content-Type: text/csv; charset=utf-8');  
          header('Content-Disposition: attachment; filename=data.csv');  
          $output = fopen("php://output", "w");  
     
          fputcsv($output, array(`fname`, `lname`, `email`));  
          $query = "SELECT * from csv ORDER BY id DESC";  
          $result = mysqli_query($conn, $query);  
          while($row = mysqli_fetch_assoc($result))  
          {  
               fputcsv($output, $row);  
          }  
          fclose($output);  
     }  


 
?>






<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" ></script>

    <title>csv file</title>
  </head>
  <body>
    <h1>Hello, world!</h1>

    <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
    <div>
    	<label>
    		choose csv file
    	</label>
    	<input type="file" name="file" accept=".csv">
    	<button type="submit" name="import">Import</button>
      <button type="submit" name="Export">Export</button>
    </div>	



    </form>

    <?php

    $sqlselect="SELECT * from csv";
    $result=mysqli_query($conn, $sqlselect);
    ?>


    <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">id</th>
      <th scope="col">First</th>
      <th scope="col">Last</th>
      <th scope="col">Email</th>
    </tr>
  </thead>

  <?php


  while ($row=mysqli_fetch_array($result)) {
  	
  ?>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td><?php echo $row['id'];?></td>
      <td><?php echo $row['fname'];?></td>
      <td><?php echo $row['lname'];?></td>
       <td><?php echo $row['email'];?></td>
    </tr>
    


  </tbody>
<?php }?>
</table>


  </body>
</html>

