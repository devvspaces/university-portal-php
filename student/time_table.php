<?php
include("header.php");
include("../class.php");
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script type="text/javascript" src="print2.js"></script>
<div class="container-fluid main-container">
	<div class="row main">
		<div class="col-lg-12 panel-container">
			<div class="panel">
				<div class="panel-heading panele" id="p_heading">
					<?php
					$users = $_SESSION['users'];
					$matric_no = $auth->select14('userid', 'users', 'userid2', $users);
					$s1  = mysqli_query($con, "SELECT * FROM students where matric_no = '$matric_no'");
					$sh1 = mysqli_fetch_array($s1);
					$name1 = $sh1['lname'] . " " . $sh1['fname'] . " " . $sh1['mname'];
					$img = $sh1['picture'];
					$admission = $sh1['matric_no'];
					$level = $sh1['level'];
					$s2  = mysqli_query($con, "SELECT * FROM  calender ");
					$sh2 = mysqli_fetch_array($s2);
					$sn = $sh2['sn'];
					$return2 = $sh2['session'];
					$return1 = $sh2['current_semester'];
					$name = $sh2['school_name'];

					?>
					<div class="ig-area">
						<img src="<?php echo $img ?>" id="imgs" class="img-responsive dp" width="100px">
						<h4><?php echo $name1 ?></h4>
						<i><?php echo $level ?> level</i>
					</div>
				</div>
				<div class="rest">
					<div class="">
						<div id="contentx">
							<h4 class="text-center"><b><?php echo $name ?></b><br>Time Table For <?php echo $level . ' level ' . $return2 ?></h4>
							<div class="table-responsive table-box">
								<table class="table table-bordered table-striped">
									<tr>
										<th>Day</th>
										<th>Schedule/subject
										</th>
										<?php
										$sql_time = mysqli_query($con, "SELECT * FROM time_table where class = '$class' and arm = '$arm' Group by day order by sn asc");
										while ($get = mysqli_fetch_array($sql_time)) {
											$day = $get['day'];
										?>
									<tr>
										<th><span style="writing-mode: vertical-lr;"><?php echo substr($day, 0, 3) ?></span></th>
										<th>
											<table class="table table-bordered">
												<tr>
													<?php
													$set_time = mysqli_query($con, "SELECT * FROM time_table where class = '$class' and arm = '$arm' and day = '$day' order by period asc ");
													while ($write = mysqli_fetch_array($set_time)) {
														$period = $write['period'];
														$subject_id = $write['subject_id'];
														$time_get = mysqli_query($con, "SELECT * FROM period_format where period = '$period' and day = '$day' ");
														$time_hold = mysqli_fetch_array($time_get);
														$start_time = $time_hold['start_time'];
														$end_time = $time_hold['end_time'];

														$subget = mysqli_query($con, "SELECT * FROM subject where sn = '$subject_id' ");
														$sub_show = mysqli_fetch_array($subget);
														$sub_code = $sub_show['code'];
														$sub_rel = $sub_show['title'];
													?>
														<th><small><?php echo $period ?> <br> (<?php echo date('g:i', strtotime($start_time)) . '-' . date('g:i', strtotime($end_time)) ?>)<br></small> <small>
																<hr> <?php echo $sub_code ?>
															</small></th>

													<?php
													}

													?>
												</tr>
											</table>
										</th>
									</tr>
									</tr>
								<?php
										}
								?>
								</table>
							</div>
						</div>
						<p class="text-center"><button class="btn" onclick="generatePDF()"><span class="glyphicon glyphicon-print"></span> Print</button></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include("footer.php") ?>
	<script type="text/javascript" src='jquery.js'></script>
	<script src="bootstrap/js/bootstrap.js"></script>

	</body>

	</html>