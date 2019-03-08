<!DOCTYPE html>
<html>
    
<head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <title>Hair For Care</title>

        <!-- Styles -->
        <link href="../assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
		 <link href="../assets/css/chartist.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/owl.carousel.min.css" rel="stylesheet" media="screen">
		<link href="../assets/css/owl.theme.default.min.css" rel="stylesheet" media="screen">
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
			<div class="menu-togggle-btn">
					<a href="#menu-toggle" id="menu-toggle"><i class="fa fa-bars"></i></a>
				</div>
				
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<h5 class="page-title"><i class="fa fa-home"></i>HOME</h5>
							<div class="section-divider"></div>
							<div class="dashboard-stats">
								<div class="col-sm-6 col-md-4">
									<div class="stat-item">
										<div class="stats">
                                    
                                    


                                            
                                            <div class="col-xs-8 count">
                                            <h1>52</h1>
                                                <?php
                                                   /* $sql = "SELECT COUNT(*) as total FROM `students`";
											        $result = mysqli_query($connection, $sql);
                                                    $row = $result->fetch_assoc();
                                                    echo "<h1>".$row['total']."</h1>";  */ 
                                                ?>
												
												<p>DONORS</p>
											</div>
											<div class="col-xs-4 icon">
												<i class="fa fa-users ex-icon"></i>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="col-sm-6 col-md-4">
									<div class="stat-item">
										<div class="stats">
											<div class="col-xs-8 count">
                                            <h1>36</h1>
                                                <?php
                                                   /* $sql = "SELECT COUNT(*) as total FROM `lecturers`";
											        $result = mysqli_query($connection, $sql);
                                                    $row = $result->fetch_assoc();
                                                    echo "<h1>".$row['total']."</h1>";  */ 
                                                ?>
												
												<p>REQUESTED PATIENTS</p>
											</div>
											<div class="col-xs-4 icon">
												<i class="fa fa-user-secret danger-icon"></i>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
                                <div class="col-sm-6 col-md-4">
									<h6 class="item-title"><i class="fa fa-bar-chart"></i>HAIR DONATION TREND</h6>
										<div class="inner-item">
											<div class="summary-chart">
												<canvas id="studentAttendenceLine" height="100px"></canvas>
												<!--<div class="chart-legends">
													<span class="red">ABSENT</span>
													<span class="orange">ON LEAVE</span>
													<span class="green">PRESENT</span>
												</div>-->
								</div>
							
							</div>
						</div>
					</div>
		
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<div class="col-sm-12">
								<div>
									<div class="my-msg dash-item">
										<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<div class="col-md-12">
								<div class="my-msg dash-item">
									<h6 class="item-title"><i class="fa fa-bullhorn"></i>Details</h6>
									<div class="inner-item dashboard-tabs">
										<ul class="nav nav-tabs">
											<li class="active">
												<a  href="#1" data-toggle="tab"><i class="fa fa-graduation-cap"></i><span>Donors Details</span></a>
											</li>
											<li>								
												<a href="#2" data-toggle="tab"><i class="fa fa-users"></i><span>Patients' Details</span></a>
											</li>
											<li>								
												<a href="#3" data-toggle="tab"><i class="fa fa-trophy"></i><span>Statistics</span></a>
											</li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane active" id="1">
												<div class="announcement-item">
													<h5>Donation Requst by Smith.<span class="new">New</span></h5>
													<h6><i class="fa fa-clock-o"></i>06-24-2017, 13:34</h6>
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
													<div class="posted-by">
														<p>Thanks,</p>
														<h6>Kamal Pancharathna, Principal</h6>
													</div>
												</div>
												<div class="announcement-item">
													<h5>100$ Donated by Adam Smith</h5>
													<h6><i class="fa fa-clock-o"></i>06-24-2017, 13:34</h6>
													<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
													<div class="posted-by">
														<p>Thanks,</p>
														<h6>Kamal Pancharathna, Principal</h6>
													</div>
												</div>
											</div>
											<div class="tab-pane" id="2">
												<div class="announcement-item">
													<h5>2</h5>
												</div>
											</div>
											<div class="tab-pane" id="3">
												<div class="announcement-item">
													<h5>35</h5>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="dash-footer col-lg-12">
					<p>IAS. Copyright 2018. All Rights Reserved.</p>
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