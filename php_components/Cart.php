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
} // basket_error_alert FUNCTION END
?>

<?php
function basket_panels ($pageName) { ?>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <?php if (isset($_SESSION['userID'])) { //IF_1
          $conn = dbConnect();
          
          $userID = $_SESSION['userID'];

          $sql = "SELECT pictures.* FROM pictures, basket WHERE basket.personID = '$userID' AND pictures.picID = basket.picID;";
          $result = mysqli_query($conn, $sql);
        
          if (mysqli_num_rows($result) > 0) { // IF_2
            $counter = 0;
            $totalPrice = 0;
            while ($row = mysqli_fetch_assoc($result)) { // WHILE_1
              $picID = $row['picID'];
              $elementID = "menuElement$picID";
              $picName = $row['name']; // pic name + element id
              $picture = $row['location'];
              $description = $row['description'];
              $price = $row['price'];
              $displayPrice = number_format($row['price'], 2);
              $linkClass = $counter > 0 ? 'collapsed' : '';
              $tabClass = $counter > 0 ? 'collapse' : 'collapse in';
              $expanded = $counter > 0 ? 'false' : 'true'; ?>

              <div class="panel panel-default">
                <div class="panel-heading" role="tab">
                  <h4 class="panel-title">
                    <a class="<?=$linkClass?>" role="button" data-toggle="collapse" data-parent="#accordion"
                        href="#<?=$elementID?>" aria-expanded="<?=$expanded?>" aria-controls="<?=$elementID?>">
                      <span><img src="<?=$picture?>"></span><span><?=$picName?></span><span><?=$displayPrice?>$</span>
                    </a>
                    <form action="<?=$pageName?>" method="post">
                      <button type="Submit" name="basketRemove" value="<?=$picID?>">Remove</button>
                    </form>
                  </h4>
                </div>
                <div id="<?=$elementID?>" class="panel-collapse <?=$tabClass?>" role="tabpanel">
                  <div class="panel-body">
                    <?=$description?>
                  </div>
                </div>
              </div>

              <?php
              $totalPrice += $price;
              $counter++;
            } // WHILE_1 END
          
            mysqli_close($conn);

            $displayTotalPrice = number_format($totalPrice, 2); ?>
              <div class="well">
                <h4 class="text-right">Total: <?=$displayTotalPrice?>$</h4>
                <button class="btn btn-primary pull-right" disabled>Purchase</button>
                <div class="clearfix"></div>
              </div>

          <?php } //IF_2 END
        } // IF_1 END ?>

      </div>
<?php
} // FUNCTION END
?>
