<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery | Art</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<?php
$pageName = 'art.php';
$pageBodyID = 'art-page';
$pagePicturesTag = 'art';

include './Components/Db_connect.php';
include './Components/Navbar.php';
include './Components/Galery_panels.php';
include './Components/Cart.php';
include './Components/Modals.php';

login_modal_control("$pageName");
create_account_modal_control("$pageName");
logout_control("$pageName");
basket_control("$pageName");
?>

<!-- BODY -->
<body id=<?=$pageBodyID?> <?php modal_body_control_open_body_tag();?> >

<script src="js/jquery-3.3.1.min.js"></script>


<!-- NAVBAR -->
<?php navbar("$pageName"); ?>

<!-- MAIN -->
  <main>
    <div class="container">
      <div class="row">

<?php basket_error_alert("$pageName"); ?>

<?php galery_panels("$pagePicturesTag", "$pageName"); ?>

      </div>
    </div>
  </main>

<!-- Modals -->
<!-- LOGIN Modal -->
<?php login_modal("$pageName"); ?>
<!-- CREATE ACCOUNT Modal -->
<?php create_account_modal("$pageName"); ?>

<script src="js/bootstrap.min.js"></script>

<?php modal_body_control_end(); ?>

</body>
</html>