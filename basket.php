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
if (!isset($_SESSION['createErrors'])) {
  $_SESSION['createErrors'] = [];
}

function dbConnect ($servername = "localhost", $username = "root", $password = "", $db = "gallery") {
  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());
  return $conn;
}

function loadUser () {
  $loginEmail = $_POST['email'];
  $loginPassword = $_POST['password'];

  $conn = dbConnect();
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
    }

  } else {
    $_SESSION['loginErrors'] = 'ErrNoAccount';
  };
  mysqli_close($conn);
}

function loadBasket () {
  $conn = dbConnect();
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
    array_push($_SESSION['createErrors'], 'ErrEmailFormat');
  };
}

function isEmailUnused ($checkEmail) {
  $conn = dbConnect();
  $sql = "SELECT personID FROM users WHERE email = '$checkEmail';";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    array_push($_SESSION['createErrors'], 'ErrEmailAlreadyUsed');
  }
  mysqli_close($conn);
}

function isUserNameValid ($fname, $lname) {
  $regex = '/^[a-zA-Z]*$/';
  if (!preg_match($regex, $fname)) {
    array_push($_SESSION['createErrors'], 'ErrFirstNameFormat');
  };
  if (!preg_match($regex, $lname)) {
    array_push($_SESSION['createErrors'], 'ErrLastNameFormat');
  };
}

function addUser () {
  $conn = dbConnect();

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $sql = "INSERT INTO users (`fname`, `lname`, `email`, `password`) VALUES ('$fname','$lname','$email','$password');";
  if(mysqli_query($conn, $sql)) {
    echo '<script>console.log("Debug Objects OK: ' . $sql . ' ");</script>';
  } else {
    array_push($_SESSION['createErrors'], "ErrDBInsertFailure:<br>".mysqli_error($conn));
  };

  mysqli_close($conn);
}

function basketRemove () {
  $conn = dbConnect();

  $removePicID = $_POST['basketRemove'];
  $userID = $_SESSION['userID'];

  $sql = "DELETE FROM basket WHERE picID = $removePicID AND personID = $userID;";

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
  header('Location: ./basket.php');
}
// LOGIN
if (isset($_POST['login'])) {
  loadUser();
  if (!isset($_SESSION['loginErrors'])) {
    loadBasket();
  } else {
    $_SESSION['loginPrevVal'] = [
      'prevEmail' => $_POST['email'],
      'prevPassword'=> $_POST['password']
    ];
  };
  header('Location: ./basket.php');
}
// CREATE CANCEL
if (isset($_POST['createCancel'])) {
  $_SESSION['createErrors'] = [];
  header('Location: ./basket.php');
}
// CREATE ACCOUNT
if (isset($_POST['createAccount'])) {
  $_SESSION['createErrors'] = [];
  isEmailValid($_POST['email']);
  isEmailUnused($_POST['email']);
  isUserNameValid($_POST['fname'], $_POST['lname']);
  if (!isset($_SESSION['createErrors'])) {
    addUser();
  };
  if (sizeof($_SESSION['createErrors']) > 0) {
    $_SESSION['createPrevVal'] = [
    'prevFname' => $_POST['fname'],
    'prevLname' => $_POST['lname'],
    'prevEmail' => $_POST['email'],
    'prevPassword'=> $_POST['password']
    ];
  }
  header('Location: ./basket.php');
}
// LOGOUT
if (isset($_POST['logout'])) {
  // session_unset()
  unset($_SESSION['user']);
  unset($_SESSION['userID']);
  unset($_SESSION['userPassword']);
  unset($_SESSION['in_basket']);
  unset($_SESSION['loginErrors']);
  $_SESSION['createErrors'] = [];
  header('Location: ./index.php');
}
// BASKET REMOVE
if (isset($_POST['basketRemove'])) {
  basketRemove();
  loadBasket();
  header('Location: ./basket.php');
}
// BASKET ERROR CANCEL
if (isset($_POST['basketErrCancel'])) {
  unset($_SESSION['basketErrors']);
  header('Location: ./basket.php');
}
?>

<?php
// BODY
  if (isset($_SESSION['loginErrors']) || sizeof($_SESSION['createErrors']) > 0) {
    echo "<body id='basket-page' class='modal-open' style='padding-right: 17px;'>";
  } else {
    echo "<body id='basket-page'>";
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
          <li><a href="index.php">Home <span class="sr-only">(current)</span></a></li>
          <li><a href="vehicles.php">Vehicles</a></li>
          <li><a href="art.php">Art</a></li>
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
                    <li id='basket' class='active'>
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

  <main>

    <div class="container">
      <div class="row">

        <?php
          if (isset($_SESSION['basketErrors'])) {
            $basketError = $_SESSION['basketErrors'];
      echo "<form action='art.php' method='post' class='col-xs-12'>
              <div class='alert alert-danger' role='alert'>
                <button type='Submit' name='basketErrCancel' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                  Removing error!<br>$basketError
              </div>
            </form>";
          }
        ?>
        
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php
        if (isset($_SESSION['userID'])) {
          $conn = dbConnect();
          
          $userID = $_SESSION['userID'];

          $sql = "SELECT pictures.* FROM pictures, basket WHERE basket.personID = '$userID' AND pictures.picID = basket.picID;";
          $result = mysqli_query($conn, $sql);
        
          if (mysqli_num_rows($result) > 0) {
            $counter = 0;
            $totalPrice = 0;
            while ($row = mysqli_fetch_assoc($result)) {
              $picID = $row['picID'];
              $elementID = "menuElement$picID";
              $picName = $row['name']; // pic name + element id
              $picture = $row['location'];
              $description = $row['description'];
              $price = $row['price'];
              $displayPrice = number_format($row['price'], 2);
              $linkClass = $counter > 0 ? 'collapsed' : '';
              $tabClass = $counter > 0 ? 'collapse' : 'collapse in';
              $expanded = $counter > 0 ? 'false' : 'true';

              echo "
                <div class='panel panel-default'>
                  <div class='panel-heading' role='tab'>
                    <h4 class='panel-title'>
                      <a class='$linkClass' role='button' data-toggle='collapse' data-parent='#accordion'
                          href='#$elementID' aria-expanded='$expanded' aria-controls='$elementID'>
                        <span><img src='$picture'></span><span>$picName</span><span>$displayPrice$</span>
                      </a>
                      <form action='basket.php' method='post'>
                        <button type='Submit' name='basketRemove' value='$picID'>Remove</button>
                      </form>
                    </h4>
                  </div>
                  <div id='$elementID' class='panel-collapse $tabClass' role='tabpanel'>
                    <div class='panel-body'>
                      $description
                    </div>
                  </div>
                </div>";

              $totalPrice += $price;
              $counter++;
            };
          };
          mysqli_close($conn);

          $displayTotalPrice = number_format($totalPrice, 2);
          echo "<div class='well'>
                  <h4 class='text-right'>Total: $displayTotalPrice$</h4>
                  <button class='btn btn-primary pull-right' disabled>Purchase</button>
                  <div class='clearfix'></div>
                </div>";
        }
        ?>
        </div>

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
        <?php
          if (!isset($_SESSION['loginErrors'])) {
            echo "<div class='input-group'>
                    <span class='input-group-addon'>Login-email:</span>
                    <input type='email' name='email' class='form-control' placeholder='Enter email...'>
                  </div>
                  <br>
                  <div class='input-group'>
                    <span class='input-group-addon'>Password:</span>
                    <input type='password' name='password' class='form-control' placeholder='Enter password...'>
                  </div>";
          } else {
            $prevEmail = $_SESSION['loginPrevVal']['prevEmail'];
            $prevPassword = $_SESSION['loginPrevVal']['prevPassword'];
            $unknowmError = $_SESSION['loginErrors'];

            if ($_SESSION['loginErrors'] == 'ErrNoAccount') {
              echo "<div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control bg-danger' value='$prevEmail' placeholder='Enter email...'>
                    </div>
                    <span style='color: red;'>Error: Account Don't Exist</span>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control' value='$prevPassword' placeholder='Enter password...'>
                    </div>";
            } else if ($_SESSION['loginErrors'] == 'ErrWrongPassword') {
              echo "<div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control' value='$prevEmail' placeholder='Enter email...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control bg-danger' value='$prevPassword' placeholder='Enter password...'>
                    </div>
                    <span style='color: red;'>Error: Wrong Password</span>";
            } else {
              echo "<div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control' value='$prevEmail' placeholder='Enter email...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control' value='$prevPassword' placeholder='Enter password...'>
                    </div>
                    <span style='color: red;'>Error: Unknow Login Error<br>$unknowmError</span>";
            };

          };
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
  if (sizeof($_SESSION['createErrors']) > 0) {
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
          <?php
            if (sizeof($_SESSION['createErrors']) <= 0) {
              echo "<div class='input-group'>
                      <span class='input-group-addon'>First name:</span>
                      <input type='text' name='fname' class='form-control' placeholder='Enter First name...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Last name:</span>
                      <input type='text' name='lname' class='form-control' placeholder='Enter Last name...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control' placeholder='Enter login-email...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control' placeholder='Enter password...'>
                    </div>";

            } else {
              $prevFname = $_SESSION['createPrevVal']['prevFname'];
              $prevLname = $_SESSION['createPrevVal']['prevLname'];
              $prevEmail = $_SESSION['createPrevVal']['prevEmail'];
              $prevPassword = $_SESSION['createPrevVal']['prevPassword'];

              if (in_array('ErrFirstNameFormat', $_SESSION['createErrors'])) {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>First name:</span>
                        <input type='text' name='fname' class='form-control bg-danger' value='$prevFname' placeholder='Enter First name...'>
                      </div>
                      <span style='color: red;'>Error: Wrong First name</span>
                      <br>";
              } else {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>First name:</span>
                        <input type='text' name='fname' class='form-control' value='$prevFname' placeholder='Enter First name...'>
                      </div>
                      <br>";
              };
              if (in_array('ErrLastNameFormat', $_SESSION['createErrors'])) {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Last name:</span>
                        <input type='text' name='lname' class='form-control bg-danger' value='$prevLname' placeholder='Enter Last name...'>
                      </div>
                      <span style='color: red;'>Error: Wrong Last name</span>
                      <br>";
              } else {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Last name:</span>
                        <input type='text' name='lname' class='form-control' value='$prevLname' placeholder='Enter Last name...'>
                      </div>
                      <br>";
              };
              if (in_array('ErrEmailFormat', $_SESSION['createErrors'])) {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control bg-danger' value='$prevEmail' placeholder='Enter login-email...'>
                      </div>
                      <span style='color: red;'>Error: Wrong email addres</span>
                      <br>";
              } else if (in_array('ErrEmailAlreadyUsed', $_SESSION['createErrors'])) {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control bg-danger' value='$prevEmail' placeholder='Enter login-email...'>
                      </div>
                      <span style='color: red;'>Error: This email adress is already in use</span>
                      <br>";                
              } else {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control' value='$prevEmail' placeholder='Enter login-email...'>
                      </div>
                      <br>";
              };
              if (in_array('ErrPasswordStrength', $_SESSION['createErrors'])) {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Password:</span>
                        <input type='password' name='password' class='form-control bg-danger' value='$prevPassword' placeholder='Enter password...'>
                      </div>
                      <span style='color: red;'>Error: Password too weak</span>";
              } else {
                echo "<div class='input-group'>
                        <span class='input-group-addon'>Password:</span>
                        <input type='password' name='password' class='form-control' value='$prevPassword' placeholder='Enter password...'>
                      </div>";
              };

            };
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
    if (isset($_SESSION['loginErrors']) || sizeof($_SESSION['createErrors']) > 0) {
      echo "<div class='modal-backdrop fade in'></div>";
    }
  ?>

</body>
</html>