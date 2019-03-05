$('a[href="#top"]').click(function(e) {
  $("html, body").animate({ scrollTop: "0px" }, 250);
});
$(document).ready(function(){
  $('.dropbtn').click(function(){
    $('.dropdown-content').slideToggle(200)
  })
})
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

$(document).ready(function() {
  $(function() {
    var $sidebar = $(".sidebar_offers"),
      $window = $(window),
      offset = $sidebar.offset(),
      topPadding = 15;

    $window.scroll(function() {
      if ($window.scrollTop() > offset.top) {
        $sidebar.stop().animate({
          marginTop: $window.scrollTop() - offset.top + topPadding + 20
        });
      } else {
        $sidebar.stop().animate({
          marginTop: 20
        });
      }
    });
  });
});
