<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery | Home</title>
  <link rel="stylesheet" href="css/styles.css">
</head>

<?php
$pageName = 'index.php';
$pageBodyID = 'home-page';
$pagePicturesTag = null;

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

    <div id="bgmain-top">
      <div class="panel panel-default panel-transparent">
        <div class="panel-heading">
          Gallery
        </div>
      </div>
    </div>

    <section class="section-text container">
      <h2>Section One</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt, laudantium, quibusdam? Nobis, delectus, commodi, fugit amet tempora facere dolores nisi facilis consequatur, odio hic minima nostrum. Perferendis eos earum praesentium, blanditiis sapiente labore aliquam ipsa architecto vitae. Minima soluta temporibus voluptates inventore commodi cumque esse suscipit optio aliquam et, dolorem a cupiditate nihil fuga laboriosam fugiat placeat dignissimos! Unde eveniet placeat quisquam blanditiis voluptatem doloremque fugiat dolor repellendus ratione in. Distinctio provident dolorem modi cumque illo enim quidem tempora deserunt nostrum voluptate labore repellat quisquam quasi cum suscipit dolore ab consequuntur, ad porro earum temporibus. Laborum ad temporibus ex, omnis!
      </p>
    </section>

    <div id= "bg1">
      <div class="panel panel-default panel-transparent">
        <div class="panel-heading">
          Image Two Text
        </div>
      </div>
    </div>

    <section class="section-text container">
      <h2>Section Two</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt, laudantium, quibusdam? Nobis, delectus, commodi, fugit amet tempora facere dolores nisi facilis consequatur, odio hic minima nostrum. Perferendis eos earum praesentium, blanditiis sapiente labore aliquam ipsa architecto vitae. Minima soluta temporibus voluptates inventore commodi cumque esse suscipit optio aliquam et, dolorem a cupiditate nihil fuga laboriosam fugiat placeat dignissimos! Unde eveniet placeat quisquam blanditiis voluptatem doloremque fugiat dolor repellendus ratione in.
      </p>
    </section>

    <div id="bg2">
      <div class="panel panel-default panel-transparent">
        <div class="panel-heading">
          Image Three Text
        </div>
      </div>
    </div>

    <section class="section-text container">
      <h2>Section Three</h2>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt, laudantium, quibusdam? Nobis, delectus, commodi, fugit amet tempora facere dolores nisi facilis consequatur, odio hic minima nostrum. Perferendis eos earum praesentium, blanditiis sapiente labore aliquam ipsa architecto vitae. Minima soluta temporibus voluptates inventore commodi cumque esse suscipit optio aliquam et, dolorem a cupiditate nihil fuga laboriosam fugiat placeat dignissimos! Unde eveniet placeat quisquam blanditiis voluptatem doloremque fugiat dolor repellendus ratione in.
      </p>
    </section>

    <div id="bgmain-bottom">
      <div class="container">
        <div class="panel panel-default panel-transparent" >
          <div class="panel-heading">
            <div class="panel-title">
              Transparent Panel
            </div>
          </div>
          <div class="panel-body">
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Odio, suscipit.
          </div>
        </div>
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