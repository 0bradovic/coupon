//  $(document).ready(function(){
//      $('.dropdown-content:not(:first)').hide();
//   $('.dropbtn').click(function(){
//       $('.dropbtn').css('text-decoration','none');
//       $(this).css('text-decoration','underline');
//       var id = $(this).data('id');
//     $('#'+id+'').slideToggle(1);
//   });
// });
$(document).ready(function(){
  $('.dropbtn').hover(function(){
    var id = $(this).data('id');
    $('#'+id+'').children().removeClass('d-none');
     },function(){
      var id = $(this).data('id');
      $('#'+id+'').children().addClass('d-none');
     }
    )
})
$(document).ready(function(){
  $('.dropdown-container').hover(function(){
    $(this).removeClass('d-none');
  },function(){
    $(this).addClass('d-none');
  })
})

$('a[href="#top"]').click(function(e) {
  $("html, body").animate({ scrollTop: "0px" }, 250);
});

$("#search").keyup(function(e) {
  $.ajax({
    url: SITE_URL + "search/" + e.target.value,
    type: "GET",
    success: function(data) {
      document.getElementById("serachDiv").classList.remove("disable");
      document.getElementById("serachDiv").innerHTML = "";
      var serachDiv = document.getElementById("serachDiv");
      var count = 0;
      data.forEach(element => {
        count++;
        if (count > 5) return;
        var elementDiv = document.createElement("div");
        elementDiv.innerHTML =
          "<a href='/offer/" +
          element.slug +
          "'><div class='search-div-1'> <img src='/public" +
          element.img_src +
          "'> <div class='articleText'> <p class='article'>" +
          element.name +
          "</p></div></div></a>";
        serachDiv.appendChild(elementDiv);
        document.getElementById("serachDiv").style.border = "1px solid #A5ACB2";
        ``;
      });
    }
  });
});

$(document).click(function() {
  document.getElementById("serachDiv").classList.add("disable");
});
$('#most-popular-btn').click(function(e){
  e.preventDefault();
  $('.newest-offers').addClass('dNone');
  $('.most-popular-offers').removeClass('dNone');
  $('.mostPopularOffers').removeClass('dNone991');
  $('.newestOffers').addClass('dNone991');
});
$('#newest-btn').click(function(e){
  e.preventDefault();
  $('.newest-offers').removeClass('dNone');
  $('.most-popular-offers').addClass('dNone');
  $('.mostPopularOffers').addClass('dNone991');
  $('.newestOffers').removeClass('dNone991');
});


