$(window).scroll(function() {
  if ($(".adSenseOffer").offset().top > 700) {
    $(".adSenseOffer").css("top", "150px");
    console.log($(".adSenseOffer").offset().top);
  } else if ($(".adSenseOffer").offset().top < 400) {
    $(".adSenseOffer").css("top", "365px");
  }
});