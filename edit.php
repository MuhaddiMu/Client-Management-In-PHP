<?php
session_start();

if (!$_SESSION['LoggedInUser']) {
	header("Location: index.php");
}

include ("includes/functions.php");

include ("includes/connection.php");

$ClientID = $_GET['ID'];
$Query = "SELECT * FROM Clients WHERE ID = '$ClientID'";
$Result = mysqli_query($Connection, $Query);

if (mysqli_num_rows($Result) > 0) {
	while ($Row = mysqli_fetch_assoc($Result)) {
		$ClientName = $Row['Name'];
		$ClientEmail = $Row['Email'];
		$ClientPhone = $Row['Phone'];
		$ClientAddress = $Row['Address'];
		$ClientCompany = $Row['Company'];
		$ClientNotes = $Row['Notes'];
	}
}
else {
	$AlertMSG = "<div class='alert alert-warning'>Nothing to see here. <a href='clients.php'>Head Back</a></div> ";
}

if (isset($_POST['Update'])) {
	$ClientName = ValidateFormData($_POST['ClientName']);
	$ClientEmail = ValidateFormData($_POST['ClientEmail']);
	$ClientPhone = ValidateFormData($_POST['ClientPhone']);
	$ClientAddress = ValidateFormData($_POST['ClientAddress']);
	$ClientCompany = ValidateFormData($_POST['ClientCompany']);
	$ClientNotes = ValidateFormData($_POST['ClientNotes']);
	$Query = "UPDATE Clients 
                    SET Name     = '$ClientName',
                        Email    = '$ClientEmail',
                        Phone    = '$ClientPhone',
                        Address  = '$ClientAddress',
                        Company  = '$ClientCompany',
                        Notes    = '$ClientNotes' WHERE ID = '$ClientID'";
	$Result = mysqli_query($Connection, $Query);
	if ($Result) {
		header("Location: clients.php?alert=UpdateSuccess");
	}
	else {
		echo "Error Updating Record: " . mysqli_error($Connection);
	}
}

if (isset($_POST['Delete'])) {
	$AlertMSG = "<div class='alert alert-danger'> 
                    <p>Are you sure you want to Delete this client? No take back!</p><br />
                    <form action ='" . htmlspecialchars($_SERVER['PHP_SELF']) . "?ID=$ClientID' method='post' >
                        <input type = 'submit' class='btn btn-danger btn-sm' name='confirm-delete' value='Yes, Delete!'> 
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert'>Oops, No Thanks!</a>
                    </form>    
        </div>";
}

if (isset($_POST['confirm-delete'])) {
	$Query = "DELETE FROM Clients WHERE ID = '$ClientID'";
	$Result = mysqli_query($Connection, $Query);
	if ($Result) {
		header("Location: clients.php?alert=Deleted");
	}
	else {
		echo "Error Updating Record: " . mysqli_error($Connection);
	}
}

mysqli_close($Connection);
include ('includes/header.php');

?>

<h1>Edit Client</h1>
<?php
echo $AlertMSG; ?>
<form action="<?php
echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?ID=<?php
echo $ClientID; ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name</label>
        <input type="text" class="form-control input-lg" id="client-name" name="ClientName" value="<?php
echo $ClientName; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email</label>
        <input type="text" class="form-control input-lg" id="client-email" name="ClientEmail" value="<?php
echo $ClientEmail; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="ClientPhone" value="<?php
echo $ClientPhone; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="ClientAddress" value="<?php
echo $ClientAddress; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="ClientCompany" value="<?php
echo $ClientCompany; ?>">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="ClientNotes"><?php
echo $ClientNotes; ?></textarea>
    </div>
    <div class="col-sm-12">
        <hr>
        <button type="submit" class="btn btn-lg btn-danger pull-left" name="Delete">Delete</button>
        <div class="pull-right">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success" name="Update">Update</button>
        </div>
    </div>
</form>

<?php
include ('includes/footer.php');

?>
