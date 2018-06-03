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

include './php_components/Db_connect.php';
include './php_components/Navbar.php';
include './php_components/Galery_panels.php';
include './php_components/Cart.php';
include './php_components/Modals.php';

login_modal_control("$pageName");
create_account_modal_control("$pageName");
logout_control("$pageName");
basket_control("$pageName");
?>

<!-- BODY -->
<?php modal_body_control_open_body_tag("$pageBodyID"); // BODY ?>

<script src="js/jquery-3.3.1.min.js"></script>


<!-- NAVBAR -->
<?php navbar("$pageName"); ?>

<!-- MAIN -->
  <main>
    <div class="container">
      <div class="row">

<?php basket_error_alert("$pageName"); ?>

<?php galery_panels("$pagePicturesTag"); ?>

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