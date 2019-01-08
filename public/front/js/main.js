$('a[href="#top"]').click(function (e) {
    $('html, body').animate({ scrollTop: "0px" }, 250);
});


$("#search").keyup(function(e){
    console.log(SITE_URL);
    $.ajax({
        
        url: SITE_URL + "search/" + e.target.value,
        type:"GET",
        success:function(data){
            document.getElementById("serachDiv").classList.remove("disable");
            document.getElementById("serachDiv").innerHTML = '';
            var serachDiv=document.getElementById('serachDiv');
            var count = 0;
            data.forEach(element => {
                count++;
                if (count > 5) return;
                var elementDiv = document.createElement('div');
                elementDiv.innerHTML = "<a href='/public/offer/"+element.slug+"'><div class='search-div-1'> <img src='"+element.img_src+"'> <div class='articleText'> <p class='article'>"+element.name+"</p></div></div></a>"                    
                serachDiv.appendChild(elementDiv);
                document.getElementById("serachDiv").style.border="1px solid #A5ACB2";``
            });
        }
 
    })
});

$(document).click(function(){
    document.getElementById("serachDiv").classList.add("disable");
})