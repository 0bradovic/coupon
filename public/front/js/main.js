
// NEWWWWWWWWWWW      JQUERYYYYYYYYY

$(document).ready(function () {
  // OPEN MOBILE NAVIGATION
  $(".open_menu").click(function () {
    if ($("#mobile_navigation").hasClass("show_mobile_navigation")) {
      $("#mobile_navigation").removeClass("show_mobile_navigation");
      $("body").css("overflow", "hidden");
    }
  });
  // CLOSE MOBILE NAVIGATION
  $(".close_menu").click(function () {
    if ($("#mobile_navigation").hasClass("")) {
      $("#mobile_navigation").addClass("show_mobile_navigation");
      $("body").css("overflow", "unset");
    }
  });
  // DROPDOWN LIST FOR MOBILE
  $(".open_dropdown").click(function () {
    $(this)
      .parent()
      .next()
      .toggleClass("dropdown_list_none");
    $(this).toggleClass("rotate_arrow");
  });
  $(".main_menu").click(function () {
    $(this)
      .parent()
      .parent()
      .addClass("dropdown_list_none");
    $(this)
      .parent()
      .parent()
      .prev()
      .children()
      .removeClass("rotate_arrow");
  });
  // SUBMENU
  $(".navigation_item").hover(function () {
    $(this)
      .next()
      .removeClass("hidden");
  },function(){
    $(this)
      .next()
      .addClass("hidden");
  });
  $(".submenu").hover(function () {
    $(this).removeClass("hidden");
  },function(){
    $(this).addClass("hidden");
  });
  // GO TOP BUTTON
  $(".go_top").on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({
      scrollTop: 0
    }, "300");
  });
  // VIEW MOST POPULAR BUTTONS IN HEADER
  $(".header_btn_mostPopular").on("click", function () {
    $(".header_btn_mostPopular, .header_viewNewest, .newest_offers").addClass(
      "hidden800"
    );
    $(".header_mostPopular, .header_btn_viewNewest, .most_popular").removeClass(
      "hidden800"
    );
  });
  // VIEW NEWEST OFFERS BUTTONS IN HEADER
  $(".header_btn_viewNewest").on("click", function () {
    $(".header_mostPopular, .header_btn_viewNewest, .most_popular").addClass(
      "hidden800"
    );
    $(
      ".header_btn_mostPopular, .header_viewNewest, .newest_offers"
    ).removeClass("hidden800");
  });
  // OPEN EMAIL POP UP
  $("#email_popup").on("click", function () {
    $(".email_popup").toggleClass("hidden");
  });
  
$("#emailinput").keyup(function () {
  var content =
    "I'm using BeforeTheShop to save £££s every time I shop. I thought you'd love it too! http://www.beforetheshop.com";
  var email = $(this).val();
  $("#send_mail").attr(
    "href",
    "mailto:" + email + "?subject=BeforeTheShop&body=" + content
  );
});
$("#mailto_button").click(function () {
  $(".email_popup").toggleClass("hidden");
});

$(document).click(function (e) {
  if ($(e.target).closest("#email_popup").length > 0) {
    return true;
  } else if ($(e.target).closest(".email_popup").length > 0) {
    return true;
  }
  // Otherwise
  // trigger your click function
  $(".email_popup").addClass("hidden");
});

  // OPEN AND CLOSE SIGN IN POP UP
  $("#open_popup").on("click", function () {
    $(".fixed_btn_form").fadeToggle(300);
  });
  $(".close_popUp").on("click", function () {
    sessionStorage.setItem("newsletter", true);
    $(".fixed_btn_form").hide();
  });
  // COOKIE
  if (sessionStorage.getItem("cookie") !== "true") {
    $("body").append(`<div id="cookie">
    <div class="cookie_left">
    <p>We use cookies to give you the best service. Read our <a href="https://www.beforetheshop.com/page/privacy-policy" target="_blank" class="cookie_link">privacy</a> and <a href="https://www.beforetheshop.com/page/cookie-policy" target="_blank" class="cookie_link">cookie</a> policy to learn more.</p>
    </div>
    <div class="cookie_right">
    <button id="acceptC"><i class="fas fa-check"></i> Accept Cookies</button>
    <i class="fas fa-times-circle"></i>
    </div>
</div>`);
  }
  $("#acceptC").on("click", function () {
    sessionStorage.setItem("cookie", true);
    $("#cookie").remove();
  });
  $(".fa-times-circle").on("click", function () {
    $("#cookie").remove();
  });
  $(".social_icons_div_absolute").hide();
  $("#email_form").on("click", function (e) {
    e.preventDefault();
    $(".social_icons_div_absolute").fadeToggle(200);
  });
  // FIXED NAVIGATON AND SCROOL TOP
  $(window).scroll(function () {
    let $this = $(this);
    let $nav = $(".navigation");
    let $go_top = $(".go_top");
    if ($this.scrollTop() > 45) {
      $nav.addClass("fixed_navigation");
      $go_top.removeClass("hidden");
    } else {
      $nav.removeClass("fixed_navigation");
      $go_top.addClass("hidden");
    }
  });
});
// SEARCH FORM
$("#search").keyup(function (e) {
  $.ajax({
    url: SITE_URL + "search/" + e.target.value,
    type: "GET",
    success: function (data) {
      document.querySelector(".search_result").classList.remove("hidden");
      document.querySelector(".search_result").innerHTML = "";
      var search_result = document.querySelector(".search_result");
      var count = 0;
      data.forEach(element => {
        count++;
        if (count > 5) return;
        var elementDiv = document.createElement("div");
        elementDiv.classList.add("search_result_item");
        elementDiv.innerHTML =
          "<a href='/brand/" +
          element.slug +
          "'> <img src='" +
          element.img_src +
          "'>  <span class='article'>" +
          element.name +
          "</span></a>";
        search_result.appendChild(elementDiv);
      });
    }
  });
  
});
$(document).click(function () {
  document.querySelector(".search_result").classList.add("hidden");
});

// NEWSLETTER

  $(document).ready(function () {
    if (sessionStorage.getItem("newsletter") !== "true") {
      $(".fixed_btn_form").show();
    }
  });
  $(".close-modal").click(function () {
    sessionStorage.setItem("newsletter", true);
    $(".fixed_btn_form").hide();
  });


$("#newsletter_submit").click(function (e) {
  e.preventDefault();
  sessionStorage.setItem("newsletter", true);
  $("#newsletter_form").submit();
});