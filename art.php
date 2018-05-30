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
function loadUser () {
  $loginEmail = $_POST['email'];
  $loginPassword = $_POST['password'];

  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $sql = "SELECT * FROM users WHERE email='$loginEmail';";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    unset($_SESSION['loginErrors']);
    $row = mysqli_fetch_assoc($result);
    if ($loginPassword == $row['password']) {
      $_SESSION['user'] = $row['fname'].' '.$row['lname'];
      $_SESSION['userID'] = $row['personID'];
      $_SESSION['userPassword'] = $row['password'];
      //echo '<script>console.log("Debug Objects: ' . $_SESSION['user'] . ' ");</script>';
    } else {
      $_SESSION['loginErrors'] = 'ErrWrongPassword';
    };

  } else {
    $_SESSION['loginErrors'] = 'ErrNoAccount';
  };
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

function isEmailValid ($checkEmail) {
  $regex = '/^.*@.*\..*$/';
  if (!preg_match($regex, $checkEmail)) {
    $_SESSION['createErrors'] = 'ErrEmailFormat';
  };
}

function isEmailUnused ($checkEmail) {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $sql = "SELECT personID FROM users WHERE email = '$checkEmail';";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    $_SESSION['createErrors'] = 'ErrEmailAlreadyUsed';
  }
  mysqli_close($conn);
}

function isUserNameValid ($fname, $lanme) {
  $regex = '/^[a-zA-Z]*$/';
  if (!preg_match($regex, $fname)) {
    $_SESSION['createErrors'] = 'ErrFirstNameFormat';
  };
  if (!preg_match($regex, $lname)) {
    $_SESSION['createErrors'] = 'ErrLastNameFormat';
  };
}

function addUser () {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "INSERT INTO users (`fname`, `lname`, `email`, `password`) VALUES ('$fname','$lname','$email','$password');";
  if(mysqli_query($conn, $sql)) {
    echo '<script>console.log("Debug Objects OK: ' . $sql . ' ");</script>';
  } else {
    $_SESSION['createErrors'] = "ErrDBInsertFailure:<br>".mysqli_error($conn);
  };

  mysqli_close($conn);
}

function addToBasket () {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $personID = $_SESSION['userID'];
  $picID = $_POST['addToBasketPicID'];

  $sql = "INSERT INTO basket (`personID`, `picID`, `amount`) VALUES ('$personID', '$picID', '1');";

  if(mysqli_query($conn, $sql)) {
    echo '<script>console.log("Debug Objects OK: ' . $sql . ' ");</script>';
  } else {
    $_SESSION['basketErrors'] = "ErrDBInsertFailure:<br>".mysqli_error($conn);
  };

  mysqli_close($conn);

}
// LOGIN CANCEL
if (isset($_POST['loginCancel'])) {
  unset($_SESSION['loginErrors']);
  header('Location: ./art.php');
}
// LOGIN
if (isset($_POST['login'])) {
  loadUser();
  if (!isset($_SESSION['loginErrors'])) {
    loadBasket();
  }
  header('Location: ./art.php');
}
// CREATE CANCEL
if (isset($_POST['createCancel'])) {
  unset($_SESSION['createErrors']);
  header('Location: ./art.php');
}
// CREATE ACCOUNT
if (isset($_POST['createAccount'])) {
  unset($_SESSION['createErrors']);
  isEmailValid($_POST['email']);
  isEmailUnused($_POST['email']);
  isUserNameValid($_POST['fname'], $_POST['lname']);
  if (!isset($_SESSION['createErrors'])) {
    addUser();
  };
  header('Location: ./art.php');
}
// LOGOUT
if (isset($_POST['logout'])) {
  // session_unset()
  unset($_SESSION['user']);
  unset($_SESSION['userID']);
  unset($_SESSION['userPassword']);
  unset($_SESSION['in_basket']);
  unset($_SESSION['loginErrors']);
  unset($_SESSION['createErrors']);
  unset($_SESSION['basketErrors']);
  header('Location: ./art.php');
}
// ADD TO BASKET
if (isset($_POST['addToBasket'])) {
  addToBasket();
  loadBasket();
  header('Location: ./art.php');
}

if (isset($_POST['basketErrCancel'])) {
  unset($_SESSION['basketErrors']);
  header('Location: ./art.php');
}
?>

<?php
// BODY
  if (isset($_SESSION['loginErrors']) || isset($_SESSION['createErrors'])) {
    echo "<body class='modal-open' style='padding-right: 17px;'>";
  } else {
    echo "<body>";
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
          <li><a href="index.php">Home</a></li>
          <li><a href="vehicles.php">Vehicles</a></li>
          <li class="active"><a href="art.php">Art <span class="sr-only">(current)</span></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
          <?php
            if (isset($_SESSION['user'])) {
              $user = $_SESSION['user'];
              $in_basket = $_SESSION['in_basket'];
              echo "<li class='nav-post-link'>
                      <a href='#'>
                        <form method='post'>
                          <input href='#' type='submit' name='logout' value='Logout'>
                        </form>
                      </a>
                    </li>
                    <li>
                      <a href='#'>$user</a>
                    </li>
                    <li id='basket'>
                      <a href='basket.php'>";
              if ($in_basket > 0) {
                echo "<span class='glyphicon glyphicon-shopping-cart'><span
                        class='badge'>$in_basket</span>
                      </span>";
              } else {
                echo "<span class='glyphicon glyphicon-shopping-cart'></span>";
              };
              echo "</a></li>";

            } else {
              echo "<li><a href='#' data-toggle='modal' data-target='#loginModal'>Login</a></li>
                    <li><a href='#' data-toggle='modal' data-target='#createAccountModal'>Create account</a></li>";
            };
          ?>
        </ul>

      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav>

<!-- MAIN -->

  <main id="art-page">
    <div id="bg"></div>
    <div class="container">
      <div class="row">
        <?php
          if (isset($_SESSION['basketErrors'])) {
            $basketError = $_SESSION['basketErrors'];
      echo "<form action='art.php' method='post' class='col-xs-12'>
              <div class='alert alert-danger' role='alert'>
                <button type='Submit' name='basketErrCancel' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Adding to Cart error!<br>$basketError
              </div>
            </form>";
          }
        ?>

        <?php
          $servername = "localhost";
          $username = "root";
          $password = "";
          $db = "gallery";
          $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());
          $sql = "SELECT pictures.name, pictures.location, pictures.description, pictures.price, pictures.picID
                  FROM pictures, tags
                  WHERE tags.tag = 'art' AND pictures.picID = tags.picID;";
          $result = mysqli_query($conn, $sql);
          if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {

              $name = $row["name"];
              $description = $row["description"];
              $price = $row["price"];
              $location = $row["location"];
              $picID = $row['picID'];

              $sql = "SELECT `personID` FROM basket WHERE picID = $picID;";
              $resultInBasket = mysqli_query($conn, $sql);
              $alreadyInBasket = mysqli_num_rows($resultInBasket) > 0 ? true : false;

        echo "<div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>
                <div class='panel panel-default center-block' id='$name'>
                  <div class='panel-heading'>
                    <h2>$name</h2>
                    <img src='$location' style='width: 100%;' class='thumbnail'>
                  </div>
                  <div class='panel-body'>
                    $description
                  </div>
                  <div class='panel-footer'>
                    <form action='art.php#$name' method='post'>                    
                      <input type='hidden' name='addToBasketPicID' value='$picID'/>";
              if (isset($_SESSION['user']) && $alreadyInBasket) {
                echo "<button type='button' class='btn btn-success' name='alreadyInBasket' value='alreadyInBasket'>In Cart</button>";
              } else if (isset($_SESSION['user'])) {
                echo "<button type='Submit' class='btn btn-primary' name='addToBasket' value='addToBasket'>Add to Cart</button>";
              };
              echo "</form>
                    <p>Price: $price\$</p>
                  </div>
                </div>
              </div>";
            }
          }
          mysqli_close($conn);
        ?>

      </div>
    </div>
 

  </main>

<!-- Modals -->
<!-- LOGIN Modal -->
<?php
  if (isset($_SESSION['loginErrors'])) {
    echo "<div class='modal fade in' id='loginModal' tabindex='-1' role='dialog' aria-labelledby='Login modal' style='display: block; padding-right: 17px;'>";
  } else {
    echo "<div class='modal fade' id='loginModal' tabindex='-1' role='dialog' aria-labelledby='Login modal'>";
  }
?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form action="art.php" method="post">
        <div class="modal-header">
          <button type="Submit" name="loginCancel" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>  Login:</h4>
        </div>

        <div class="modal-body">
          <div class="input-group">
            <span class="input-group-addon">Login-email:</span>
            <input type="email" name="email" class="form-control" placeholder="Enter email...">
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon">Password:</span>
            <input type="password" name="password" class="form-control" placeholder="Enter password...">
          </div>

          <?php
            if (isset($_SESSION['loginErrors'])) {
              echo "<br>";
              if ($_SESSION['loginErrors'] == 'ErrNoAccount') {
                echo "<div class='alert alert-danger text-center' role='alert'>Account Don't Exist</div>";
              } else if ($_SESSION['loginErrors'] == 'ErrWrongPassword') {
                echo "<div class='alert alert-danger text-center' role='alert'>Wrong Password</div>";
              } else {
                $unknownError = $_SESSION['loginErrors'];
                echo "<div class='alert alert-danger text-center' role='alert'>Unknown Login Error<br>$unknownError</div>";
              }
            }
          ?>
        </div>

        <div class="modal-footer">
          <button type="Submit" name="loginCancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="Submit" class="btn btn-primary" name="login" value="Login">Login</button>
        </div>
      </form>

    </div>
  </div>

</div>

<!-- CREATE ACCOUNT Modal -->
<?php
  if (isset($_SESSION['createErrors'])) {
    echo "<div class='modal fade in' id='createAccountModal' tabindex='-1' role='dialog' aria-labelledby='Create account modal' style='display: block; padding-right: 17px;'>";
  } else {
    echo "<div class='modal fade' id='createAccountModal' tabindex='-1' role='dialog' aria-labelledby='Create account modal'>";
  }
?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">

     <form action="art.php" method="post">
        <div class="modal-header">
          <button type="Submit" name="createCancel" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>  Create Account:</h4>
        </div>

        <div class="modal-body">
          <div class="input-group">
            <span class="input-group-addon">First name:</span>
            <input type="text" name="fname" class="form-control" placeholder="Enter First name...">
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon">Last name:</span>
            <input type="text" name="lname" class="form-control" placeholder="Enter Last name...">
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon">Login-email:</span>
            <input type="email" name="email" class="form-control" placeholder="Enter login-email...">
          </div>
          <br>
          <div class="input-group">
            <span class="input-group-addon">Password:</span>
            <input type="password" name="password" class="form-control" placeholder="Enter password...">
          </div>

          <?php
            if (isset($_SESSION['createErrors'])) {
              echo "<br>";
              if ($_SESSION['createErrors'] == 'ErrEmailFormat') {
                echo "<div class='alert alert-danger text-center' role='alert'>Wrong email addres</div>";
              } else if ($_SESSION['createErrors'] == 'ErrFirstNameFormat') {
                echo "<div class='alert alert-danger text-center' role='alert'>Wrong First name</div>";
              } else if ($_SESSION['createErrors'] == 'ErrLastNameFormat') {
                echo "<div class='alert alert-danger text-center' role='alert'>Wrong Last name</div>";
              } else if ($_SESSION['createErrors'] == 'ErrEmailAlreadyUsed') {
                echo "<div class='alert alert-danger text-center' role='alert'>This email adress is already in use</div>";
              } else {
                $unknownError = $_SESSION['createErrors'];
                echo "<div class='alert alert-danger text-center' role='alert'>Unknown Create Account Error!<br>$unknownError</div>";
              }
            }
          ?>
        </div>

        <div class="modal-footer">
          <button type="Submit" name="createCancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="Submit" class="btn btn-primary" name="createAccount" value="Create">Create account</button>
        </div>
      </form>

    </div>
  </div>
</div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <?php
    if (isset($_SESSION['loginErrors']) || isset($_SESSION['createErrors'])) {
      echo "<div class='modal-backdrop fade in'></div>";
    }
  ?>

</body>
</html>