
<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $user_details = userService::getUserDetails($user->get("id_user"));
    $shop_config = json_decode($user_details["shop_config"], true);

    $had_noti = notificationService::checkIfNotifications($user->get("id_user"));
?>

<nav class="navbar navbar-expand-lg bg-dark p-3">
  <div class="container-fluid">
    <div class="header-left container">
      <a class="navbar-brand d-inline-block" href="/"><img src="/cards/assets/img/Logo_Transparent.png" alt="Mtgcollectioner Logo" width="250px" class="d-inline-block"> </a>
      <div class="d-inline-block col-md-7">
        <form class="d-flex input-searchbar-header" role="search">
          <span class="input-group-text search-icon" id="basic-addon1"><i class='bx bx-search-alt-2'></i></span>
          <input class="form-control me-2 search_bar" id="search-bar" type="search" placeholder="<?=$user->i18n("search_bar");?>" aria-label="Search" aria-describedby="basic-addon1">
        </form>
        <div class="form-body bg-dark margin-dropdown">
          <ul id="container-search" class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end bg-dark text-white width-15"></ul>
        </div>
      </div>
    </div>

    <div id="header-right" class="computer-navbar">
      <div class="navbar-nav">
        <div class="align-items-center d-flex me-1">
          <a class="btn btn-dark navbar-links" id="Home" href="/"><i class='bx bxs-home' ></i></a>
          <a class="btn btn-dark navbar-links" id="Messages" href="/messages"><i class='bx bx-comment-dots' ></i></a>
          <a class="btn btn-dark navbar-links" id="CollectionDashboard" href="/search"><i class='bx bxs-dashboard' ></i></a>
          <a class="btn btn-dark navbar-links" id="SearchTour" href="/tournament-searcher"><i class="fa-solid fa-magnifying-glass-dollar"></i></a>
          <a class="btn btn-dark navbar-links" id="Notifications" href="/notifications"><?=($had_noti ? "<i class='bx bx-bell' ><span class='badge-notification'>".$had_noti."</span></i>" : "<i class='bx bx-bell' ></i>")?></a>

        </div>
        <div class="dropdown">
          <button class="dropdown-toggle text-white dropdown-invisible" type="button" id="dropDownNotifications" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" class="rounded" referrerpolicy="no-referrer">
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end animate slideIn margin-negative-1" aria-labelledby="dropDownNotifications">
            <li><a class="dropdown-item" href="/profile/<?=$user->get("id_user");?>"><i class='bx bx-user-circle' ></i> <?=$user->i18n("my_profile");?></a></li>
            <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear"></i> <?=$user->i18n("settings");?></a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/logout"><i class='bx bx-log-out'></i> <?=$user->i18n("logout");?></a></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

<nav class="navbar position-fixed bottom-0 p-1 w-100 container mobile-navbar">
  <div class="align-items-center d-flex m-auto">
    <a class="btn btn-dark navbar-links" id="Home" href="/"><i class='bx bxs-home' ></i></a>
    <a class="btn btn-dark navbar-links" id="Messages" href="/messages"><i class='bx bx-comment-dots' ></i></a>
    <a class="btn btn-dark navbar-links" id="CollectionDashboard" href="/search"><i class='bx bxs-dashboard' ></i></a>
    <a class="btn btn-dark navbar-links" id="SearchTour" href="/tournament-searcher"><i class="fa-solid fa-magnifying-glass-dollar"></i></a>
    <a class="btn btn-dark navbar-links" id="Notifications" href="/notifications"><i class='bx bx-bell' ></i></a>


    <div class="dropup">
      <button class="dropdown-toggle text-white dropdown-invisible" type="button" id="dropDownNotifications" data-bs-toggle="dropdown" aria-expanded="false">
        <img src="<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" class="rounded" referrerpolicy="no-referrer">
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end animate slideIn margin-negative-1" aria-labelledby="dropDownNotifications">
        <li><a class="dropdown-item" href="/profile/<?=$user->get("id_user");?>"><i class='bx bx-user-circle' ></i> <?=$user->i18n("my_profile");?></a></li>
        <li><a class="dropdown-item" href="/settings"><i class="fa-solid fa-gear"></i> <?=$user->i18n("settings");?></a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="/logout"><i class='bx bx-log-out'></i> <?=$user->i18n("logout");?></a></li>
      </ul>
    </div>
  </div>
</nav>

<?php if(!$user_details["verified"]) { ?>
  <div class="container">
    <div class="alert alert-warning position-fixed bottom-0 w-75" role="alert" style="z-index: 999;">
      <i class="fa-solid fa-triangle-exclamation"></i> <?= $user->i18n("verify_txt"); ?>
      <button type="button" class="btn-close pull-right" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php } ?>

<script>
  $("#search-bar").keyup(function(){
    if($("#search-bar").val() == ""){
      $("#container-search").empty();
      $("#container-search").removeClass("show");
      return;
    }

    $.ajax({
      url: '/procesos/users/searchUser',
      type: 'POST',
      async: false,
      data: {input: $("#search-bar").val()},
      success: function(data) {
        if(data){
          users = JSON.parse(data);
          
          $("#container-search").empty();
          $("#container-search").addClass("show");
          users.forEach(user => {
            $("#container-search").append('<a href="/profile/'+user["user_id"]+'">'+
                '<div class="new-players-card mt-2">'+
                  '<div class="d-inline-block">'+
                    '<img src="'+user["profile_image"]+'" class="rounded-circle d-inline-block" width="40px" height="40px" referrerpolicy="no-referrer">'+
                    '<span class="ms-3 d-inline-block f-12"><b>@'+user["username"]+'</b></span>'+
                  '</div>'+
                '</div>'+
              '</a>'
            );
          });
        }
      }
    });
  });
</script>