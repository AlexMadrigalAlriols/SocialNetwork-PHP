function publicationLike($id_publication){
    $.ajax({
        url: '/procesos/publications/likePublication',
        type: 'POST',
        async: false,
        data: {id_publication: $id_publication},
        success: function(data) {
            if(data){
                $("#like---"+$id_publication).toggleClass("active");
                $("#likes-txt---"+$id_publication).empty();
                $("#likes-txt---"+$id_publication).append(data);
                $("#like-icon---"+$id_publication).toggleClass("fa-solid");
                $("#like-icon---"+$id_publication).toggleClass("fa-regular");
                $("#like-icon2---"+$id_publication).toggleClass("fa-solid");
                $("#like-icon2---"+$id_publication).toggleClass("fa-regular");
            }
        }
    });
}

function sharePublication($id_publication, $url){
    var sampleTextarea = document.createElement("textarea");
    document.body.appendChild(sampleTextarea);
    sampleTextarea.value = $url+"/publication/"+$id_publication; //save main text in it
    sampleTextarea.select(); //select textarea contenrs
    document.execCommand("copy");
    document.body.removeChild(sampleTextarea);
    $('#copyLink').toast('show');
}