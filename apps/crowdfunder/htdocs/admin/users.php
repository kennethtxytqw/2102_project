
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard</title>

    <!-- Bootstrap -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

    <!-- DataTables -->
	<link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">

    <!-- Custom styles for this template -->
    <link href="../main.css" rel="stylesheet">

    <!-- Include Date Range Picker -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>
  </head>

  <!-- <body> -->
	<?php
	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres")
    or die('Could not connect: ' . pg_last_error());
	?>
	<div class="wrapper" style="height: auto;">

    <header class="main-header">

    <!-- Logo -->
    <a href="dashboard.php" class="logo">
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>CrowdFunder</b>Admin</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">Admin</span>
            </a>
          </li>
        </ul>
      </div>

    </nav>
  </header>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height:auto;">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">NAVIGATION</li>
        <li class="treeview">
          <a href="dashboard.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
		<li class="active treeview">
          <a href="users.php">
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
		<li class="treeview">
          <a href="projects.php">
            <i class="fa fa-lightbulb-o"></i> <span>Projects</span>
          </a>
        </li>
		<li class="treeview">
          <a href="funding.php">
            <i class="fa fa-dollar"></i> <span>Funding</span>
          </a>
        </li>
		<li class="treeview">
          <a href="categories.php">
            <i class="fa fa-gear"></i> <span>Category</span>
          </a>
        </li>
    	<li class="treeview">
          <a href="analytics.php">
            <i class="fa fa-dollar"></i> <span>Analytics</span>
          </a>
        </li>
		<li class="treeview">
          <a href="reactivation.php">
            <i class="fa fa-recycle"></i> <span>Reactivation</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
     <div class="content-wrapper" style="min-height:916px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Management
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box user-box">
            <div class="box-header">
              <h3 class="box-title">All Users</h3>
			  <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#userForm" show="false"><span><i class="fa fa-user-plus"> </i></span> New User</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<form id="search-user-form" role="form" method="post">
			<div class="row extra-bottom-padding">
				<div class="col-md-3">
					<div class="input-group">
						<input name="search-user" type="text" class="form-control" placeholder="First name/Last name"/>
						<span class="input-group-addon">
							<i class="fa fa-user"></i>
						</span>
					</div>
				</div>
				<div class="col-md-3">
					<select name="search-projects-created" class="form-control" method="post">
						<option disabled selected>Number of Projects Created</option>
						<option value="0 5"><5</option>
						<option value="5 10">5 to 10</option>
						<option value="10 15">10 to 15</option>
						<option value="15 2147483647">>15</option>
					</select>
				</div>
				<div class="col-md-3">
					<select name="search-projects-funded" class="form-control" method="post">
						<option disabled selected>Number of Projects Funded</option>
						<option value="0 5"><5</option>
						<option value="5 10">5 to 10</option>
						<option value="10 15">10 to 15</option>
						<option value="15 2147483647">>15</option>
					</select>
				</div>
				<div class="col-md-3">
					<select name="search-donation" class="form-control" method="post">
						<option disabled selected>Total Amount Donated</option>
						<option value="0 1">$0 to $1k Donated</option>
						<option value="1 10">$1k to $10k Donated</option>
						<option value="10 100">$10k to $100k Donated</option>
						<option value="100 1000">$100k to $1M Donated</option>
						<option value="1000 2147483647">>$1M Donated</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<select name="search-country" class="form-control" method="post">
					<option disabled selected>Select a country</option>
						<?php
							$query = 'SELECT * FROM Country c';
							$result = pg_query($query) or die('Query failed: ' . pg_last_error());

							while($row=pg_fetch_assoc($result)) {
								echo "<option value=".$row['id'].">".$row['name']."</option>";
							}

							pg_free_result($result);
						?>
					</select>
				</div>
				<div class="col-md-2">
					<select name="search-role" class="form-control" method="post">
					<option disabled selected>Select a role</option>
						<?php
							$query = 'SELECT * FROM Role r';
							$result = pg_query($query) or die('Query failed: ' . pg_last_error());

							while($row=pg_fetch_assoc($result)) {
									echo "<option value=".$row['id'].">".$row['type']."</option>";
								}

							pg_free_result($result);
						?>
					</select>
				</div>
				<div class="col-md-1 col-md-offset-6">
					<button name="search-submit" type="submit" class="btn btn-primary">Search</button>
				</div>
			</div>
			</form>
			</div>

			<!-- Modal -->
			<div id="userForm" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <form id="add-user-form" role="form" method="post">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">New User</h4>
				  </div>
				  <div class="modal-body">
						<div class="input-group">
							<span class="input-group-addon">First Name</span>
							<input name="firstname" type="text" class="form-control" placeholder="First Name">
						</div><br/>
						<div class="input-group">
							<span class="input-group-addon">Last Name</span>
							<input name="lastname" type="text" class="form-control" placeholder="Last Name">
						</div><br/>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							<input name="email" type="email" class="form-control" placeholder="Email">
						</div><br/>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-key"></i></span>
							<input name="password" type="password" class="form-control" placeholder="Password">
						</div><br/>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-globe"></i></span>
							<select name="country" class="form-control">
								<option value="" disabled selected>Select a country</option>
								<?php
									$query = 'SELECT * FROM Country c';
									$result = pg_query($query) or die('Query failed: ' . pg_last_error());

									while($row=pg_fetch_assoc($result)) {
											echo "<option value=".$row['id'].">".$row['name']."</option>";
										}

									pg_free_result($result);
								?>
							</select>
						</div><br/>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<select name="role" class="form-control">
								<option value="" disabled selected>Select a role</option>
								<?php
									$query = 'SELECT * FROM Role r';
									$result = pg_query($query) or die('Query failed: ' . pg_last_error());

									while($row=pg_fetch_assoc($result)) {
											echo "<option value='".$row['id']."'>".$row['type']."</option>";
										}

									pg_free_result($result);
								?>
							</select>
						</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" name="userForm" class="btn btn-primary">Add User</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				  </div>
				  </form>
				  <?php
						if(isset($_POST['userForm'])){

							$query = "INSERT INTO Member (email, password, countryId, firstName, lastName, registrationDate, roleId)
									VALUES (
									'".$_POST['email']."',
									crypt('".$_POST['password']."', gen_salt('bf', 8)),
									'".$_POST['country']."',
									'".$_POST['firstname']."',
									'".$_POST['lastname']."',
									'".date("Y-m-d")."',
									'".$_POST['role']."'
									)";

							$result = pg_query($query) or die('Query failed: ' . pg_last_error());
							echo "<script type='text/javascript'>alert('".pg_affected_rows($result)."');</script>";
						}
					?>
				</div>
			  </div>
			</div>


			<br/>
			<table id="usersTable" class="table table-bordered table-hover" >
                <thead>
					<tr>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Email</th>
						<th>Country</th>
						<th>Registration Date</th>
						<th>Role Type</th>
						<th>Projects Created</th>
						<th>Projects Funded</th>
						<th>Total Donation</th>
						<th></th>
						<th></th>
					</tr>
                </thead>
                <tbody>
                <?php
                	ob_start();
					$query = 'SELECT m.firstName, m.lastName, m.email, c.name AS country_name, m.registrationDate, r.type, COUNT(p.id) AS proj_created, COALESCE(b.projFunded, 0) AS proj_funded, COALESCE(b.transactSum, 0) AS donation
								FROM Member m LEFT OUTER JOIN Project p ON m.email = p.email
											  LEFT OUTER JOIN (SELECT t.email, SUM(t.amount) AS transactSum, COUNT(DISTINCT t.projectId) AS projFunded
											  				   FROM Trans t GROUP BY t.email) b
															   ON b.email = m.email,
									 Country c, Role r
								WHERE m.countryId = c.id AND r.id = m.roleId AND m.softDelete = FALSE
								GROUP BY m.firstName, m.lastName, m.email, c.name, m.registrationDate, r.type, b.projFunded, b.transactSum
								ORDER BY m.firstName, m.lastName';

					$result = pg_query($query) or die('Query failed: ' . pg_last_error());

					while($row=pg_fetch_assoc($result)) {
						echo "<tr><td>".$row['firstname']
						."</td><td>".$row['lastname']
						."</td><td>".$row['email']
						."</td><td>".$row['country_name']
						."</td><td>".$row['registrationdate']
						."</td><td>".$row['type'] //TODO: Add privilege level here
						."</td><td>".$row['proj_created']
						."</td><td>".$row['proj_funded']
						."</td><td>$".$row['donation']."</td>";

						$user_email = $row['email'];

						echo "<td><button class=\"btn btn-primary btn-xs\" onClick=\"location.href='user_details.php?email=$user_email'\"><span class=\"glyphicon glyphicon-info-sign\"></span></button></td>
						<td><button class=\"btn btn-danger btn-xs delete_user\" user-email=\"$user_email\" href=\"javascript:void(0)\"><span class=\"glyphicon glyphicon-trash\"></span></button></td></tr>";
					}

					pg_free_result($result);

					if (isset(($_POST['search-submit']))) {
						ob_end_clean();
						ob_start();
						$searchName = $_POST['search-user'];
						$searchCountryId = $_POST['search-country'];
						$searchRoleId = $_POST['search-role'];

						$searchProjCreated = $_POST['search-projects-created'];
						$createdArray = explode(" ", $searchProjCreated);
						$createdMin = $createdArray[0];
						$createdMax = $createdArray[1];

						$searchProjFunded = $_POST['search-projects-funded'];
						$fundedArray = explode(" ", $searchProjFunded);
						$fundedMin = $fundedArray[0];
						$fundedMax = $fundedArray[1];

						$searchDonationValue = $_POST['search-donation'];
						$donationArray = explode(" ", $searchDonationValue);
						$donationMin = $donationArray[0] * 1000;
						$donationMax = $donationArray[1] * 1000;

						$baseQuery = "SELECT m.firstName, m.lastName, m.email, m.roleId, m.countryId,
										 c.name AS countryName, m.registrationDate, r.type,
									     COALESCE(p1.projCreated, 0) AS projCreated,
									     COALESCE(b.projFunded, 0) AS projFunded,
									     COALESCE(b.totalDonation, 0) AS totalDonation
								FROM Member m INNER JOIN Country c ON m.countryId = c.id
											  INNER JOIN Role r ON m.roleId = r.id
											  LEFT OUTER JOIN (SELECT p.email, COUNT(p.id) AS projCreated
											  			       FROM Project p
											  				   GROUP BY p.email) p1
											  				   ON m.email = p1.email
											  LEFT OUTER JOIN (SELECT t.email, SUM(t.amount) AS totalDonation,
											  				   		  COUNT(DISTINCT t.projectId) AS projFunded
											  				   FROM Trans t GROUP BY t.email) b
															   ON b.email = m.email
								WHERE m.softDelete = FALSE";

						$query = "SELECT * FROM ({$baseQuery}) AS base
								WHERE (firstName LIKE '%{$searchName}%' OR lastName LIKE '%{$searchName}%') ";

						if (!empty($searchCountryId)) {
							$query .= "AND countryId = {$searchCountryId} ";
						}

						if (!empty($searchRoleId)) {
							$query .= "AND roleId = {$searchRoleId} ";
						}

						if (!empty($createdMax) || !empty($createdMin)) {
							$query .= "AND projCreated <= {$createdMax} AND projCreated >= {$createdMin} ";
						}

						if (!empty($fundedMin) || !empty($fundedMax)) {
							$query .= "AND projFunded <= {$fundedMax} AND projFunded >= {$fundedMin} ";
						}

						if (!empty($donationMax) || !empty($donationMin)) {
							$query .= "AND totalDonation <= {$donationMax} AND totalDonation >= {$donationMin} ";
						}

						$query .= "ORDER BY firstName, lastName";

						$result = pg_query($query) or die('Query failed: ' . pg_last_error());

						while($row=pg_fetch_assoc($result)) {
							echo "<tr><td>".$row['firstname']
							."</td><td>".$row['lastname']
							."</td><td>".$row['email']
							."</td><td>".$row['countryname']
							."</td><td>".$row['registrationdate']
							."</td><td>".$row['type'] //TODO: Add privilege level here
							."</td><td>".$row['projcreated']
							."</td><td>".$row['projfunded']
							."</td><td>$".$row['totaldonation']."</td>";

							$user_email = $row['email'];

							echo "<td><button class=\"btn btn-primary btn-xs\" onClick=\"location.href='user_details.php?email=$user_email'\"><span class=\"glyphicon glyphicon-info-sign\"></span></button></td>
							<td><button class=\"btn btn-danger btn-xs delete_user\" user-email=\"$user_email\" href=\"javascript:void(0)\"><span class=\"glyphicon glyphicon-trash\"></span></button></td></tr>";
						}

						pg_free_result($result);
					}
				?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
	</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
	<!-- DataTables -->
	<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
	<script src="../plugins/bootbox.min.js"></script>

	<script>
	    $(document).ready(function(){
	        $('.delete_user').click(function(e){

	          e.preventDefault();

	          var pid = $(this).attr('user-email');
	          console.log(pid);
	          var parent = $(this).parent("td").parent("tr");
	          bootbox.dialog({
	            message: "Are you sure you want to delete this user?",
	            title: "<i class='glyphicon glyphicon-trash'></i> Delete !",
	            buttons: {
	            danger: {
	              label: "Delete!",
	              className: "btn-danger",
	              callback: function() {

	                $.post('deletion/delete_user.php', { 'delete':pid })
	                .done(function(response){
	                  bootbox.alert(response);
	                  parent.fadeOut('slow');
	                })
	                .fail(function(){
	                  bootbox.alert('Something Went Wrong ....');
	                  })
	                }
	              },
	            success: {
	              label: "No",
	              className: "btn-success",
	              callback: function() {
	               $('.bootbox').modal('hide');
	                }
	             }

	            }
	          });
	        });
	      });
	</script>
	<script>
		$(function() {
			var startDate;
			var endDate;

			$('#search-reg-date').daterangepicker({
				"minDate": new Date(),
				"locale": {
					"format": "DD/MM/YYYY",
				}
			});
		});
	</script>
  </body>
</html>