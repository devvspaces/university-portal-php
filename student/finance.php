<?php
include("header.php");
include("../class.php");
error_reporting(0);
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
<script type="text/javascript" src="print.js"></script>
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
					$level = $sh1['level'];
					$admission = $sh1['matric_no'];
					$college = $sh1['college'];
					$department = $sh1['department'];
					if ($img == "") {
						$img2 = "passport/default.png";
					} else {
						$img2 = $img;
					}
					$cal  = mysqli_query($con, "SELECT * FROM  calender ");
					$sh2 = mysqli_fetch_array($cal);
					$return2 = $sh2['session'];
					$return1 = $sh2['current_semester'];
					?>
					<div class="ig-area">
						<img src="<?php echo $img2 ?>" id="imgs" class="img-responsive dp" width="100px">
						<h4><?php echo $name1 ?></h4>
						<i><?php echo $class ?></i>
					</div>
				</div>
				<div class="rest">
					<div class="">
						<h2>Finances</h2>
					</div>
					<div class="">
						<div id="contentx">

							<h4> </h4>
							<h4 class="text-center">Financial Statement For <?php echo $name1 ?> For <?php echo $return2 . " session" ?></h4>
							<div class="col-lg-6 col-sm-12">
								<div class="table-responsive table-box">
									<table class="fee_tables table table-bordered table-striped">
										<tr>
											<th colspan="4">Fees Breakdown</th>
										</tr>
										<tr>
											<th>SN</th>
											<th>Fees</th>
											<th>Amount</th>
											<th>Action</th>
										</tr>
										<?php
										$total = $serial = 0;
										$sqlstr = "SELECT * FROM fees where college = '$college' and department = '$department' and level = '$level'  AND session = '$return2'";
										$stmt = $conn->prepare($sqlstr);
										$stmt->execute();
										$result = $stmt->get_result();
										while ($row = $result->fetch_assoc()) :
											extract($row);
											$serial++;
											$total += $amount;
											$action = "<a href='fees_choice.php?amount=$total' class='btn btn-pink'>make payment</a> ";
											if ($auth->countall5('paid_fees', 'fid', $sn, 'student', $matric_no) > 0) {
												$action = "Paid";
											}
										?>
											<tr>
												<td><?= $serial ?></td>
												<td><?= $title ?></td>
												<td><?= number_format($amount, 2) ?></td>
												<td><?= $action ?></td>
											</tr>
										<?php endwhile; ?>
										<?php
										$sql = "SELECT *, SUM(amount) AS TOTALPayment FROM fees where college = '$college' and department = '$department' and level = '$level'  AND session = '$return2'";
										$result = mysqli_query($con, $sql);
										$row = mysqli_fetch_array($result);
										$total =  $row['TOTALPayment'];
										?>
										<tr>
											<th>Total</th>
											<th><?php echo number_format($total, 2) ?></th>
											<th>
											</th>
											<th>
											</th>
										</tr>
									</table>
								</div>
							</div>
							<div class="col-lg-6 col-sm-12">
								<div class="table-responsive table-box">
									<table class="fee_tables table table-bordered table-striped">
										<tr>
											<th colspan="4">Payment History</th>
										</tr>
										<tr style="padding: 2px;">
											<th>SN</th>
											<th>Title</th>
											<th>Amount</th>
											<th>Date</th>
											<!-- <th>Act</th> -->
										</tr>
										<?php
										$total = $serial = 0;
										$sqlstr = "SELECT * FROM paid_fees where student = '$matric_no' AND session = '$return2'";
										$stmt = $conn->prepare($sqlstr);
										$stmt->execute();
										$result = $stmt->get_result();
										while ($row = $result->fetch_assoc()) :
											extract($row);
											$serial++;
											$title = $auth->select14('title', 'fees', 'sn', $fid);
										?>
											<tr>
												<td><?= $serial ?></td>
												<td><?= $title ?></td>
												<td><?= number_format($amount, 2) ?></td>
												<td><?= $dates ?></td>
											</tr>
										<?php endwhile; ?>
									</table>
								</div>

							</div>
							<div class="col-lg-12">
								<p class="text-center">&copy <?php echo date("Y") ?> <?php echo $name ?></p>
							</div>
						</div>
						<div class="col-lg-12">
							<p class="text-center"><button class="btn" onclick="generatePDF()"><span class="glyphicon glyphicon-print"></span> Print</button></p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include("footer.php") ?>
<script type="text/javascript" src='jquery.js'></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script>
	$(document).ready(function() {
		$('.fee_tables').DataTable({
			"processing": true,
		});
	});
</script>
</body>

</html>