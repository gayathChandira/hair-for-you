<?php
include('../includes/connection.php');
include('../includes/session.php');
?>
<!DOCTYPE html>
<html>
    
<head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <title>IAS</title>

        <!-- Styles -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/chartist.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/owl.carousel.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/owl.theme.default.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/jquery.dataTables.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/responsive.dataTables.min.css" rel="stylesheet" media="screen">
        <link href="../assets/css/style.css" rel="stylesheet" media="screen">

        <!-- Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
        <link href="../assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="screen">

    </head>
    <body>
		<!-- HEADER -->
        <?php include('includes/admin-header.php'); ?>
        	
		<div class="parent-wrapper" id="outer-wrapper">
			<!-- SIDE MENU -->
			<?php include('includes/admin-sidebar.php'); ?>
			
			<!-- MAIN CONTENT -->
			<div class="main-content" id="content-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<h5 class="page-title"><i class="fa fa-user-secret"></i>ALL LECTURERS</h5>
							<div class="section-divider"></div>
						</div>
					</div>
                    <h2 class="error-msg"><?php include_once('../includes/message.php'); ?></h2>
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<div class="col-lg-12">
								<div class="dash-item first-dash-item">
									<h6 class="item-title"><i class="fa fa-user"></i>LECTURERS</h6>
									<div class="inner-item">
										<table id="attendenceDetailedTable" class="display responsive nowrap" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th><i class="fa fa-user"></i> LECTURER ID</th>
													<th><i class="fa fa-graduation-cap"></i >FIRST NAME</th>
													<th><i class="fa fa-building"></i> LAST NAME</th>
													<th><i class="fa fa-calendar"></i> PHONE</th>
													<th><i class="fa fa-puzzle-piece"></i>NIC</th>
													<th><i class="fa fa-envelope-o"></i>EMAIL</th>
													<th><i class="fa fa-tasks"></i>ACTION</th>
												</tr>
											</thead>
											<tbody>
											<?php
											$sql = "SELECT * FROM `lecturers` ";
											$result = mysqli_query($connection, $sql);

											while($row = $result->fetch_assoc()) {
											 echo 
												"<tr>
												<td> ".$row['lecturer_id']."</td>
												<td>".$row['first_name']."</td>
												<td>".$row['last_name']."</td>
												<td> ".$row['nic']."</td>
												<td> ".$row['phone']."</td>
												<td> ".$row['email']."</td>
												<td> 
                                                        <form action =\"admin-lecturer-edit-inner.php\" method=\"post\" >
                                                            <input type=\"hidden\" value=" .$row['lecturer_id']. " name=\"lecturer_id\">
                                                            <input class=\"delete-btn\" type=\"submit\" name=\"submit\" value=\"Edit\">
                                                        </form>
                                                </td>";

												}
												?>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="menu-togggle-btn">
					<a href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
				</div>
				<div class="dash-footer col-lg-12">
					<p>IAS. Copyright 2018. All Rights Reserved.</p>
				</div>
				
				
				<!-- Delete Modal -->
				<div id="deleteDetailModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><i class="fa fa-trash"></i>DELETE LECTURER</h4>
							</div>
							<div class="modal-body">
								<div class="table-action-box">
									<a href="#" class="save"><i class="fa fa-check"></i>YES</a>
									<a href="#" class="cancel" data-dismiss="modal"><i class="fa fa-ban"></i>CLOSE</a>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
				
				
				<!--Edit details modal-->
				<div id="editDetailModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title"><i class="fa fa-edit"></i>EDIT LECTURER DETAILS</h4>
							</div>
							<div class="modal-body dash-form">
								<div class="col-sm-3">
									<label class="clear-top-margin"><i class="fa fa-user"></i>FIRST NAME</label>
									<input type="text" placeholder="First Name" value="John" />
								</div>
								<div class="col-sm-3">
									<label class="clear-top-margin"><i class="fa fa-user"></i>MIDDLE NAME</label>
									<input type="text" placeholder="Middle Name" value="Fidler" />
								</div>
								<div class="col-sm-3">
									<label class="clear-top-margin"><i class="fa fa-user"></i>LAST NAME</label>
									<input type="text" placeholder="Last Name" value="Doe" />
								</div>
								<div class="col-sm-3">
									<label class="clear-top-margin"><i class="fa fa-book"></i>CLASS</label>
									<input type="text" placeholder="Standard" value="5 STD" />
								</div>
								<div class="clearfix"></div>
								<div class="col-sm-3">
									<label><i class="fa fa-cogs"></i>SECTION</label>
									<input type="text" placeholder="Section" value="PTH05A" />
								</div>
								<div class="col-sm-3">
									<label><i class="fa fa-puzzle-piece"></i>ROLL #</label>
									<input type="text" placeholder="Roll Number" value="Fidler" />
								</div>
								<div class="col-sm-3">
									<label><i class="fa fa-phone"></i>CONTACT #</label>
									<input type="text" placeholder="Contact Number" value="1234567890" />
								</div>
								<div class="col-sm-3">
									<label><i class="fa fa-envelope-o"></i>EMAIL</label>
									<input type="text" placeholder="Email" value="john@gmail.com" />
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="modal-footer">
								<div class="table-action-box">
									<a href="#" class="save"><i class="fa fa-check"></i>SAVE</a>
									<a href="#" class="cancel" data-dismiss="modal"><i class="fa fa-ban"></i>CLOSE</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
		<!-- Scripts -->
        <script src="../assets/js/jQuery_v3_2_0.min.js"></script>
		<script src="../assets/js/jquery-ui.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
		<script src="../assets/plugins/owl.carousel.min.js"></script>
		<script src="../assets/plugins/Chart.min.js"></script>
		<script src="../assets/plugins/jquery.dataTables.min.js"></script>
		<script src="../assets/plugins/dataTables.responsive.min.js"></script>
        <script src="../assets/js/js.js"></script>
		
    </body>
<script>'undefined'=== typeof _trfq || (window._trfq = []);'undefined'=== typeof _trfd && (window._trfd=[]),_trfd.push({'tccl.baseHost':'secureserver.net'}),_trfd.push({'ap':'cpsh'},{'server':'a2plcpnl0381'}) // Monitoring performance to make your website faster. If you want to opt-out, please contact web hosting support.</script><script src='../../../../../../img1.wsimg.com/tcc/tcc_l.combined.1.0.6.min.js'></script>

</html>