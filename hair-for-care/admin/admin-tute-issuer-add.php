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
							<h5 class="page-title"><i class="fa fa-user"></i>ADD TUTE-ISSUER</h5>
							<div class="section-divider"></div>
						</div>
					</div>
                    <h2 class="error-msg"><?php include_once('../includes/message.php'); ?></h2>
					<div class="row">
						<div class="col-lg-12 clear-padding-xs">
							<div class="col-md-12">
								<div class="dash-item first-dash-item">
									<h6 class="item-title"><i class="fa fa-user"></i>TUTE-ISSUER INFO</h6>
									<div class="inner-item">
                                        
                                        <form action="php/admin-tute-issuer-add-submit.php" method="post">
                                            <div class="dash-form">
                                                <div class="col-sm-4">
                                                    <label class="clear-top-margin"><i class="fa fa-user-circle-o"></i>TUTE-ISSUER ID</label>
                                                    <input type="text" placeholder="xxExx" name="tute-issuer_id" value="12E45" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="clear-top-margin"><i class="fa fa-user-circle-o"></i>FIRST NAME</label>
                                                    <input type="text" placeholder="FIRST NAME" name="first_name" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="clear-top-margin"><i class="fa fa-user-circle-o"></i>LAST NAME</label>
                                                    <input type="text" placeholder="LAST NAME" name="last_name" />
                                                </div>
                                                <div class="clearfix"></div>
                                                <div class="col-sm-4">
                                                    <label><i class="fa fa-envelope-o"></i>EMAIL</label>
                                                    <input type="email" placeholder="xx@xx.com" name="email" />
                                                </div>
                                                <div class="col-sm-4">
                                                    <label><i class="fa fa-envelope-o"></i>PASSWORD</label>
                                                    <input type="text" placeholder="password" name="password" />
                                                </div>
                                                
                                                <div class="clearfix"></div>
    <!--
                                                <div class="col-sm-3">
                                                    <label><i class="fa fa-file-picture-o"></i>UPLOAD PHOTO</label>
                                                    <input type="file" placeholder="90890" />
                                                </div>
    -->
                                                <div class="col-sm-3">
    <!--												<a href="#"><i class="fa fa-paper-plane"></i> SAVE</a>-->
                                                    <br><br>
                                                    <input style="background-color:#ed1d24; color:#fff;" type="submit" value="ADD TUTE-ISSUER" name="submit">
                                                </div>                                                                                         
                                            </div>
                                        </form>
                                        
										<div class="clearfix"></div>
									</div>
									
				            </div>
						</div>
					</div>
				</div>
				<div class="menu-togggle-btn">
					<a href="#menu-toggle" id="menu-toggle" style="margin-left:-15px;"><i class="fa fa-bars"></i></a>
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