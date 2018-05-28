<?php
  session_start();

    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "gallery";

    $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

    $sql = 'SELECT fname, lname FROM users WHERE email="'.$loginEmail.'";';
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user'] = $row['fname'].' '.$row['lname'];
        echo '<script>console.log("Debug Objects: ' . $_SESSION['user'] . ' ");</script>';
      }
    }
    mysqli_close($conn);

?>

<?php
function testtis() {
    $loginEmail = $_POST['email'];
    $loginPassword = $_POST['password'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "gallery";

    $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

    $sql = 'SELECT * FROM users WHERE email="'.$loginEmail.'";';
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
    // echo '<script>document.getElementById("userName").innerHTML="'.$_SESSION['user'].'";</script>';
 }
function loadBasket () {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());

  $sql = 'SELECT users.fname, users.lname, COUNT(basket.personID) AS in_basket FROM users, basket WHERE users.personID = "'.$_SESSION["userID"].'" AND users.personID = basket.personID;';
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

if ($row['in_basket'] > 0) { 
        echo ' <span class="badge" style="margin-left:-23px; margin-top: -35px; background: rgb(121,207,169);">  '.$row["in_basket"].'</span>';
} else {
echo '<span class="glyphicon glyphicon-shopping-cart" style="font-size:30px;"></span>';
}
    }
  }
  mysqli_close($conn);
}
if (isset($_POST['submit'])) {
  testtis();
}
?>

<?php
function testtis() {
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
    // echo '<script>document.getElementById("userName").innerHTML="'.$_SESSION['user'].'";</script>';
 }
function loadBasket () {
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "gallery";

  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());
  $userID = $_SESSION['userID'];
  $sql = "SELECT users.fname, users.lname, COUNT(basket.personID) AS in_basket FROM users, basket WHERE users.personID = '$userID' AND users.personID = basket.personID;";
  $result = mysqli_query($conn, $sql);

  if (mysqli_num_rows($result) > 0) {
    while($row = mysqli_fetch_assoc($result)) {

if ($row['in_basket'] > 0) { 
        echo ' <span class="badge" style="margin-left:-23px; margin-top: -35px; background: rgb(121,207,169);">  '.$row["in_basket"].'</span>';
} else {
echo '<span class="glyphicon glyphicon-shopping-cart" style="font-size:30px;"></span>';
}
    }
  }
  mysqli_close($conn);
}
if (isset($_POST['submit'])) {
  testtis();
}
?>