<?php
session_start();

if (!$_SESSION['LoggedInUser']) {
	header("Location: index.php");
}

include ("includes/connection.php");

include ("includes/functions.php");

if (isset($_POST['AddClient'])) {
	$ClientName = $ClientEmail = $ClientPhone = $ClientAddress = $ClientCompany = $ClientNotes = "";
	if (!$_POST['ClientName']) {
		$NameError = "Please enter Client/'s Name <br />";
	}
	else {
		$ClientName = ValidateFormData($_POST['ClientName']);
	}

	if (!$_POST['ClientEmail']) {
		$EmailError = "Please enter Client/'s Email <br />";
	}
	else {
		$ClientEmail = ValidateFormData($_POST['ClientEmail']);
	}

	$ClientPhone = ValidateFormData($_POST['ClientPhone']);
	$ClientAddress = ValidateFormData($_POST['ClientAddress']);
	$ClientCompany = ValidateFormData($_POST['ClientCompany']);
	$ClientNotes = ValidateFormData($_POST['ClientNotes']);
	if ($ClientName && $ClientEmail) {
		$Query = "INSERT INTO `Clients`(`ID`, `Name`, `Email`, `Phone`, `Address`, `Company`, `Notes`, `Date`) VALUES (NULL, '$ClientName', '$ClientEmail', '$ClientPhone', '$ClientAddress', '$ClientCompany', '$ClientNotes', CURRENT_TIMESTAMP)";
		$Result = mysqli_query($Connection, $Query);
		if ($Result) {
			header("Location: clients.php?alert=Success");
		}
		else {
			echo "Error: " . $Query . "<br />" . mysqli_error($Connection);
		}
	}
}

mysqli_close($Connection);
include ('includes/header.php');

?>

<h1>Add Client</h1>

<form action="<?php
echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="row">
    <div class="form-group col-sm-6">
        <label for="client-name">Name *</label>
        <small><?php
echo $NameError; ?></small>
        <input type="text" class="form-control input-lg" id="client-name" name="ClientName" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-email">Email *</label>
        <small><?php
echo $NameError; ?></small> 
        <small><?php
echo $EmailErrora; ?></small>
        <input type="text" class="form-control input-lg" id="client-email" name="ClientEmail" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-phone">Phone</label>
        <input type="text" class="form-control input-lg" id="client-phone" name="ClientPhone" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-address">Address</label>
        <input type="text" class="form-control input-lg" id="client-address" name="ClientAddress" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-company">Company</label>
        <input type="text" class="form-control input-lg" id="client-company" name="ClientCompany" value="">
    </div>
    <div class="form-group col-sm-6">
        <label for="client-notes">Notes</label>
        <textarea type="text" class="form-control input-lg" id="client-notes" name="ClientNotes"></textarea>
    </div>
    <div class="col-sm-12">
            <a href="clients.php" type="button" class="btn btn-lg btn-default">Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="AddClient">Add Client</button>
    </div>
</form>

<?php
include ('includes/footer.php');

?>