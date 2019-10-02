// NEWSLETTER

$(document).ready(function() {
    var present = $('#presentOn').val();
    if(sessionStorage.getItem("newsletter") == null || sessionStorage.getItem("newsletter") == undefined || sessionStorage.getItem("newsletter") == ''){
        sessionStorage.setItem("newsletter",1);
    }
    if(sessionStorage.getItem("newsletter") == present){
        $(".fixed_btn_form").show();
        sessionStorage.removeItem('newsletter');
    }
    else if(sessionStorage.getItem("newsletter") < present){
        var count = parseInt(sessionStorage.getItem("newsletter")) +1;
        sessionStorage.setItem("newsletter",count);
    }
    else{
        if(sessionStorage.getItem("newsletter") != "false"){
            sessionStorage.removeItem('newsletter');
        }
    }
  });