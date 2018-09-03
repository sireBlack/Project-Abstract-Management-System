<?php
	require_once('../backend/dbcon.php');
?>
<!doctype html>
<html lang="en">

<head>
	<title>Dashboard | Abstract Management</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<link rel="stylesheet" href="assets/vendor/chartist/css/chartist-custom.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="index.html"><img src="assets/img/logo-dark.png" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="assets/img/user.png" class="img-circle" alt="Avatar"> <span>Samuel</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li><a href="#"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="#"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						<li><a href="reviewAbstracts.php" class="active"><i class="lnr lnr-code"></i> <span>Review Abstracts</span></a></li>
						<li><a href="#" class=""><i class="lnr lnr-chart-bars"></i> <span>My Profile</span></a></li>
						<li><a href="#" class=""><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
						<li><a href="#" class=""><i class="lnr lnr-alarm"></i> <span>Logout</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-body">
							<div class="row">
                                <div class="col-md-12">
                                    <!-- BASIC TABLE -->
                                    <div class="panel">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">Submitted Abstracts</h3>
                                        </div>
                                        <div class="panel-body">
                                            <table class="table table-hover table-condensed">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
														<th>Abstract Title</th>
														<th>Abstract Author</th>
														<th>Author's E-mail</th>
														<!-- <th>Contact</th> -->
														<th>Status</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
													<?php
													$stmt = $conn -> prepare ("SELECT abstract.abstractID, abstract.userID, abstract.abstractTitle, abstract.filePath, users.userID, users.uniqueID, users.fullName, users.sex, users.userImage, users.address, users.email, users.phoneNumber FROM abstract LEFT JOIN users ON abstract.userID = users.uniqueID");
													$stmt -> execute();

													$sn = 1;
														while($result = $stmt -> fetch(PDO::FETCH_ASSOC)){
															?>
															<tr>
																<td><small><?php echo $sn; ?></small></td>
																<td><small><?php echo $result['abstractTitle']; ?></small></td>
																<td><small><?php echo $result['fullName']; ?></small></td>
																<td><small><?php echo $result['email']; ?></small></td>
																<!-- <td><small><?php echo $result['phoneNumber']; ?></small></td> -->
																<!-- <td>&nbsp;</td> -->
																<td><small>Reviewing</small></td>
																<td><a data-toggle = "modal" class="btn btn-info btn-sm" href="#viewFile<?php echo $result['uniqueID']; ?>" ><i class="fa fa-search-plus" title="View Author's profile"></i></a>

																<a download="<?php echo $result['fullName']; ?>" class="btn btn-danger btn-sm" href="<?php echo '../abstracts/'.$result['filePath']; ?>" title="View abstract" ><i class="fa fa-file-text"></i></a>

																<a data-toggle="modal" class="btn btn-primary btn-sm" title="Review abstract" href="#review<?php echo $result['uniqueID']; ?>"><i class=" fa fa-check-square"></i></a></td>
															</tr>
															<?php
															$sn++;

															?>

															<!--MODAL FOR AUTHOR'S PROFILE -->
															<div id="viewFile<?php echo $result['uniqueID']; ?>" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
																<div class="modal-dialog">
																	<!-- Modal content-->
																	<div class="modal-content">
																		<div class="modal-body">
																			<h3>AUTHOR's PROFILE</h3>
																			<form class="form-horizontal">
																				<div class="row">
																					<div class="col-lg-9">
																						<div class="form-group col-md-12">
																						<label for="">Author's Full Name</label>
																						<input type="text" class="form-control" disables value="<?php echo $result['fullName']; ?>">
																						</div>
																						<div class="form-group col-md-12">
																						<label for="">Author's Contact</label>
																						<input type="text" class="form-control" disables value="<?php echo $result['phoneNumber']; ?>">
																						</div>
																						<div class="form-group col-md-12">
																						<label for="">Author's E-mail Address</label>
																						<input type="text" class="form-control" disables value="<?php echo $result['email']; ?>">
																						</div>
																					</div>
																					<div class="col-lg-3">
																						<img src="<?php echo '../userImages/'.$result['userImage']; ?>" alt="Author's image" class="img-rounded" style="width: 100%; margin-top: 30px;">
																					</div>

																				</div>
																				
																			</form>
																		</div>
																		<div class="modal-footer">
																			<center>
																				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																			</center>
																		</div>
																	</div>
																</div>
															</div>

															<!--MODAL FOR REVIEWING -->
															<div id="review<?php echo $result['uniqueID']; ?>" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
																<div class="modal-dialog">
																	<!-- Modal content-->
																	<div class="modal-content">
																		<form action="">
																			<div class="modal-body">
																				<h3>REVIEW ABSTRACT - <b><?php echo $result['abstractTitle']; ?></b></h3><hr />
																				<div style="margin-bottom: 60px;">
																				<label for="">Enter your review score</label>
																				<input class="form-control col-md-6" type="text"  id="score" placeholder="Your score cannot be more than 100"/>

																				
																				<input type="hidden"  id="abID" value="<?php echo $result['abstractID']; ?>" />

																				<input type="hidden"  id="reID" value="1234" />

																				</div>
																			</div>
																			<div class="modal-footer">
																				<center>
																					<button class="btn btn-default" id = "addReview">Submit Review</button>
																					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
																				</center>
																			</div>
																		</form>
																		
																	</div>
																</div>
															</div>
															
															<?php
														}
													?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- END BASIC TABLE -->
                                </div>
                            </div>
						</div>
					</div>
					<!-- END OVERVIEW -->
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2018</p>
			</div>
		</footer>
	</div>

	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/vendor/chartist/js/chartist.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
</body>
</html>
