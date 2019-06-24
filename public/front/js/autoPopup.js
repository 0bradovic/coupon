// NEWSLETTER

$(document).ready(function() {
    var present = $('#presentOn').val();
    if(localStorage.getItem("newsletter") == null || localStorage.getItem("newsletter") == undefined || localStorage.getItem("newsletter") == ''){
        localStorage.setItem("newsletter",1);
    }
    if(localStorage.getItem("newsletter") == present){
        $(".fixed_btn_form").show();
        localStorage.removeItem('newsletter');
    }
    else if(localStorage.getItem("newsletter") < present){
        var count = parseInt(localStorage.getItem("newsletter")) +1;
        localStorage.setItem("newsletter",count);
    }
    else{
        localStorage.removeItem('newsletter');
    }
  });