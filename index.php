<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "delivery";

	$conn = new mysqli($servername, $username, $password, $dbname);
	mysqli_set_charset($conn, "utf8");

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	function getList($table){
		if (isset($table) && $table->num_rows > 0){
			while ($row = $table->fetch_assoc()){
				echo '<option value="' . $row['content'] . '">';
			}
		}
	}
?>
<html>
<head>
	<title>Rice Noodle</title>
	<script type="text/javascript" src="js/jquery.min.js"></script>
	<script type="text/javascript" src="js/tether.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/bootstrap.min.css" />
	<style>
		input{
			min-width: 100px;
		}
		.table td, .table th {
			padding: 0.25rem;
		}
	</style>
	<script type="text/javascript">
		function copyRec(tableName, colNum){
			$selector = tableName + ' tr:eq(' + (colNum + (tableName == '#todayTable' ? 2 : 1)) + ')';
			$('#name').val($(selector + ' td:eq(0)').text());
			$('#soup').val($(selector + ' td:eq(1)').text());
			$('#noodle').val($(selector + ' td:eq(2)').text());
			$('#extra').prop( "checked", $(selector + ' td:eq(3) input').prop('checked'));
			$('#food1').val($(selector + ' td:eq(4)').text());
			$('#food2').val($(selector + ' td:eq(5)').text());
			$('#food3').val($(selector + ' td:eq(6)').text());
			$('#food4').val($(selector + ' td:eq(7)').text());
			$('#remarks').val($(selector + ' td:eq(8)').text());
		}
		function delRec(id){
			$('#deleteID').val(id);
			$('#myForm').submit();
		}
		function validateForm1(){
			return $('#callerName').val() != "";
		}
		function validateForm2(){
			return $('#name').val() != "";
		}
	</script>
</head>
<body>
<div class="container">
<div style="display:none">
<?php
	$deletion = false;
	if (isset($_POST["submitCaller"])){
		$sql = "INSERT INTO noodlecaller (name, ip) VALUES";
		$sql .= "('" . $_POST['callerName'] . "', '" . $_SERVER['REMOTE_ADDR'] . "')";
		echo $sql;
		$conn->query($sql);
	} else if (isset($_POST['deleteID']) && $_POST['deleteID'] != ''){
		$deletion = true;
		$sql = "UPDATE noodleorder SET cxl = 1, cxldate = CURRENT_TIMESTAMP, cxlip = '" . $_SERVER['REMOTE_ADDR'] . "' WHERE id = " . $_POST["deleteID"];
		echo $sql;
		$conn->query($sql);
	} else if (isset($_POST['submitOrder'])){
		$sql = "INSERT INTO noodleorder (name, createip, soup, noodle, extra, food1, food2, food3, food4, remarks) VALUES";
		$sql .= "('" . $_POST['name'] . "', '" . $_SERVER['REMOTE_ADDR'] . "', '" . $_POST['soup'] . "', '" . $_POST['noodle']
		 . "', " . (isset($_POST['extra']) ? "1" : "0") . ", '" . $_POST['food1'] . "', '" . $_POST['food2'] . "', '" . $_POST['food3']
		  . "', '" . $_POST['food4'] . "', '" . $_POST['remarks'] . "')";
		echo $sql;
		$conn->query($sql);
	}
?>
</div>
<form id="myForm" method="POST">
<?php
	$sql = "SELECT * FROM noodlecaller WHERE DATE(CURRENT_TIMESTAMP) = DATE(createDate)";
	$result = $conn->query($sql);

	$responsible = $result->num_rows > 0;
	$name = "";
	if ($responsible){
	    $row = $result->fetch_assoc();
	    $name = $row["name"];
	}
?>
	<div class="row">
		<div class="form-group col-md-6">
			<label for="callerDate">Date: </label>
			<input type="text" class="form-control" name="callerDate" id="callerDate"  value="<?php echo date("d-m-Y"); ?>" disabled/>
		</div>
		<div class="form-group col-md-6">
			<label for="callerName">Order By: </label>
			<input type="text" class="form-control" name="callerName" id="callerName" value="<?php echo $name ?>" <?php if ($responsible) { echo 'disabled'; } ?>/>
		</div>
		<?php if(! $responsible){?>
		<div class="form-group col-md-12" style="width:100%;text-align:right">
			<input type="hidden" name="submitCaller" id="submitCaller" value="true" />
			<button class="btn btn-success" type="submit" onclick="return validateForm1()">Submit</button>
		</div>
		<?php } ?>
	</div>
	<?php if ($responsible) { ?>
	<div class="row">
	<div class="col-md-12">
	<input type="hidden" name="submitOrder" id="submitOrder" value="true" />
	<input type="hidden" name="deleteID" id="deleteID" value="" />
	<table id="todayTable" class="table table-striped">
	<thead>
	<tr>
		<th>名</th>
		<th>湯</th>
		<th>麵</th>
		<th>加底</th>
		<th>餸1</th>
		<th>餸2</th>
		<th>餸3</th>
		<th>餸4</th>
		<th style="min-width:250px" >備註</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<tr id="editRow">
		<td><input type="text" class="form-control" id="name" name="name" list="nameList" <?php echo $deletion?"value=\"".$_POST['name']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="soup" name="soup" list="soupList" <?php echo $deletion?"value=\"".$_POST['soup']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="noodle" name="noodle" list="noodleList" <?php echo $deletion?"value=\"".$_POST['noodle']."\"":""?> /></td>
		<td><input type="checkbox" class="form-control" id="extra" name="extra" <?php echo $deletion&&isset($_POST['extra'])?"checked":"" ?> /></td>
		<td><input type="text" class="form-control" id="food1" name="food1" list="foodList" <?php echo $deletion?"value=\"".$_POST['food1']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="food2" name="food2" list="foodList" <?php echo $deletion?"value=\"".$_POST['food2']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="food3" name="food3" list="foodList" <?php echo $deletion?"value=\"".$_POST['food3']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="food4" name="food4" list="foodList" <?php echo $deletion?"value=\"".$_POST['food4']."\"":""?> /></td>
		<td><input type="text" class="form-control" id="remarks" name="remarks" list="remarksList" <?php echo $deletion?"value=\"".$_POST['remarks']."\"":""?> /></td>
		<td><button class="btn btn-success" type="submit" onclick="return validateForm2()">Submit</button></td>
	</tr>
	<?php
		$sql = "SELECT * FROM noodleorder WHERE DATE(CURRENT_TIMESTAMP) = DATE(createDate) and cxl = 0";
		$result = $conn->query($sql);
		$i = 0;
		while ($row = $result->fetch_assoc()){
	?>
	<tr>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['soup']; ?></td>
		<td><?php echo $row['noodle']; ?></td>
		<td><input type="checkbox" id="extra" name="extra" <?php echo $row['extra'] == 1 ? 'checked' : '' ?> disabled/></td>
		<td><?php echo $row['food1']; ?></td>
		<td><?php echo $row['food2']; ?></td>
		<td><?php echo $row['food3']; ?></td>
		<td><?php echo $row['food4']; ?></td>
		<td><?php echo $row['remarks']; ?></td>
		<td>
			<button type="button" class="btn btn-info" onclick="copyRec('#todayTable', <?php echo $i ?>); return false;">Copy</button>
			<button class="btn btn-danger" onclick="delRec(<?php echo $row['id'] ?>); return false;">Delete</button>
		</td>
	</tr>
	<?php 
		$i++;
	} 
	?>
	</tbody>
	</table>
	<datalist id="nameList">
	<?php
		$result = $conn->query('SELECT DISTINCT name AS content FROM noodleorder where cxl = 0');
		getList($result);
	?>
	</datalist>
	<datalist id="soupList">
	<?php
		$result = $conn->query('SELECT DISTINCT soup AS content FROM noodleorder where cxl = 0');
		getList($result);
	?>
	</datalist>
	<datalist id="noodleList">
	<?php
		$result = $conn->query('SELECT DISTINCT noodle AS content FROM noodleorder where cxl = 0');
		getList($result);
	?>
	</datalist>
	<datalist id="foodList">
	<?php
		$sql = 'SELECT DISTINCT food1 AS content FROM noodleorder where cxl = 0';
		$sql .= ' UNION SELECT DISTINCT food2 AS content FROM noodleorder where cxl = 0';
		$sql .= ' UNION SELECT DISTINCT food3 AS content FROM noodleorder where cxl = 0';
		$sql .= ' UNION SELECT DISTINCT food4 AS content FROM noodleorder where cxl = 0';
		$result = $conn->query($sql);
		getList($result);
	?>
	</datalist>
	<datalist id="remarksList">
	<?php
		$result = $conn->query('SELECT DISTINCT remarks AS content FROM noodleorder where cxl = 0');
		getList($result);
	?>
	</datalist>
	</div>
	</div>
	<?php
		$sql = "SELECT * FROM noodleorder WHERE DATEDIFF(createDate, CURRENT_TIMESTAMP) > 1 AND DATEDIFF(createDate, CURRENT_TIMESTAMP) <= 5 AND cxl = 0 ORDER BY name, createDate desc";
		$result = $conn->query($sql);
		$i = 0;
	?>
	<?php
		if ($result->num_rows > 0){
	?>
	<div class="row">
	<div class="col-md-12">
	Previous Orders:
	<table id="prevTable" class="table table-striped">
	<thead>
	<tr>
		<th>名</th>
		<th>湯</th>
		<th>麵</th>
		<th>加底</th>
		<th>餸1</th>
		<th>餸2</th>
		<th>餸3</th>
		<th>餸4</th>
		<th style="min-width:250px" >備註</th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php
		while ($row = $result->fetch_assoc()){
	?>
	<tr>
		<td><?php echo $row['name']; ?></td>
		<td><?php echo $row['soup']; ?></td>
		<td><?php echo $row['noodle']; ?></td>
		<td><input type="checkbox" id="extra" name="extra" <?php echo $row['extra'] == 1 ? 'checked' : '' ?> disabled/></td>
		<td><?php echo $row['food1']; ?></td>
		<td><?php echo $row['food2']; ?></td>
		<td><?php echo $row['food3']; ?></td>
		<td><?php echo $row['food4']; ?></td>
		<td><?php echo $row['remarks']; ?></td>
		<td>
			<button type="button" class="btn btn-info" onclick="copyRec('#prevTable', <?php echo $i ?>); return false;">Copy</button>
		</td>
	</tr>
	<?php 
		$i++;
	} 
	?>
	</tbody>
	</table>
	</div>
	</div>
	<?php 
		}	//of if(has previous) 
	?>
	<?php 
		}	//of if(responsible) 
	?>
	
</form>
</div>
</body>
<?php
	$conn->close();
?>
</html>
