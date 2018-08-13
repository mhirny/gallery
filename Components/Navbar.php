<?php
function logout_control($redirectPage) {
  if (isset($_POST['logout'])) {
    // session_unset()
    unset($_SESSION['user']);
    unset($_SESSION['userID']);
    unset($_SESSION['userPassword']);
    unset($_SESSION['in_basket']);
    unset($_SESSION['loginErrors']);
    $_SESSION['createErrors'] = [];
    unset($_SESSION['basketErrors']);
    header("Location: ./$redirectPage");
  }
}
?>

<?php
function navbar ($activeLink) {
?>
  <nav class='navbar navbar-default'>
    <div class='container'>

      <div class='navbar-header'>
        <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar-collapse' aria-expanded='false'>
          <span class='sr-only'>Toggle navigation</span>
          <span class='icon-bar'></span>
          <span class='icon-bar'></span>
          <span class='icon-bar'></span>
        </button>
        <a class='navbar-brand' href='index.php'><img src='./img/palete_small_t.png' alt='Art!'></a>
      </div>

      <div class='collapse navbar-collapse' id='navbar-collapse'>
        <ul class='nav navbar-nav'>
          <li><a href='index.php'>Home</a></li>
          <li><a href='vehicles.php'>Vehicles</a></li>
          <li><a href='art.php'>Art</a></li>
        </ul>

        <ul class='nav navbar-nav navbar-right'>
          <?php if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $in_basket = $_SESSION['in_basket']; ?>
            <li class='nav-post-link'>
              <a href='#'>
                <form method='post'>
                  <input href='#' type='submit' name='logout' value='Logout'>
                </form>
              </a>
            </li>
            <li>
              <a href='#'><?=$user?></a>
            </li>
            <li id='basket'>
              <a href='basket.php'>
                <?php if ($in_basket > 0) { ?>
                <span class='glyphicon glyphicon-shopping-cart'><span class='badge'><?=$in_basket?></span></span>
                <?php } else { ?>
                <span class='glyphicon glyphicon-shopping-cart'></span>
                <?php } ?>
              </a>
            </li>
           <?php } else { ?>
            <li><a href='#' data-toggle='modal' data-target='#loginModal'>Login</a></li>
            <li><a href='#' data-toggle='modal' data-target='#createAccountModal'>Create account</a></li>
           <?php } ?>
        </ul>
      </div>

    </div>
  </nav>
<!--<script src='js/jquery-3.3.1.min.js'></script>-->
<script>
  let link = $(".nav li a[href*='<?=$activeLink?>' i]");
  link.parent().addClass("active");
  link.parent().append(" <span class='sr-only'>(current)</span>");
</script>
<?php } ?>