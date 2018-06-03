<?php
function galery_panels ($getTag) {
  $conn = dbConnect();
  $sql = "SELECT pictures.name, pictures.location, pictures.description, pictures.price, pictures.picID
          FROM pictures, tags
          WHERE tags.tag = '$getTag' AND pictures.picID = tags.picID;";
  $result = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result) > 0) { // IF_1
    while($row = mysqli_fetch_assoc($result)) {

      $picName = $row["name"];
      $description = $row["description"];
      $displayPrice = number_format($row["price"], 2);
      $location = $row["location"];
      $picID = $row['picID'];

      if (isset($_SESSION['userID'])) { // IF_2
        $userID = $_SESSION['userID'];
        $sql = "SELECT `personID` FROM basket WHERE picID = $picID AND personID = $userID;";
        $resultInBasket = mysqli_query($conn, $sql);
        $alreadyInBasket = mysqli_num_rows($resultInBasket) > 0 ? true : false;
      } // IF_2 END ?>

      <div class='col-xs-12 col-sm-6 col-md-6 col-lg-4'>
        <div class='panel panel-default center-block' id='<?=$picName?>'>
          <div class='panel-heading'>
            <h2><?=$picName?></h2>
            <img src='<?=$location?>' style='width: 100%;' class='thumbnail'>
          </div>
          <div class='panel-body'>
            <?=$description?>
          </div>
          <div class='panel-footer'>
            <form action='art.php#<?=$picName?>' method='post'>                    
              <input type='hidden' name='addToBasketPicID' value='<?=$picID?>'>
              <input type='hidden' name='scrollYPosition' value=''>
              <?php if (isset($_SESSION['userID']) && $alreadyInBasket) { // IF_3 ?>
              <button type='button' class='btn btn-success' name='alreadyInBasket' value='alreadyInBasket'>In Cart</button>
              <?php } else if (isset($_SESSION['user'])) { // IF_3 ELIF ?>
              <button type='Submit' class='btn btn-primary' name='addToBasket' value='addToBasket'>Add to Cart</button>
              <?php }; // IF_3 END?>
            </form>
            <p>Price: <?=$displayPrice?>$</p>
          </div>
        </div>
      </div>
<?php
    } // WHILE LOOP END
  } // IF_1 END
  mysqli_close($conn);
} // FUNCTION END
?>