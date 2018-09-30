<?php

global $id;

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $url = "http://localhost/FootballAPI/API/match/readMatchById.php";
//Initiate cURL.
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'id' => $_GET['id']
    );

    $jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
    global $match;
    $json = curl_exec($ch);
    $json = json_decode($json, true);
    $json = $json["matches"];
    $match = $json[0];
    curl_close($ch);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $url = "http://localhost/FootballAPI/API/event/create.php";
    //Initiate cURL.
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'type' => $_POST['type'],
        'minute' => $_POST['minute'],
        'team' => $_POST['team'],
        'player' =>  $_POST['player'],
        'assist' => $_POST['assist'],
        'match_id' => $_POST['match_id'],
    );

    $jsonDataEncoded = json_encode($jsonData);

//Tell cURL that we want to send a POST request.
    curl_setopt($ch, CURLOPT_POST, 1);

//Attach our encoded JSON string to the POST fields.
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//Set the content type to application/json
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

//Execute the request
    $result = curl_exec($ch);
    curl_close($ch);



    header("Location matchEvents.php");
}


?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>اضافة حدث</title>

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet" media="all">
    <link href="vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
<div class="page-wrapper">

    <!-- PAGE CONTAINER-->
    <div class="page-container">

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">
                                        <h3 class="text-center title-2">اضافة حدث</h3>
                                    </div>
                                    <!--<button class="au-btn au-btn-icon au-btn--blue" onclick="location.href='index.php'">
                                        الصفحة الرئيسية</button>-->
                                    <hr>
                                    <form action="addNewEvent.php" method="post" name="addEventForm" onsubmit="return validateForm()" >

                                        <div class="form-group"  style="display: none;">
                                            <label for="cc-payment" class="control-label mb-1">Match Id</label>
                                            <input id="cc-pament" name="match_id" type="text" class="form-control" aria-required="true" aria-invalid="false"
                                            value="<?php echo $match['id']?>">
                                        </div>

                                        <div class="form-group has-success">
                                            <label for="cc-name" class="control-label mb-1">نوع الحدث</label>
                                            <select name="type" dir="rtl" class="form-control">
                                                <!--Print All the Leagues In the selection-->
                                                <option value="goal">هدف</option>
                                                <option value="subst">تبديل</option>
                                                <option value="yellowcard">كارت اصفر</option>
                                                <option value="redcard">كارت احمر</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">الدقيقة</label>
                                            <input id="cc-pament" name="minute" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>

                                        <div class="form-group has-success">
                                            <label for="cc-name" class="control-label mb-1">الفريق</label>
                                            <select name="team" dir="rtl" class="form-control">
                                                <!--Print All the Leagues In the selection-->
                                                <?php

                                                echo "<option value=\"localteam\">".$match['localteam_name']."</option>";
                                                echo "<option value=\"visitorteam\">".$match['visitorteam_name']."</option>";

                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">اسم اللاعب</label>
                                            <input id="cc-pament" name="player" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">صانع اللعبة</label>
                                            <input id="cc-pament" name="assist" type="text" class="form-control" aria-required="true" aria-invalid="false">
                                        </div>

                                        <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block">
                                            <span id="payment-button-amount">اضافة</span>
                                        </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<!-- Jquery JS-->
<script src="vendor/jquery-3.2.1.min.js"></script>
<!-- Bootstrap JS-->
<script src="vendor/bootstrap-4.1/popper.min.js"></script>
<script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
<!-- Vendor JS       -->
<script src="vendor/slick/slick.min.js">
</script>
<script src="vendor/wow/wow.min.js"></script>
<script src="vendor/animsition/animsition.min.js"></script>
<script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
</script>
<script src="vendor/counter-up/jquery.waypoints.min.js"></script>
<script src="vendor/counter-up/jquery.counterup.min.js">
</script>
<script src="vendor/circle-progress/circle-progress.min.js"></script>
<script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="vendor/chartjs/Chart.bundle.min.js"></script>
<script src="vendor/select2/select2.min.js">
</script>

<!-- Main JS-->
<script src="js/main.js"></script>
<script>
    function validateForm() {
        /*var fn = document.forms["addFeatureForm"]["feature_name"].value;
        var va = document.forms["addFeatureForm"]["verification_aspects"].value;
        var sa = document.forms["addFeatureForm"]["suggested_activities"].value;
        if (fn == "" || va == "" || sa == "") {
            alert("Please fill all the fields");
            return false;
        }*/
        return true;
    }
</script>

</body>

</html>
<!-- end document-->