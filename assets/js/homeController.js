    $("#Home").addClass('active');
    $('#buttonImages').click(function(){ $('#publication_img').trigger('click'); });
    
    $(".insertDeck").click(function(){
        $("#publication_deck").val($(this).val());
        $("#insert-deck-box").removeClass("d-none");
        $('#deckModal').modal('toggle');
        $('#deckInserted').toast('show');
        $("#deckName").text($(this).data('name'));
        $("#deckFormat").text($(this).data('format'));
        $("#prices").text($(this).data('price') + " € // " + $(this).data('tix') + " tix");
        $("#deckColors")
        $("#deckImg").attr("src", $(this).data('img'));
    });

    $(function() {
        window.emojiPicker = new EmojiPicker({
            emojiable_selector: '[data-emojiable=true]',
            assetsPath: '/cards/assets/vendor/emojilib/img/',
            popupButtonClasses: 'fa fa-smile-o emoji-right'
        });
        window.emojiPicker.discover();
    });

    var loadFile = function(event) {
        var output = document.getElementById('output');
        $("#imgContainer").removeClass("d-none");
        output.src = URL.createObjectURL(event.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        }
    };

    
    function removeFile(){
        $("#imgContainer").addClass("d-none");
        const file = document.querySelector('#publication_img');
        file.value = '';
    }

    function removeDeck() {
        $("#insert-deck-box").addClass("d-none");
        $("#publication_deck").val(0);
    }
    
    $postOffset = 0;
    $(window).scroll(function(){
        $postCount = $('.publication-card:last').index() + 1;

        if (($(window).scrollTop() == $(document).height() - $(window).height() || $(window).scrollTop() + 5 >= $(document).height() - $(window).height()) && ($postCount < $totalRecord)){
            $('#load_post').removeClass("d-none");
            $postOffset = $postOffset + $postPerLoad;

            //Cargar mas posts
            $.ajax({
                url: '/getPosts',
                type: 'POST',
                data: {postOffset: $postOffset},
                success:function(data){
                    if (data != '') {
                        publications = JSON.parse(data);

                        publications.forEach(publication => {
                            $html = '<div class="card mt-2 bg-dark publication-card p-3">'+
                                '<div class="card-body">'+
                                    '<a href="/profile/@'+publication.username+'" class="text-decoration-none">'+
                                        '<div class="col-md-1 d-inline-block">'+
                                            '<img src="'+publication.profile_image+'" class="rounded-circle" width="50px" height="50px">'+
                                        '</div>'+
                                    '</a>'+
                                    '<a href="/profile/@'+publication.username+'" class="d-inline-block ms-1 text-decoration-none">'+
                                        '<span class="d-inline-block text-white f-14"><b>'+publication.name;
                                        if(publication.verified) {
                                            $html += '&nbsp;<i class="fa-solid fa-certificate text-purple"></i></br>'
                                        }
                                        $html += '&nbsp;</b></span>'+
                                        '<span class="text-muted d-inline-block f-12"> @'+publication.username+' - </span>'+
                                        '<span class="text-muted d-inline-block f-12">&nbsp;'+publication.passed_time+'</span>'+
                                    '</a>'+
                                    '<div class="col-md-11 d-inline-block align-top">'+
                                        '<div>'+
                                            '<div class="dropdown">'+
                                                '<a class="d-inline-block mt-2 pull-right text-white f-18" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-ellipsis-vertical"></i></a>'+
                                                '<ul class="dropdown-menu">'+
                                                    '<li><a class="dropdown-item mt-1" role="button" onclick="sharePublication('+publication.id_publication+', `'+publication.site_url+'`)"><i class="fa-solid fa-link"></i> Copy link</a></li>'+
                                                    '<form action="" method="post">';
                                                        if(publication.id_user == publication.session_user_id || publication.session_user_admin) {
                                                            $html += '<li><button class="dropdown-item mt-1"text-red   name="commandDelete" type="submit" value="'+publication.id_publication+'"><i class="fa-regular fa-trash-can"></i> Delete Publication</button></li>'
                                                        }
                                                        $html += '<li><button class="dropdown-item mt-1 text-red" name="commandReport" type="submit" value="'+publication.id_publication+'"><i class="fa-regular fa-flag"></i> Report Publication</button></li>'+
                                                    '</form>'+
                                                '</ul>'+
                                            '</div>'+
                                        '</div>'+
                                        '<a href="/publication/'+publication.id_publication+'" class="text-white text-decoration-none">'+
                                            '<div class="mt-3">'+
                                                '<p>'+publication.publication_message+'</p>';
                                                if(publication.publication_img != "none") {
                                                    $html += '<a href="/publication/'+publication.id_publication+'"><img src="/cards/uploads/'+publication.publication_img+'" class="rounded app-open-publication" style="width: 100%; max-height: 400px;"></a>';
                                                }
                                            $html += '</div>'+
                                        '</a>';

                                        if(publication.publication_deck != 0) {
                                            $html += '<div class="inserted-deck-box" id="insert-deck-box">'+
                                                '<img class="d-inline-block m-2" width="100px" src="'+publication.deck_img+'" alt="">'+
                                                '<div class="d-inline-block align-top">'+
                                                    '<span><b>'+publication.deck_name+'</b></span>';
                                                    if(publication.colors) {
                                                        $colors = JSON.parse(publication.colors);
                                                        $colors.forEach(color => {
                                                            $html += '&nbsp;<img src="https://c2.scryfall.com/file/scryfall-symbols/card-symbols/'+color+'.svg" alt="" class="d-inline-block" width="20px">';
                                                        });
                                                    }

                                                    $html += '</br><span>'+publication.format+'</span><br>'+
                                                    '<span>'+publication.totalPrice+' € // '+publication.priceTix+' tix</span>'+
                                                '</div>'+
                                                '<a href="/deck/'+publication.publication_deck+'" class="btn btn-dark-primary active text-white m-4 btn-view-deck">View Deck</a>'+
                                            '</div>';
                                        }

                                        $html += '<div class="mt-2 ms-3" style="opacity: 60%;">'+
                                            '<div class="d-inline-block me-5">'+
                                                '<button class="btn btn-dark ';if(publication.user_liked){$html += 'active';} $html += '" onclick="publicationLike('+publication.id_publication+')" id="like---'+publication.id_publication+'">';
                                                    if(publication.user_liked){
                                                        $html += '<i class="fa-solid fa-heart d-inline-block" id="like-icon2---'+publication.id_publication+'"></i>';
                                                    } else {
                                                        $html += '<i class="fa-regular fa-heart d-inline-block" id="like-icon---'+publication.id_publication+'"></i>';
                                                    }
                                                    $html += '<span class="d-inline-bloc ms-2" id="likes-txt---'+publication.id_publication+'">'+publication.like_count+'</span>'+
                                                '</button>'+
                                            '</div>'+
                                            '<div class="d-inline-block me-5">'+
                                                '<a class="btn btn-dark" href="/publication/'+publication.id_publication+'">'+
                                                    '<i class="fa-regular fa-comment d-inline-block"></i>'+
                                                    '<span class="d-inline-bloc ms-2">'+publication.comment_count+'</span>'+
                                                    '</a>'+
                                            '</div>'+

                                            '<div class="d-inline-block">'+
                                                '<button class="btn btn-dark share-users-modal" data-bs-target="#shareModal" data-bs-toggle="modal" value="'+publication.id_publication+'">'+
                                                    '<i class="fa-solid fa-share d-inline-block"></i>'+
                                                '</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                            
                            $('#frm-publications').append($html).show('slow');
                        });
                        
                        $('#load_post').addClass("d-none");
                    } else {
                        $('#load_post').addClass("d-none");
                    }
                }
            });
        }
    });

    $("#search-share-users").keyup(function(){    
        getUsersForShare(this);
    });

    $('.share-users-modal').on('click', function(){
        $("#commandSendPublication").val($(this).val());
        getUsersForShare($("#search-share-users"));
    });

    function checkCheckBox(button) {
        var disabled = true;
        var checkbox = $(button).children('input[type="checkbox"]');
        checkbox.prop('checked', !checkbox.prop('checked'));

        $(".user-share-checkbox").each(function() {
            if($(this).is(":checked")) {
                disabled = false;
            }
        });

        $("#commandSendPublication").prop('disabled', disabled);
    }

    function getUsersForShare(input) {
        $.ajax({
            url: '/procesos/users/searchUser',
            type: 'POST',
            async: false,
            data: {input: $(input).val(), put_followed: true},
            success: function(data) {
                if(data){
                    users = JSON.parse(data);
                    
                    $("#share-users-container").empty();
                    $("#share-users-container").addClass("show");
                    users.forEach(user => {
                        $html = '<div class="mt-1 p-1 share-user-card" onclick="checkCheckBox(this)">'+
                                    '<a href="/profile/@'+user["username"]+'" target="_blank" class="text-decoration-none">'+
                                        '<img src="'+user["profile_image"]+'" class="rounded-circle d-inline-block" width="40px" height="40px" referrerpolicy="no-referrer">'+
                                        '<span class="d-inline-block ms-2 text-white f-13"><b>@'+user["username"];

                                        if(user["verified"]) {
                                            $html += '&nbsp;<i class="fa-solid fa-certificate text-purple"></i>';
                                        }

                                        $html += '</b></span>'+
                                    '</a>'+
                                '<input type="checkbox" class="form-check-input user-share-checkbox pull-right mt-25 rounded-circle" name="users_share[]" value="'+user["user_id"]+'">'+
                            '</div>';
                        $("#share-users-container").append($html);
                    });
                }
            }
        });
    }