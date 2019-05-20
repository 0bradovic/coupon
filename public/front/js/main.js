$(document).ready(function() {
  $(".dropdown").hover(
    function() {
      var id = $(this).data("id");
      $(".dropdown-container").addClass("d-none");
      $("#cont" + id).removeClass("d-none");
    },
    function() {
      $(".dropdown-container").addClass("d-none");
    }
  );
});
$(document).ready(function() {
  $(".dropdown-container").hover(
    function() {
      $(this).removeClass("d-none");
    },
    function() {
      $(this).addClass("d-none");
    }
  );
  $(".fa-times-circle").on("click", function() {
    $("#cookie").remove();
  });
  $(".dropdown").on("click", function() {
    $(this)
      .find(".fa-caret-right")
      .toggleClass("rotate_arrow");
  });
  $("#mob_menu").on("click", function() {
    $(".dropdowns_holder").toggleClass("active_dropdown_holder");
    if ($(this).hasClass("fa-bars")) {
      $(this).removeClass("fa-bars");
      $(this).addClass("fa-times");
      $("body").css("overflow", "hidden");
    } else if ($(this).hasClass("fa-times")) {
      $(this).removeClass("fa-times");
      $(this).addClass("fa-bars");
      $("body").css("overflow", "scroll");
    }
  });
  $(".back").click(function() {
    $(this)
      .parent()
      .removeClass("active_sub_menu");
    $(".dropdown_row").show();
  });
  $(".open_sub").on("click", function() {
    $(".dropdown_row").hide();
  });
  $(".open_sub").on("click", function() {
    var id = $(this)
      .prev()
      .data("id");
    $("#" + id).toggleClass("active_sub_menu");
  });

  $(document).ready(function() {
    if (sessionStorage.getItem("newsletter") !== "true") {
      $(".fixed_btn_form").show();
    }
  });

  //newsleter
  // $('.fixed_btn_form').hide()
  $(".close-modal").click(function() {
    sessionStorage.setItem("newsletter", true);
    $(".fixed_btn_form").hide();
  });
  $("#open_popup").on("click", function() {
    $(".fixed_btn_form").fadeToggle(300);
  });
});
$(".close_popUp").on("click", function() {
  sessionStorage.setItem("newsletter", true);
  $(".fixed_btn_form").hide();
});

$("#newsletter_submit").click(function(e) {
  e.preventDefault();
  sessionStorage.setItem("newsletter", true);
  $("#newsletter_form").submit();
});

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
      });
    }
  });
});

$(document).click(function() {
  document.getElementById("serachDiv").classList.add("disable");
});
$("#most-popular-btn").click(function(e) {
  e.preventDefault();
  $(".newest-offers").addClass("dNone");
  $(".most-popular-offers").removeClass("dNone");
  $(".mostPopularOffers").removeClass("dNone991");
  $(".newestOffers").addClass("dNone991");
});
$("#newest-btn").click(function(e) {
  e.preventDefault();
  $(".newest-offers").removeClass("dNone");
  $(".most-popular-offers").addClass("dNone");
  $(".mostPopularOffers").addClass("dNone991");
  $(".newestOffers").removeClass("dNone991");
});

$(document).ready(function() {
  if (sessionStorage.getItem("cookie") !== "true") {
    $("body").append(`<div id="cookie">
    <div class="cookie_left">
    <p>We use cookies to give you the best service. Read our <a href="https://www.beforetheshop.com/public/front/Privacy Policy.pdf" target="_blank" class="cookie_link">privacy</a> and <a href="https://www.beforetheshop.com/public/front/Cookie Policy.pdf" target="_blank" class="cookie_link">cookie</a> policy to learn more.</p>
    </div>
    <div class="cookie_right">
    <button id="acceptC"><i class="fas fa-check"></i> Accept Cookies</button>
    <i class="fas fa-times-circle"></i>
    </div>
</div>`);
  }
  $("#acceptC").on("click", function() {
    sessionStorage.setItem("cookie", true);
    $("#cookie").remove();
  });
  $(".fa-times-circle").on("click", function() {
    $("#cookie").remove();
  });
  $(".social_icons_div_absolute").hide();
  $("#email_form").on("click", function(e) {
    e.preventDefault();
    $(".social_icons_div_absolute").fadeToggle(200);
  });
});
$(document).click(function(e) {
  if ($(e.target).closest("#email_form").length > 0) {
    return true;
  } else if ($(e.target).closest(".social_icons_div_absolute").length > 0) {
    return true;
  }
  // Otherwise
  // trigger your click function
  $(".social_icons_div_absolute").fadeOut(200);
});

$("#emailinput").keyup(function() {
  var content =
    "I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com";
  var email = $(this).val();
  $("#send_mail").attr(
    "href",
    "mailto:" + email + "?subject=BeforeTheShop&body=" + content
  );
});
$("#mailto_button").click(function() {
  $(".social_icons_div_absolute").fadeOut(200);
});
$(".social_icons_div_absolute2").hide();
$("#abs2").on("click", function() {
  $(".social_icons_div_absolute2").fadeToggle(200);
});
$(document).click(function(e) {
  if ($(e.target).closest("#email_form2").length > 0) {
    return true;
  } else if ($(e.target).closest(".social_icons_div_absolute2").length > 0) {
    return true;
  }
  // Otherwise
  // trigger your click function
  $(".social_icons_div_absolute2").fadeOut(200);
});

$("#offer-email-input").keyup(function() {
  // var content = window.location.href
  var content = $(this).data("content");
  var email = $(this).val();
  $("#offer-send-mail").attr(
    "href",
    "mailto:" + email + "?subject=BeforeTheShop&body=" + content
  );
});
$("#offer-send-mail").click(function() {
  $(".social_icons_div_absolute2").fadeOut(200);
});

$(".close-msg").click(function() {
  $(this)
    .parent()
    .fadeOut(200);
});

