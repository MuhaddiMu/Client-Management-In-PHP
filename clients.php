<?php
session_start();

if (!$_SESSION['LoggedInUser']) {
	header("Location: index.php");
}

include ('includes/connection.php');

$Query = "SELECT * FROM Clients";
$Result = mysqli_query($Connection, $Query);

if (isset($_GET['alert'])) {
	if ($_GET['alert'] == 'Success') {
		$AlertMsg = "<div class = 'alert alert-success'>New Client Added in Database.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
	elseif ($_GET['alert'] == 'UpdateSuccess') {
		$AlertMsg = "<div class = 'alert alert-success'>Client Updated Successfully.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
	elseif ($_GET['alert'] == 'Deleted') {
		$AlertMsg = "<div class = 'alert alert-success'>Client Deleted Successfully.<a class='close' data-dismiss='alert'>&times;</a></div>";
	}
}

mysqli_close($Connection);
include ('includes/header.php');

?>

<h1>Client Address Book</h1>

<?php
echo $AlertMsg; ?>

<table class="table table-striped table-bordered">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Company</th>
        <th>Notes</th>
        <th>Edit</th>
    </tr>
    
    <?php

if (mysqli_num_rows($Result) > 0) {
	while ($Row = mysqli_fetch_assoc($Result)) {
		echo "<tr>";
		echo "<td>" . $Row['Name'] . "</td><td>" . $Row['Email'] . "</td><td>" . $Row['Phone'] . "</td><td>" . $Row['Address'] . "</td><td>" . $Row['Company'] . "</td><td>" . $Row['Notes'] . "</td>";
		echo '<td><a href="edit.php?ID=' . $Row['ID'] . ' "type="button" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-edit"></i> </a></td>';
		echo "</tr>";
	}
}
else {
	echo "<div class='alert alert-warning'>You have no Clients yet. </div>";
}

mysqli_close($Connection);
?>
    
    <tr>
        <td colspan="7"><div class="text-center"><a href="add.php" type="button" class="btn btn-sm btn-success"><span class="glyphicon glyphicon-plus"></span> Add Client</a></div></td>
    </tr>
</table>

<?php
include ('includes/footer.php');

?>