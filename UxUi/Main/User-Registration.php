<?php
include_once '../../imports/need/session_setup.php';
redirect_if_logged_in();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Employee Registration | NEO Solution</title>
    <link rel="icon" type="image/png" href="https://www.svgrepo.com/show/373594/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../UxUi-Back/assets/css/portals/auth-portal.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <!-- Header component -->
    <?php
    include_once '../../imports/Company_Info/Company_Info_Variable_List.php';
    include_once '../../UxUi-Back/Common/header.php';
    $company_obj = new Company_Info_Variable_List();
    ?>

    <!-- Registration form content -->
    <?php
    include_once '../../UxUi-Back/Main/Main_User_Account_Create/JS/User_Registration_A_01_JS.php';
    include_once '../../UxUi-Back/Main/Main_User_Account_Create/User_Registration_A_01.php';
    ?>

    <!-- Footer component -->
    <?php include_once '../../UxUi-Back/Common/footer.php'; ?>
</body>

</html>