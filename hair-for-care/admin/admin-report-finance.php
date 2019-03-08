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
							<h5 class="page-title"><i class="fa fa-bar-chart"></i>PERFORMANCE REPORT</h5>
							<div class="section-divider"></div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<div class="col-lg-12">
								<div class="dash-item first-dash-item">
									<h6 class="item-title"><i class="fa fa-search"></i>MAKE SELECTION</h6>
									<div class="inner-item dash-search-form">
										<div class="col-md-3 col-sm-6">
											<label>CLASS</label>
											<select>
												<option>5th STD</option>
												<option>6th STD</option>
												<option>7th STD</option>
											</select>
										</div>
										<div class="col-md-3 col-sm-6">
											<label>SECTION</label>
											<select>
												<option>PTH05A</option>
												<option>PTH05B</option>
											</select>
										</div>
										<div class="clearfix visible-sm"></div>
										<div class="col-md-3 col-sm-6">
											<label>ROLL NO</label>
											<select>
												<option>ALL</option>
												<option>PTH01A01</option>
												<option>PTH01A02</option>
												<option>PTH01A03</option>
											</select>
										</div>
										<div class="col-md-3 col-sm-6">
											<label>COURSE CODE</label>
											<select>
												<option>MTH101</option>
												<option>MTH102</option>
												<option>MTH103</option>
												<option>MTH104</option>
											</select>
										</div>
										<div class="clearfix visible-sm"></div>
										<div class="col-md-3 col-sm-6">
											<label class="top-margin">TYPE</label>
											<select>
												<option>Class Assessment</option>
												<option>MTE</option>
												<option>ETE</option>
											</select>
										</div>
										<div class="clearfix"></div>
										<div class="col-sm-3">
											<button type="submit" class="submit-btn"><i class="fa fa-search"></i>SELECT</button>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="col-md-6">
								<div class="dash-item">
									<h6 class="item-title"><i class="fa fa-line-chart"></i>GRAPH REPORT</h6>
									<div class="inner-item">
										<div class="summary-chart">
											<canvas id="studentAttendenceLine"></canvas>
											<div class="chart-legends">
												<span class="red">ABSENT</span>
												<span class="orange">FAIL</span>
												<span class="green">PASS</span>
											</div>
											<div class="chart-title">
												<h6 class="bottom-title">STUDENT PERFORMANCE REPORT</h6>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="dash-item">
									<h6 class="item-title"><i class="fa fa-list"></i>TABLE REPORT</h6>
									<div class="inner-item">
										<div>
											<table id="attendenceDetailedTable" class="display responsive nowrap" cellspacing="0" width="100%">
												<thead>
													<tr>
														<th><i class="fa fa-puzzle-piece"></i>ROLL #</th>
														<th><i class="fa fa-cogs"></i>TYPE</th>
														<th><i class="fa fa-exclamation"></i>MARKS</th>
														<th><i class="fa fa-check"></i>STATUS</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>PTH05A01</td>
														<td>MTE</td>
														<td>45</td>
														<td>PASS</td>
													</tr>
													<tr>
														<td>PTH05A012</td>
														<td>MTE</td>
														<td>45</td>
														<td>PASS</td>
													</tr>
													<tr>
														<td>PTH05A03</td>
														<td>MTE</td>
														<td>45</td>
														<td>PASS</td>
													</tr>
													<tr>
														<td>PTH05A04</td>
														<td>MTE</td>
														<td>25</td>
														<td>FAIL</td>
													</tr>
												</tbody>
											</table>
										</div>
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