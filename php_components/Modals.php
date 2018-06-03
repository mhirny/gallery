<?php
if (!isset($_SESSION['createErrors'])) {
  $_SESSION['createErrors'] = [];
}
?>
<?php
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
    };

  } else {
    $_SESSION['loginErrors'] = 'ErrNoAccount';
  };
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
  $regex = '/^[a-zA-Z]+$/';
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
?>

<?php
function login_modal_control ($redirectPage) {
  // LOGIN CANCEL
  if (isset($_POST['loginCancel'])) {
    unset($_SESSION['loginErrors']);
    header("Location: ./$redirectPage");
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
    header("Location: ./$redirectPage");
  }
}
?>

<?php
function create_account_modal_control ($redirectPage) {
  // CREATE CANCEL
  if (isset($_POST['createCancel'])) {
    $_SESSION['createErrors'] = [];
    header("Location: ./$redirectPage");
  }
  // CREATE ACCOUNT
  if (isset($_POST['createAccount'])) {
    $_SESSION['createErrors'] = [];
    isEmailValid($_POST['email']);
    isEmailUnused($_POST['email']);
    isUserNameValid($_POST['fname'], $_POST['lname']);
    if (sizeof($_SESSION['createErrors']) <= 0) {
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
    header("Location: ./$redirectPage");
  }
}
?>

<?php
// LOGIN MODAL
function login_modal ($formReturnPage) {

  if (isset($_SESSION['loginErrors'])) {
    echo "<div class='modal fade in' id='loginModal' tabindex='-1' role='dialog' aria-labelledby='Login modal' style='display: block; padding-right: 17px;'>";
  } else {
    echo "<div class='modal fade' id='loginModal' tabindex='-1' role='dialog' aria-labelledby='Login modal'>";
  }
?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <form action="<?=$formReturnPage?>" method="post">
        <div class="modal-header">
          <button type="Submit" name="loginCancel" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>  Login:</h4>
        </div>

        <div class="modal-body">
          <?php if (!isset($_SESSION['loginErrors'])) { // IF_1 ?>
                  <div class='input-group'>
                    <span class='input-group-addon'>Login-email:</span>
                    <input type='email' name='email' class='form-control' placeholder='Enter email...'>
                  </div>
                  <br>
                  <div class='input-group'>
                    <span class='input-group-addon'>Password:</span>
                    <input type='password' name='password' class='form-control' placeholder='Enter password...'>
                  </div>
          <?php } else { // IF_1 ELSE
            $prevEmail = $_SESSION['loginPrevVal']['prevEmail'];
            $prevPassword = $_SESSION['loginPrevVal']['prevPassword'];
            $unknowmError = $_SESSION['loginErrors'];

            if ($_SESSION['loginErrors'] == 'ErrNoAccount') { // IF_2 :NESTED?>
                    <div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control bg-danger' value='<?=$prevEmail?>' placeholder='Enter email...'>
                    </div>
                    <span style='color: red;'>Error: Account Don't Exist</span>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control' value='<?=$prevPassword?>' placeholder='Enter password...'>
                    </div>
            <?php } else if ($_SESSION['loginErrors'] == 'ErrWrongPassword') { // IF_2 ELIF ?>
                    <div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control' value='<?=$prevEmail?>' placeholder='Enter email...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control bg-danger' value='<?=$prevPassword?>' placeholder='Enter password...'>
                    </div>
                    <span style='color: red;'>Error: Wrong Password</span>
            <?php } else { // IF_2 ELSE ?>
                    <div class='input-group'>
                      <span class='input-group-addon'>Login-email:</span>
                      <input type='email' name='email' class='form-control' value='<?=$prevEmail?>' placeholder='Enter email...'>
                    </div>
                    <br>
                    <div class='input-group'>
                      <span class='input-group-addon'>Password:</span>
                      <input type='password' name='password' class='form-control' value='<?=$prevPassword?>' placeholder='Enter password...'>
                    </div>
                    <span style='color: red;'>Error: Unknow Login Error<br><?=$unknowmError?></span>
            <?php } // IF_2 END
          }; // IF_1 END ?>
        </div>

        <div class="modal-footer">
          <button type="Submit" name="loginCancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="Submit" class="btn btn-primary" name="login" value="Login">Login</button>
        </div>
      </form>

    </div>
  </div>

</div info='End DIV from if()'>
<?php
} // login_modal FUNCTION END
?>

<!-- CREATE ACCOUNT Modal -->
<?php
function create_account_modal ($formReturnPage) {
  if (sizeof($_SESSION['createErrors']) > 0) {
    echo "<div class='modal fade in' id='createAccountModal' tabindex='-1' role='dialog' aria-labelledby='Create account modal' style='display: block; padding-right: 17px;'>";
  } else {
    echo "<div class='modal fade' id='createAccountModal' tabindex='-1' role='dialog' aria-labelledby='Create account modal'>";
  }
?>
  <div class="modal-dialog" role="document">
    <div class="modal-content">

     <form action="<?=$formReturnPage?>" method="post">
        <div class="modal-header">
          <button type="Submit" name="createCancel" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-user"></span>  Create Account:</h4>
        </div>

        <div class="modal-body">
          <?php if (sizeof($_SESSION['createErrors']) <= 0) { // IF_1 ?>
                    <div class='input-group'>
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
                    </div>
            <?php } else { //IF_1 ELSE
              $prevFname = $_SESSION['createPrevVal']['prevFname'];
              $prevLname = $_SESSION['createPrevVal']['prevLname'];
              $prevEmail = $_SESSION['createPrevVal']['prevEmail'];
              $prevPassword = $_SESSION['createPrevVal']['prevPassword'];

              if (in_array('ErrFirstNameFormat', $_SESSION['createErrors'])) { // IF_2 ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>First name:</span>
                        <input type='text' name='fname' class='form-control bg-danger' value='<?=$prevFname?>' placeholder='Enter First name...'>
                      </div>
                      <span style='color: red;'>Error: Wrong First name</span>
                      <br>
              <?php } else { // IF_2 ELSE ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>First name:</span>
                        <input type='text' name='fname' class='form-control' value='<?=$prevFname?>' placeholder='Enter First name...'>
                      </div>
                      <br>
              <?php } // IF_2 END
              if (in_array('ErrLastNameFormat', $_SESSION['createErrors'])) { // IF_3 ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Last name:</span>
                        <input type='text' name='lname' class='form-control bg-danger' value='<?=$prevLname?>' placeholder='Enter Last name...'>
                      </div>
                      <span style='color: red;'>Error: Wrong Last name</span>
                      <br>
              <?php } else { // IF_3 ELSE ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Last name:</span>
                        <input type='text' name='lname' class='form-control' value='<?=$prevLname?>' placeholder='Enter Last name...'>
                      </div>
                      <br>
              <?php } // IF_3 END
              if (in_array('ErrEmailFormat', $_SESSION['createErrors'])) { // IF_4 ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control bg-danger' value='<?=$prevEmail?>' placeholder='Enter login-email...'>
                      </div>
                      <span style='color: red;'>Error: Wrong email addres</span>
                      <br>
              <?php } else if (in_array('ErrEmailAlreadyUsed', $_SESSION['createErrors'])) { // IF_4 ELIF ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control bg-danger' value='<?=$prevEmail?>' placeholder='Enter login-email...'>
                      </div>
                      <span style='color: red;'>Error: This email adress is already in use</span>
                      <br>
              <?php } else { // IF_4 ELSE ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Login-email:</span>
                        <input type='email' name='email' class='form-control' value='<?=$prevEmail?>' placeholder='Enter login-email...'>
                      </div>
                      <br>
              <?php } // IF_4 END
              if (in_array('ErrPasswordStrength', $_SESSION['createErrors'])) { // IF_5 ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Password:</span>
                        <input type='password' name='password' class='form-control bg-danger' value='<?=$prevPassword?>' placeholder='Enter password...'>
                      </div>
                      <span style='color: red;'>Error: Password too weak</span>
              <?php } else { // IF_5 ELSE ?>
                      <div class='input-group'>
                        <span class='input-group-addon'>Password:</span>
                        <input type='password' name='password' class='form-control' value='<?=$prevPassword?>' placeholder='Enter password...'>
                      </div>
              <?php } // IF_5 END

            } // IF_1 END
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
<?php
} // create_account_modal FUNCTION END
?>

<?php
// BODY
function modal_body_control_open_body_tag ($pageNameID) {
  if (isset($_SESSION['loginErrors']) || sizeof($_SESSION['createErrors']) > 0) {
    echo "<body id='$pageNameID' class='modal-open' style='padding-right: 17px;'>";
  } else {
    echo "<body id='$pageNameID'>";
  }
}
?>

<?php
function modal_body_control_end () {
  if (isset($_SESSION['loginErrors']) || sizeof($_SESSION['createErrors']) > 0) {
    echo "<div class='modal-backdrop fade in'></div>";
  }
}
?>