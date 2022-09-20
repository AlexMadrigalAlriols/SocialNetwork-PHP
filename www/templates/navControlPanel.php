<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $user_details = userService::getUserDetails($user->get("id_user"));
?>
    <header class="header body-pd dark-mode" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle" style="color: #7353f5;"></i> </div>
        <div class="align-items-center d-flex me-2">
          <a class="btn btn-dark navbar-links" id="Home" href="/"><i class='bx bxs-home' ></i></a>
          <a class="btn btn-dark navbar-links" id="Messages" href="/messages"><i class='bx bx-comment-dots' ></i></a>
          <a class="btn btn-dark navbar-links active" id="CollectionDashboard" href="/search"><i class='bx bxs-dashboard' ></i></a>
          <a class="btn btn-dark navbar-links" id="SearchTour" href="/tournament-searcher"><i class="fa-solid fa-magnifying-glass-dollar"></i></a>
          
            <a href="/profile/<?=$user->get("id_user");?>" style="color:White;background-color:transparent; border-color:transparent;" >
                <img src="/<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" style="border-radius: 25%;">
            </a>
    </header>

    <div class="l-navbar show bg-dark" id="nav-bar">
        <nav class="nav">
            <div> <a href="/" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Collection Saver</span> </a>
                <div class="nav_list"> 
                    <a href="/" class="nav_link text-center"> <span class="nav_name"><button class="btn btn-outline-dark" style="color: white; border-color: white;"><i class='bx bxs-chevron-left' ></i> Return To Feed</button></span> </a>  
                    <a href="/search" class="nav_link" id="search"><i class='bx bxs-search-alt-2 nav_icon'></i><span class="nav_name">Search Cards</span> </a> 
                    <a href="/cards" class="nav_link" id="collection"><i class='bx bx-grid-alt nav_icon'></i> <span class="nav_name">Card Collection</span> </a> 
                    <a href="/decks" class="nav_link" id="decks"> <i class='bx bxs-box nav_icon'></i> <span class="nav_name">Decks</span> </a> 
                    <?php if($user_details["shop"]) { ?>
                        <a href="/tournaments" class="nav_link" id="tournaments"><i class='bx bxs-trophy nav_icon'></i><span class="nav_name">Tournaments</span> </a> 
                    <?php } ?>
                    <a href="/settings" class="nav_link" id="settings"> <i class='bx bxs-briefcase-alt-2 nav_icon'></i> <span class="nav_name">Settings</span> </a> 
                    <?php if($user_details["admin"]) { ?>
                    <a href="/reports" class="nav_link" id="reports"><i class="fa-solid fa-flag nav_icon"></i><span class="nav_name">Reports</span> </a> 
                    <?php } ?>  
                </div>
            </div>
        </div>
        </nav>
    </div>

    <script>
        $('#body-pd').toggleClass("dark-mode");
    </script>
    