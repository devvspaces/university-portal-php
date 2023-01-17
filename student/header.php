<?php

include("../conn.php");
include("../class.php");

session_start();
if (!isset($_SESSION['users'])) {
    header("location:../index.php");
}

$name = "School";
$users = $_SESSION['users'];
$matric_no = $auth->select14('userid', 'users', 'userid2', $users);

$s1 = mysqli_query($con, "SELECT * FROM students where matric_no = '$matric_no'");
$sh1 = mysqli_fetch_array($s1);
$name1 = $sh1['lname'] . " " . $sh1['fname'] . " " . $sh1['mname'];
$img = $sh1['picture'];
if ($img == '') {
    $img1 = 'passport/default.png';
} else {
    $img1 = $img;
}
$img2 = $img1;
echo $img2;
$level = $sh1['level'];
$student = $sh1['matric_no'];

// Get amount of notification
$user = $_SESSION['users'];
$sl18 = mysqli_query($con, "SELECT * FROM notification  where matric_no = '$user' and status = '0' ");
$num1 = mysqli_num_rows($sl18);

// List of lists for the sidebar nav items
$nav_items = [
    [
        "icon" => "user",
        "name" => "Home",
        "link" => "home.php"
    ],
    [
        "icon" => "credit-card",
        "name" => "Finance",
        "link" => "finance.php",
    ],
    [
        "icon" => "database",
        "name" => "Course Registration",
        "link" => "course_reg.php",
    ],
    [
        "icon" => "book-open",
        "name" => "Courses",
        "link" => "subject.php",
    ],
    [
        "icon" => "clock",
        "name" => "Time table",
        "link" => "time_table.php",
    ],
    [
        "icon" => "user",
        "name" => "Profile",
        "link" => "profile.php",
    ],
    [
        "icon" => "file-text",
        "name" => "Result",
        "link" => "result.php",
    ],
    [
        "icon" => "monitor",
        "name" => "CBT",
        "link" => "https://hapacollege.org.ng/etest",
    ],
    [
        "icon" => "bell",
        "name" => "Notification <span class='badge badge-danger'>$num1</span>",
        "link" => "#",
    ],
];

// List of lists for the mini sidebar nav items
$mini_nave_items = [
    [
        "icon" => "lock",
        "name" => "Change password",
        "link" => "cpassword.php"
    ],
    [
        "icon" => "log-out",
        "name" => "Logout",
        "link" => "logout.php",
    ],
];

$role = "Student";

?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../extras/fonts.php') ?>

    <link href="logo.png" rel="icon">
    <link href="logo.png" rel="apple-touch-icon">

    <?php include('../extras/base_head.php') ?>

    <title>Hapa College | Student portal</title>
</head>

<body>
    <?php include('../extras/body.php') ?>
    <?php
    $user = $_SESSION['users'];
    $sl190 = mysqli_query($con, "SELECT * FROM notification  where matric_no = '$user' order by sn desc limit 4");
    while ($sh90 = mysqli_fetch_array($sl190)) {
        $snx = $sh90['sn'];
        $title = $sh90['title'];
        $body = $sh90['content'];
        $sender = $sh90['sender'];
        $date = $sh90['dates'];
        ?>
        <div class="modal fade bs-example-modal-sm<?php echo $snx ?>" tabindex="-1" role="dialog"
            aria-labelledby="mySmallModalLabel">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content" style="padding: 10px;">
                    <div class="modal-header">
                        <?php echo $title ?>
                    </div>
                    <?php echo $body ?>
                    <div class="modal-footer">
                        <p>From:<?php echo $sender ?></p>
                        <small>
                            <i>
                                <?php echo $date ?>
                            </i>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#bell').click(function () {
                var bell = "bell";
                $.ajax({
                    url: "upate.php",
                    method: "POST",
                    data: {
                        bell: bell
                    },
                    success: function (data) {
                        $(".badge").html(data)
                    }
                })
            })
        })
    </script>