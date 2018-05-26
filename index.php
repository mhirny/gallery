<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery | Home</title>
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<!-- NAV -->

  <nav class="navbar navbar-default">
    <div class="container">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php"><img src="./img/palete_small_t.png" alt="Art!"></a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="navbar-collapse">
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
          <li><a href="cars.php">Cars</a></li>
          <li><a href="art.php">Art</a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "gallery";

            $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

            $sql = 'SELECT users.fname, users.lname, COUNT(basket.personID) AS in_basket FROM users, basket WHERE users.personID = "1" AND users.personID = basket.personID;';
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                // <span class="glyphicon glyphicon-shopping-cart" style="font-size:20px;"></span>
                // <span class="badge glyphicon glyphicon-shopping-cart" style="font-size:30px; line-height:30px;">  '.$row["in_basket"].'</span>
echo '
                <li><a href="#">
                  <span>'.$row["fname"].' '.$row["lname"].'</span>
                </a></li>
                <li><a href="#" style="padding-top:7px; padding-bottom:8px; ">

                  <span class="glyphicon glyphicon-shopping-cart" style="font-size:30px;"><span class="badge" style="margin-left:-23px; margin-top: -35px; background: rgb(121,207,169);">  '.$row["in_basket"].'</span></span>
                </a></li>
';
              }
            }
            mysqli_close($conn);
          ?>
        </ul>
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

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>