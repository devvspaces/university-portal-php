<?php
include("header.php");
include("../class.php");
?>
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
					if ($img == '') {
						$img1 = 'passport/default.png';
					} else {
						$img1 = $img;
					}
					$level = $sh1['level'];
					$admission = $sh1['matric_no'];
					$s2  = mysqli_query($con, "SELECT * FROM  calender ");
					$sh2 = mysqli_fetch_array($s2);
					$sn = $sh2['sn'];
					$return2 = $sh2['session'];
					$return1 = $sh2['current_semester'];

					?>
					<div class="ig-area">
						<img src="<?php echo $img1 ?>" id="imgs" class="img-responsive dp" width="100px">
						<h4><?php echo $name1 ?></h4>
						<i><?php echo $level ?> level</i>
					</div>
				</div>
				<div class="rest">
					<div class="">
						<h4><span class="glyphicon glyphicon-book"></span> Registered Courses</h4>
						<div class="panel-body">

							<ul class="list-group">
								<li class="list-group-item">
									<h4></span>Registered Courses</h4>
								</li>
								<?php
								$serial = 0;
								$el_show = mysqli_query($con, "SELECT * FROM course_registration where matric_no = '$matric_no' and session = '$return2' and semester = '$return1' ");
								if (!$el_show) {
									die(mysqli_error($con));
								}
								while ($el_show2 = mysqli_fetch_array($el_show)) {
									$serial++;
									$unit = $el_show2['unit'];
									$x = 'unit';
									if ($unit > 1) {
										$x = 'units';
									}
									$course_code = $el_show2['course_code'];
									$name = $auth->select14('title', 'course', 'code', $course_code);
									echo "<a class='list-group-item' href = 'view_subject.php?is=$course_code' style='color:#5a738e;' ><h5>$serial. $name ($unit $x) </h5> </a>  ";
								}
								?>
							</ul>

						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="pop"></div>
		<?php include("footer.php") ?>
		<script type="text/javascript" src='jquery.js'></script>
		<script src="bootstrap/js/bootstrap.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".btn-select").click(function() {
					var subject_id = $(this).attr("data");
					var student = "<?php echo $admission ?>";
					$(this).attr("disabled");
					$.ajax({
						method: "POST",
						url: "register.php",
						data: {
							subject_id: subject_id,
							student: student
						},
						success: function(data) {
							window.location.reload();
						}
					})
				})
			})
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(".btn-remove").click(function() {
					var sbjid = $(this).attr("data");
					var student = "<?php echo $admission ?>";
					$.ajax({
						method: "POST",
						url: "del_register.php",
						data: {
							sbjid: sbjid,
							student: student
						},
						success: function(data) {
							alert(data);
							//window.location.reload();
						}
					})
				})
			})
		</script>
		</body>

		</html>