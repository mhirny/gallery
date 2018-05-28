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
<body>

<?php
function loadUser () {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "gallery";

    $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

    $sql = "SELECT * FROM users WHERE email='$loginEmail';"; // 'SELECT * FROM users WHERE email="'.$loginEmail.'";';
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $row['fname'].' '.$row['lname'];
        $_SESSION['userID'] = $row['personID'];
        $_SESSION['userPassword'] = $row['password'];
        echo '<script>console.log("Debug Objects: ' . $_SESSION['user'] . ' ");</script>';
      }
    }
    mysqli_close($conn);

 }
function loadBasket () {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $userID = $_SESSION['userID'];
  $sql = "SELECT COUNT(personID) AS in_basket FROM basket WHERE personID = '$userID';";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['in_basket'] = $row['in_basket'];
  }
  mysqli_close($conn);
}
if (isset($_POST['login'])) {
  loadUser();
  loadBasket();
  header('Location: .');
}
if (isset($_POST['logout'])) {
  unset($_SESSION['user']);
  unset($_SESSION['userID']);
  unset($_SESSION['userPassword']);
  unset($_SESSION['in_basket']);
  header('Location: .');
}
?>

<!-- NAV -->

  <nav class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="./img/palete_small_t.png" alt="Art!"></a>
      </div>

      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
          <li><a href="vehicles.php">Vehicles</a></li>
          <li><a href="art.php">Art</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php
            if (isset($_SESSION['user'])) {
              $user = $_SESSION['user'];
              $in_basket = $_SESSION['in_basket'];
              echo "<li style='padding:0; margin:0; height:50px;'><a style='padding:0; margin:0; href='#'><form method='post'><input href='#' type='submit' name='logout' value='Logout' style='width:100px; height: 50px; background: none; border: none;'>
                      
                    </input></form></a></li>
                    <li><a href='#'>
                      $user
                    </a></li>
                    <li><a href='#' style='padding-top:7px; padding-bottom:8px;'>";
              if ($in_basket > 0) {
                echo "<span class='glyphicon glyphicon-shopping-cart' style='font-size:30px;'><span
                        class='badge' style='margin-left:-23px; margin-top: -35px; background: rgb(121,207,169);'>$in_basket</span>
                      </span>";
              } else {
                echo "<span class='glyphicon glyphicon-shopping-cart' style='font-size:30px;'></span>";
              };
              echo "</a></li>";

            } else {
              echo "<li><a href='#' data-toggle='modal' data-target='#myModal'>Login</a></li>
                    <li><a href='#' data-toggle='modal' data-target='#myModal2'>Create account</a></li>";
            };
          ?>
        </ul>
<!--
        <ul class="nav navbar-nav navbar-right">
          <li style="padding:0; margin:0;"><div type="button" style="padding:4px 0 2px 0;" data-toggle="modal" data-target="#myModal">Login</div></li>
          <br>
          <li><a style="padding:2px;" href="#" data-toggle="modal" data-target="#myModal2">Sign in</a></li>
        </ul>
-->
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>

<!-- MAIN -->

  <main id="home-page">
    <div id="bgmain-top" class="zflexbox-center-vertical">
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

    <div id= "bg1" class="flexbox-center-vertical">
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

    <div id="bg2" class="flexbox-center-vertical">
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

    <div id="bgmain-bottom" class="flexbox-center-vertical">
      <div class="container">
        <div class="panel panel-default panel-transparent" >
          <div class="panel-heading">
            <div class="panel-title">
              Das Panel!
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>  Login:</h4>
      </div>
      <form action="index.php" method="post">
        <div class="modal-body">

          <input type="email" name="email" placeholder="Enter email..." style="width:100%">
          <br>
          <br>
          <input type="password" name="password" placeholder="Enter password..." style="width:100%">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="Submit" class="btn btn-primary" name="login" value="Login">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SIGNIN Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>