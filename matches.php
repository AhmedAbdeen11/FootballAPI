<?php


//checkLogin();
checkDeleteRequest();
checkDeleteAllMatchesRequest();
getLeagueName();
getMatches();



/*function checkLogin(){
    if(session_id() == '' || !isset($_SESSION)){
        session_start();
    }

    if (!$_SESSION['loggedIn']) {
        header('Location: login.php');
    }
}
}*/

function checkDeleteRequest(){
    if(isset($_GET['id'])){
        deleteMatch($_GET['id']);
    }
}

function checkDeleteAllMatchesRequest(){
    if(isset($_GET['deleteAllMatches'])){
        deleteAllMatches($_GET['league_id']);
    }
}

function getLeagueName(){
    $url = "http://localhost/FootballAPI/API/league/readLeagueName.php";
//Initiate cURL.
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'id' => $_GET['league_id']
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
    global $league_name;
    $league_name = curl_exec($ch);
    curl_close($ch);
}

function getMatches(){
    $url = "http://localhost/FootballAPI/API/match/readMatchesByLeagueId.php";
//Initiate cURL.
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'league_id' => $_GET['league_id']
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
    global $json;
    $json = curl_exec($ch);
    $json = json_decode($json, true);
    curl_close($ch);
}

function deleteMatch($id){
    $url = "http://localhost/FootballAPI/API/match/delete.php";
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'id' => $id
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
    $json = curl_exec($ch);
    $json = json_decode($json, true);
    curl_close($ch);
}

function deleteAllMatches($league_id){
    $url = "http://localhost/FootballAPI/API/match/deleteAllMatchesByLeagueId.php";
    $ch = curl_init($url);

    //The JSON data.
    $jsonData = array(
        'league_id' => $league_id
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
    $json = curl_exec($ch);
    $json = json_decode($json, true);
    curl_close($ch);
}

function getFormatedTime($timestamp){
    $timestamp = strtotime($timestamp);
    $day_night_txt = "";

    $hours = date('H', $timestamp);
    if($hours > 12)
        $day_night_txt = "مساءا";
    else
        $day_night_txt = "صباحا";

    $time = date('h:i', $timestamp);
    return $time. " " . $day_night_txt;
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
    <title>Football App</title>
    <link rel="icon">

    <!-- Fontfaces CSS-->
    <link href="css/font-face.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
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
<div>

    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="section__content section__content--p30">
                <div class="container-fluid">

                    <div class="row" style="margin-bottom: 50px">
                        <div class="col-md-20">
                            <div class="overview-wrap">
                                <h2 class="title-1">
                                    <?php

                                    global $league_name;

                                    echo $league_name;

                                    ?>
                                </h2>

                                <button class="au-btn au-btn-icon au-btn--blue" style="margin-right: 200px" onclick="location.href='addNewMatch.php'">
                                    <i class="zmdi zmdi-plus"></i>
                                    اضافة مباراة</button>

                                <button class="au-btn au-btn-icon au-btn--blue" onclick="location.href='index.php'"
                                        style="margin-right: 40px">
                                    الصفحة الرئيسية</button>

                                <button class="au-btn au-btn-icon au-btn--blue" onclick="location.href='matches.php?league_id=<?php echo $_GET['league_id']?>&deleteAllMatches=true'"
                                        style="margin-right: 40px">
                                    حذف جميع المباريات</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-19">
                            <div class="table-responsive table--no-card m-b-40">
                                <table class="table table-borderless table-striped table-earning">
                                    <thead>
                                    <tr>
                                        <th>اسم الفريق صاحب الملعب</th>
                                        <th>اسم الفريق الضيف</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th class="text-right">احداث المباراة</th>
                                        <th class="text-right">تعديل</th>
                                        <th class="text-right">حذف</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <!--Print All the Matches-->
                                    <?php

                                    global $json;

                                    if(key_exists("matches", $json)) {
                                        foreach ($json['matches'] as $match){


                                            echo "<tr>
                                                    <td class=\"text-left\">".$match['localteam_name']."</td>
                                                    <td class=\"text-left\">".$match['visitorteam_name']."</td>
                                                    <td class=\"text-left\">".$match['date']."</td>
                                                    <td class=\"text-left\">".getFormatedTime($match['time'])."</td>
                                                    <td class=\"text-left\"><a href='matchEvents.php?match_id=".$match['id']."'>Match Events</a></td>
                                                    <td class=\"text-left\"><a href='updateMatch.php?id=".$match['id']."'>Update</a></td>
                                                    <td class=\"text-left\"><a href='matches.php?id=".$match['id']."&league_id=".$match['league_id']."'>Delete</a></td>
                                                </tr>";
                                            }
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
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
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
    $(document).ready(function(){
        $('input[type="date"]').change(function(){
            // alert(this.value);         //Date in full format alert(new Date(this.value));
            post('index.php', {date: this.value});
        });
    });


    function post(path, params, method) {
        method = method || "post"; // Set method to post by default if not specified.

        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);

        for(var key in params) {
            if(params.hasOwnProperty(key)) {
                var hiddenField = document.createElement("input");
                hiddenField.setAttribute("type", "hidden");
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }
</script>

</body>

</html>
<!-- end document-->

