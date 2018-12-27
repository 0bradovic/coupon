$('a[href="#top"]').click(function (e) {
    $('html, body').animate({ scrollTop: "0px" }, 1000);
});


$("#search").keyup(function(e){

    $.ajax({
        url: SITE_URL + "search/" + e.target.value,
        type:"GET",
        success:function(data){
            console.log(data);
            document.getElementById("serachDiv").classList.remove("disable");
            document.getElementById("serachDiv").innerHTML = '';
            var serachDiv=document.getElementById('serachDiv');
            var count = 0;
            data.forEach(element => {
                count++;
                if (count > 5) return;
                var elementDiv = document.createElement('div');
                elementDiv.innerHTML = "<a href='/offer/"+element.slug+"'><div class='search-div-1'> <img src="+element.img_src+"> <div class='articleText'> <p class='article'>"+element.name+"</p></div></div></a>"                    
                serachDiv.appendChild(elementDiv);
                document.getElementById("serachDiv").style.border="1px solid #A5ACB2";
                
            });
        }
 
    })
});