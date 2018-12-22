$('a[href="#top"]').click(function (e) {
    $('html, body').animate({ scrollTop: "0px" }, 1000);
});

console.log('slepac');

$("#search").keyup(function(e){

    $.ajax({
        url: SITE_URL + "search/" + e.target.value,
        type:"GET",
        success:function(data){
            console.log(data);
 
            data.forEach(element => {
                document.getElementById("serachDiv").innerHTML=this.responseText;
                document.getElementById("serachDiv").style.border="1px solid #A5ACB2";
            });
        }
 
    })
});