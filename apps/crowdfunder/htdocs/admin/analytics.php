
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="../../../favicon.ico">
    <script src="../plugins/chart.js/dist/Chart.bundle.min.js"></script>
    <script src="../util/charts/projectChart.js"></script>
    <title>CrowdFunder</title>

    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../plugins/font-awesome.min.css">
    <link href="../main.css" rel="stylesheet">
  </head>

  <body>
    <?php
    session_start();
    if (!isset($_SESSION['usr_id'])) {
      header("Location: ../login.php");
    } else if ($_SESSION['usr_role'] == 2) {
      header("Location: ../user/index.php");
    }

  	$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=postgres")
      or die('Could not connect: ' . pg_last_error());

      $query = "SELECT m.firstname, m.lastname
                FROM member m
                WHERE m.email = '".$_SESSION['usr_id']."'";
      $result = pg_query($query) or die('Query failed: ' . pg_last_error());
      $user=pg_fetch_assoc($result);
  	?>
  	<div class="wrapper" style="height: auto;">



      <header class="main-header">

      <!-- Logo -->
      <a href="index.php" class="logo">
        <span class="logo-lg"><b>CrowdFunder</b>Admin</span>
      </a>
      <nav class="navbar navbar-static-top">
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $user['firstname']." ".$user['lastname'];?><span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="../user/index.php">Switch to user</a></li>
                <li><a href="../logout.php">Sign Out</a></li>
              </ul>
          </li>
          </ul>
        </div>
      </nav>
    </header>
  <aside class="main-sidebar">
    <section class="sidebar" style="height:auto;">

      <ul class="sidebar-menu">
        <li class="header">NAVIGATION</li>
        <li class="treeview">
          <a href="index.php">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
		<li class="treeview">
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
        <li class="active treeview">
          <a href="analytics.php">
            <i class="fa fa-bar-chart"></i> <span>Analytics</span>
          </a>
        </li>
        <li class="treeview">
              <a href="reactivation.php">
                <i class="fa fa-recycle"></i> <span>Reactivation</span>
              </a>
        </li>
        <li clas="treeview">
          <a href="history.php">
            <i class="fa fa-history"></i><span>History</span>
          </a>
        </li>
      </ul>
    </section>
  </aside>
     <div class="content-wrapper" style="min-height:916px;">
    <section class="content-header">
      <h1>
        Analytics
      </h1>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-md-4">
         <div class="box analytics-box">
           <div class="box-body">
              <h3 class="text-center">Popular Project of the Month</h3>
              <ul class="list-group list-group-unbordered">
               <?php
               $query = "SELECT SUM(t1.amount) AS sum, p1.title, RANK() OVER (ORDER BY SUM(t1.amount) DESC) as ranking
                          FROM Trans t1 INNER JOIN Project p1 ON t1.projectId = p1.id
                          WHERE current_date - t1.date < 30
                          GROUP BY t1.projectId, p1.title
                          ORDER BY sum DESC";

               $result = pg_query($query) or die('Query failed: ' . pg_last_error());

               if (pg_num_rows($result) > 0) {
                  $num_to_display = 20;
                 while($num_to_display > 0 && $row=pg_fetch_assoc($result)) {
                    $num_to_display--;
                   echo "<li class=\"list-group-item\"><strong>#".$row['ranking']." ".$row['title']." </strong><a class=\"pull-right\">$".$row['sum']."</a>";
                 }
               } else {
                 echo "<li class=\"list-group-item text-center\">No funding has been made this month.</li>";
               }

               pg_free_result($result);
               ?>

             </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
         <div class="box analytics-box">
           <div class="box-body">
              <h3 class="text-center">Top 20 Investors of the Week</h3>
              <ul class="list-group list-group-unbordered">
               <?php
               $query = "SELECT SUM(t1.amount) AS sum, m1.lastName, m1.firstName, RANK() OVER (ORDER BY SUM(t1.amount) DESC) as ranking
                          FROM Trans t1 INNER JOIN Member m1 ON t1.email = m1.email
                          WHERE current_date - t1.date < 30
                          GROUP BY m1.email
                          ORDER BY sum DESC";

               $result = pg_query($query) or die('Query failed: ' . pg_last_error());

               if (pg_num_rows($result) > 0) {
                  $num_to_display = 20;
                 while($num_to_display > 0 && $row=pg_fetch_assoc($result)) {
                    $num_to_display--;
                   echo "<li class=\"list-group-item\"><strong>#".$row['ranking']." ".$row['lastname']." ".$row['firstname']."</strong><a class=\"pull-right\">$".$row['sum']."</a>";
                 }
               } else {
                 echo "<li class=\"list-group-item text-center\">No funding has been made this month.</li>";
               }

               pg_free_result($result);
               ?>

             </ul>
            </div>
          </div>
        </div>
        <div class="col-md-4">
         <div class="box analytics-box">
           <div class="box-body">
             <h3 class="text-center">10 Newest Projects</h3>
             <table id="projectsTable" class="table table-bordered table-hover" >
                       <thead>
                 <tr>
                   <th>Title</th>
                   <th>Start Date</th>
                   <th>Amount Raised</th>
                   <th></th>
                 </tr>
                       </thead>
                       <tbody id="table_data">
                         <?php
                         ob_start();
                         $query = "SELECT SUM(t1.amount) AS amountraised, t1.projectId AS id, p1.title AS title, RANK() OVER (ORDER BY p1.startdate DESC) as ranking, p1.amountFundingSought, p1.startDate
                                    FROM Trans t1 INNER JOIN Project p1 ON t1.projectId = p1.id
                                    WHERE p1.softDelete = FALSE
                                    GROUP BY t1.projectId, p1.title, p1.amountFundingSought, p1.startDate
                                    ORDER BY p1.startDate DESC";
                         $count = 0;
                         $result = pg_query($query) or die('Query failed: ' . pg_last_error());

                         while(($row=pg_fetch_assoc($result) )&& $count<10) {
                           if ((!is_null($row['amountraised'])) && ($row['amountraised'] >= $row['amountfundingsought'])) {
                             echo "<tr style=\"background-color:#c9ffc9;\">";
                           } else {
                             echo "<tr>";
                           }

                           echo "<td>".$row['title']
                           ."</td><td>".$row['startdate']
                           ."</td><td><div class=\"progress\" style=\"margin-bottom:2px;\"><div class=\"progress-bar progress-bar-success\" role=\"progressbar\" aria-valuenow=\"70\"
                           aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width:"
                           .(($row['amountraised'] * 100 / $row['amountfundingsought']))
                           ."%;\">
                           </div></div>";

                           if ($row['amountraised'] >= $row['amountfundingsought']) {
                             echo " <strong style=\"color:#5cb85c;\">$".$row['amountraised']."</strong> / $".$row['amountfundingsought'];
                           } else {
                             echo "$".$row['amountraised']." / $".$row['amountfundingsought'];
                           }

                                     $proj_id = $row['id'];

                           echo "</td><td><button class=\"btn btn-primary btn-xs\" onClick=\"location.href='project_details.php?id=$proj_id'\"><span class=\"glyphicon glyphicon-info-sign\"></span></button></td></tr>";
                           $count++;
                         }


                 pg_free_result($result);

               ?>
                       </tbody>
                     </table>

            </div>
          </div>
        </div>

      </div>
      <div class="row">
        <div class="col-md-6">
         <div class="box analytics-box">
           <div class="box-body">
              <div class="canvas-holder">
              <canvas id="numberOfUsersChart" width="848" height="424" style="display: block; height: 212px; width: 424px;"></canvas>
              <script>
              <?php
              $query = "SELECT registrationDate AS date, COUNT(*) AS count
                        FROM Member m1
                        GROUP BY registrationDate
                        ORDER BY registrationDate ASC
                        ";
              $result = pg_query($query) or die('Query failed: '.pg_last_error());
              $graphData = array();
              $graphLabels = array();
              $count =0;
              while($buffer = pg_fetch_assoc($result)){
                  if($count!=0){
                    $graphData[$count] = (int) ($buffer['count'] + $graphData[$count - 1]);
                    $graphLabels[$count] = $buffer['date'];
                  }else{
                    $graphData[$count] = (int) $buffer['count'];
                    $graphLabels[$count] = $buffer['date'];
                  }

                    $count++;
              }
              pg_free_result($result);
              ?>
                console.log("DRAWING");
                drawLineGraphWithTime(<?php echo json_encode($graphData) ?>, "Number of registered users",<?php echo json_encode($graphLabels) ?>, <?php echo $count ?>, document.getElementById("numberOfUsersChart"));
                </script>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
         <div class="box analytics-box">
           <div class="box-body">
              <div class="canvas-holder">
              <canvas id="totalFundingChart" width="848" height="424" style="display: block; height: 212px; width: 424px;"></canvas>
              <script>
              <?php
              $query = "SELECT date, SUM(amount) AS sum
                        FROM Trans t
                        GROUP BY date
                        ORDER BY date ASC
                        ";
              $result = pg_query($query) or die('Query failed: '.pg_last_error());
              $graphData = array();
              $graphLabels = array();
              $count =0;
              while($buffer = pg_fetch_assoc($result)){
                  if($count!=0){
                    $graphData[$count] = (int) ($buffer['sum'] + $graphData[$count - 1]);
                    $graphLabels[$count] = $buffer['date'];
                  }else{
                    $graphData[$count] = (int) $buffer['count'];
                    $graphLabels[$count] = $buffer['date'];
                  }

                    $count++;
              }
              pg_free_result($result);
              ?>
                console.log("DRAWING");
                drawLineGraphWithTime(<?php echo json_encode($graphData) ?>, "Total funding",<?php echo json_encode($graphLabels) ?>, <?php echo $count ?>, document.getElementById("totalFundingChart"));
                </script>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class='row'>
        <div class="col-md-12">
         <div class="box analytics-box">
           <div class="box-body">
              <h3 class="text-center">Non-New Users Who Not Invested for More Than 5 Days</h3>
              <table id="usersTable" class="table table-bordered table-hover" >
                        <thead>
                  <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Last Transaction Date</th>
                    <th>Registration Date</th>
                    <th>Total Funding</th>
                    <th></th>
                  </tr>
                        </thead>
                        <tbody>
               <?php
               $query = "SELECT m1.firstName, m1.lastName, MAX(t2.date) AS latesttrans, SUM(t2.amount) AS donation, m1.email, m1.registrationDate
               FROM Member m1 NATURAL JOIN Trans t2
               WHERE NOT EXISTS(SELECT *
                                FROM Trans T1
                                WHERE M1.email=T1.email AND current_date-T1.date < 5)
                    AND current_date - m1.registrationDate > 30
               GROUP BY m1.firstName,m1.lastName, m1.email
               ORDER BY latesttrans";

               $result = pg_query($query) or die('Query failed: ' . pg_last_error());

               while($row=pg_fetch_assoc($result)) {
                  echo "<tr><td>".$row['firstname']
                  ."</td><td>".$row['lastname']
                  ."</td><td>".$row['email']
                  ."</td><td>".$row['latesttrans']
                  ."</td><td>".$row['registrationdate']."</td>";


                  if($row['donation'] != 0) {
                    echo "<td>$".$row['donation']."</td>";
                  } else {
                    echo "<td>$0</td>";
                  }
                  $user_email = $row['email'];

                  echo "<td><button class=\"btn btn-primary btn-xs\"><span class=\"glyphicon glyphicon-info-sign\"></span></button></td></tr>";
                }

              pg_free_result($result);
            ?>
                     </tbody>
                   </table>
                 </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
	</div>

    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
