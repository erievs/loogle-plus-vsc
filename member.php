<?php include 'ui/elements/community/utils/member_start_up.php'; ?>

<?php include 'ui/elements/community/utils/member_data_stuff.php'; ?>


<?php include 'ui/elements/community/utils/member_sorter.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($_GET['username'])) { echo "" . htmlspecialchars($_GET['username']);}?> - Loogle+</title>
    <link rel="stylesheet" href="assets/css/materialize.min.css">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/p-sans.css">
    <link rel="stylesheet" href="assets/css/yours.css">
    <link rel="stylesheet" href="assets/css/sidebar.css">
    <link rel="stylesheet" href="assets/css/member.css">
</head>
<body>

<?php include 'ui/elements/community/nav-bar-with-search_m.php'; ?>

<?php include 'ui/elements/community/community-suggestions.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>



<?php include 'ui/elements/sidebar.php'; ?>

</body>
</html>