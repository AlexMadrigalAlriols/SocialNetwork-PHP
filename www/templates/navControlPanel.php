<?php
    require_once("cards/framework/globalController.php");
    $user_details = userService::getUserDetails($_SESSION["iduser"]);
?>
    <header class="header body-pd" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="align-items-center d-flex me-2">
          <a class="btn btn-dark navbar-links" id="Home" href="/"><i class='bx bxs-home' ></i></a>
          <a class="btn btn-dark navbar-links" id="Messages"><i class='bx bx-comment-dots' ></i></a>
          <a class="btn btn-dark navbar-links active" id="CollectionDashboard" href="/dashboard"><i class='bx bxs-dashboard' ></i></a>
          <a class="btn btn-dark navbar-links" id="SearchTour" href="/tournament-searcher"><i class="fa-solid fa-magnifying-glass-dollar"></i></a>
          
            <a href="/profile/<?=$_SESSION["iduser"];?>" style="color:White;background-color:transparent; border-color:transparent;" >
                <img src="/<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" style="border-radius: 25%;">
            </a>
    </header>

    <div class="l-navbar show bg-dark" id="nav-bar">
        <nav class="nav">
            <div> <a href="/" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Collection Saver</span> </a>
                <div class="nav_list"> 
                    <a href="/" class="nav_link text-center"> <span class="nav_name"><button class="btn btn-outline-dark" style="color: white; border-color: white;"><i class='bx bxs-chevron-left' ></i> Return To Feed</button></span> </a> 
                    <a href="/dashboard" class="nav_link" id="dashboard"><i class='bx bxs-dashboard nav_icon'></i><span class="nav_name">Dashboard</span> </a> 
                    <a href="/search" class="nav_link" id="search"><i class='bx bxs-search-alt-2 nav_icon'></i><span class="nav_name">Search Cards</span> </a> 
                    <a href="/cards" class="nav_link" id="collection"><i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Card Collection</span> </a> 
                    <a href="/decks" class="nav_link" id="decks"> <i class='bx bxs-box nav_icon'></i> <span class="nav_name">Decks</span> </a> 
                    <a href="/tournaments" class="nav_link" id="tournaments"><i class='bx bxs-trophy nav_icon'></i><span class="nav_name">Tournaments</span> </a> 
                    <a href="/settings" class="nav_link" id="settings"> <i class='bx bxs-briefcase-alt-2 nav_icon'></i> <span class="nav_name">Settings</span> </a> 
                </div>
            </div>

            <a class="nav_link" style="align-items:center;" id="mode">
            <label class="form-check-label" id="modeIcon"><i class='bx bxs-moon'></i></label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="modeCheck">
            </div>
            </a>

        </div>
        </nav>
    </div>

    <script>
        var dark = false;
        $.ajax({
            url: '/procesos/settings/checkSettings',
            type: 'POST',
            data: {userId: <?php echo $_SESSION["iduser"]; ?>},
            success: function(data) {
                data = JSON.parse(data);
                if(data[0].darkMode == true){
                    $('#body-pd').toggleClass("dark-mode");
                    $('#modeCheck').prop("checked", true);
                    dark = false;
                } else {
                    dark = true;
                }
            }
        });

        $('#mode').click(function() {
            if(dark){
                dark = false;
                $('#modeCheck').prop("checked", true);
                $.ajax({
                    url: '/procesos/settings/setSettings',
                    type: 'POST',
                    data: {userId: <?php echo $_SESSION["iduser"]; ?>, value: '{"darkMode": true}'},
                    success: function(data) {
                        $('#body-pd').toggleClass("dark-mode");
                    }
                });
            } else {
                dark = true;
                $('#modeCheck').prop("checked", false);
                $.ajax({
                    url: '/procesos/settings/setSettings',
                    type: 'POST',
                    data: {userId: <?php echo $_SESSION["iduser"]; ?>, value: '{"darkMode": false}'},
                    success: function(data) {
                        $('#body-pd').toggleClass("dark-mode");
                    }
                });
            }

        });
    </script>
    