
// $(document).ready(function(){
//     $('.dropbtn').hover(function(){
//       var id = $(this).data('id');
//       $('.dropdown-container').addClass('d-none');
//       $('#'+id+'').children().removeClass('d-none');
//        }
//       )
//   })
//  
//     $('.dropdown-container').hover(function(){
//       $(this).removeClass('d-none');
//     })
$(document).ready(function(){
    $('.fa-times-circle').on('click', function () {
      $('#cookie').remove()
    })
  })

  $('.dropdown').on('click', function () {
    $(this).find('.fa-caret-right').toggleClass('rotate_arrow')
  })
  $('#mob_menu').on('click', function () {
    $('.dropdowns_holder').toggleClass('active_dropdown_holder')
    if ($(this).hasClass('fa-bars')) {
      $(this).removeClass('fa-bars')
      $(this).addClass('fa-times')
      $('body').css('overflow', 'hidden')
    } else if ($(this).hasClass('fa-times')) {
      $(this).removeClass('fa-times')
      $(this).addClass('fa-bars')
      $('body').css('overflow', 'scroll')
    }
  })
  $('.back').click(function () {
    $(this).parent().removeClass('active_sub_menu')
    $('.dropdown_row').show()
  })
  $('.open_sub').on('click', function () {
    $('.dropdown_row').hide()
  })
  $('.open_sub').on('click', function () {
    var id = $(this).prev().data('id');
    console.log(id);
    $('#'+id).toggleClass('active_sub_menu')
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

  $(document).ready(function () {
    if (sessionStorage.getItem('cookie') !== 'true') {
      $('body').append(`<div id="cookie">
      <div class="cookie_left">
      <p>This site uses cookies and other tracking technologies to assist with navigation and your ability to provide feedback, analyse your use of our products and services, assist with our promotional and marketing efforts, and provide content from third parties.</p>
      </div>
      <div class="cookie_right">
      <i class="fas fa-angle-right"></i><a href="https://www.cookielaw.org/the-cookie-law/">Cookie Policy</a>
      <button id="acceptC"><i class="fas fa-check"></i> Accept Cookies</button>
      <i class="fas fa-times-circle"></i>
      </div>
  </div>`)
    }
    $('#acceptC').on('click', function () {
      sessionStorage.setItem('cookie', true)
      $('#cookie').remove()
    })
    $('.fa-times-circle').on('click', function() {
      $('#cookie').remove()
    })
    $('.social_icons_div_absolute').hide()
    $('#email_form').on('click', function (e) {
      e.preventDefault();
      $('.social_icons_div_absolute').fadeToggle(200)
    })
  })
  $(document).click(function(e){
    if( $(e.target).closest("#email_form").length > 0 ) {
        return true;
    }
    else if($(e.target).closest(".social_icons_div_absolute").length > 0){
        return true;
    }
    // Otherwise
    // trigger your click function
    $('.social_icons_div_absolute').fadeOut(200)
  });
  $("#emailinput").keyup(function() {
    var content = 'http://www.beforetheshop.com';
    var email = $(this).val();
    $('#send_mail').attr('href','mailto:'+email+'?subject=look at this website&body='+content);
  })
  $('#mailto_button').click(function(){
    $('.social_icons_div_absolute').fadeOut(200)
  })
  
  
  