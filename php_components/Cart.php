<?php
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

function addToBasket () {
  $conn = dbConnect();

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
?>

<?php
function basket_control($redirectPage) {
  // ADD TO BASKET
  if (isset($_POST['addToBasket'])) {
    addToBasket();
    loadBasket();
    header("Location: ./$redirectPage");
  }
  // BASKET ERROR CANCEL
  if (isset($_POST['basketErrCancel'])) {
    unset($_SESSION['basketErrors']);
    header("Location: ./$redirectPage");
  }
}
?>

<?php
function basket_error_alert ($formReturnPage) {
  if (isset($_SESSION['basketErrors'])) { // IF_1
    $basketError = $_SESSION['basketErrors']; ?>
    <form action='<?=$formReturnPage?>' method='post' class='col-xs-12'>
      <div class='alert alert-danger' role='alert'>
        <button type='Submit' name='basketErrCancel' class='close' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
          Adding to Cart error!<br><?=$basketError?>
      </div>
    </form>
<?php
  } // END of IF_1
} // FUNCTION END
?>
