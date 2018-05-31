$(document).ready(function(){
  $('.formAddToBasket').on('click', function(e){
     e.preventDefault() //this prevents the form from submitting normally, but still allows the click to 'bubble up'.
     
     //lets get our values from the form....
     let addToBasketPicID = $(this).find('.addToBasketPicID').val();
     let addToBasket = $(this).find('.addToBasket').val();
         
     //now lets make our ajax call
      $.ajax({
        type: "POST",
        url: "./art.php",
         data: { addToBasketPicID: addToBasketPicID, addToBasket: addToBasket }
      }).done(function() {
      
         //replace submit button with some text...
      });
      console.log('ere');
  });
});