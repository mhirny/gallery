<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery | Vehicles</title>
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
          <li><a href="index.php">Home</a></li>
          <li class="active"><a href="vehicles.php">Vehicles <span class="sr-only">(current)</span></a></li>
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

  <main id="vehicles-page">
    <div id="bg"></div>
    <div class="container">
      <div class="row">


          <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $db = "gallery";

            $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

            $sql = 'SELECT pictures.name, pictures.location, pictures.description, pictures.price
            FROM pictures, tags
            WHERE tags.tag = "vehicle" AND pictures.picID = tags.picID;';
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
              // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
echo '
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                <div class="panel panel-default center-block">
                  <div class="panel-heading">
                    <h2>'.$row["name"].'</h2>
                    <img src="'.$row["location"].'" style="width: 100%;" class="thumbnail">
                  </div>
                  <div class="panel-body">
                    '.$row["description"].'
                  </div>
                  <div class="panel-footer">
                    <p class="text-right">Price: '.$row["price"].'$</p>
                  </div>
                </div>
              </div>
';
              }
            }
            mysqli_close($conn);
          ?>

        
      </div>
    </div>
  </main>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>