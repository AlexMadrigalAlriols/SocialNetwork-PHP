
<?php
    require_once("cards/framework/globalController.php");
    $user = &fwUser::getInstance();
    $user_details = userService::getUserDetails($user->get("id_user"));

    $user_notifications = notificationService::getAllNotificationByUser($user->get("id_user"));
?>

<nav class="navbar navbar-expand-lg bg-dark p-3">
  <div class="container-fluid">
    <div id="header-lef container">
      <a class="navbar-brand d-inline-block" href="/"><i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">Collection Saver</span> </a>
      <div class="d-inline-block col-md-7">
        <form class="d-flex input-searchbar-header" role="search">
          <span class="input-group-text search-icon" id="basic-addon1"><i class='bx bx-search-alt-2'></i></span>
          <input class="form-control me-2 search_bar" id="search-bar" type="search" placeholder="<?=$user->i18n("search_bar");?>" aria-label="Search" aria-describedby="basic-addon1">
        </form>
        <div id="form-body bg-dark margin-dropdown">
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
          <div class="dropdown">
            <a class="btn btn-dark navbar-links" id="Notifications" id="dropdown-Notify" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bx-bell' ></i></a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end animate slideIn bg-dark text-white width-20 margin-negative-1" aria-labelledby="dropdown-Notify">
                  <div class="p-2">
                        <p class="f-13"><b><?=$user->i18n("notifications");?></b></p>
                        <hr>
                        <?php foreach ($user_notifications as $idx => $noti) { ?>
                          <a class="text-decoration-none text-white" href="<?php if($noti["notification_type"] == NOTIFICATION_TYPE_COMMENTED || $noti["notification_type"] == NOTIFICATION_TYPE_LIKE) { ?> /publication/<?=$noti["id_publication"];?> <?php } else { ?> /profile/<?= $noti["trigger_user_id"]; ?> <?php } ?>">
                            <div class="mt-1 p-2 ms-3 notification-card">
                                <img src="/<?=$noti["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                                <div class="d-inline-block">
                                  <span class="ms-1 d-inline-block f-10"><b>@<?=$noti["username"]?></b></span>
                                  <span class="f-10"><?=$user->i18n($noti["notification_type"]);?></span>
                                  <span class="text-muted f-10"> - <?=fwTime::getPassedTime($noti["notification_date"]);?></span>
                                </div>
                            </div>
                          </a>
                        <?php } ?>
                    </div>
            </ul>
          </div>

        </div>
        <div class="dropdown">
          <button class="dropdown-toggle text-white dropdown-invisible" type="button" id="dropDownNotifications" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="/<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" class="rounded">
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
    <div class="dropup">
      <a class="btn btn-dark navbar-links" id="Notifications" id="dropdown-Notify" data-bs-toggle="dropdown" aria-expanded="false"><i class='bx bx-bell' ></i></a>
      <ul class="dropdown-menu dropdown-menu-end animate slideIn bg-dark text-white width-20 margin-negative-1" aria-labelledby="dropdown-Notify">
        <div class="p-2">
          <p class="f-13"><b><?=$user->i18n("notifications");?></b></p>
          <hr>
          <?php foreach ($user_notifications as $idx => $noti) { ?>
            <a class="text-decoration-none text-white" href="<?php if($noti["notification_type"] == NOTIFICATION_TYPE_COMMENTED || $noti["notification_type"] == NOTIFICATION_TYPE_LIKE) { ?> /publication/<?=$noti["id_publication"];?> <?php } else { ?> /profile/<?= $noti["trigger_user_id"]; ?> <?php } ?>">
              <div class="mt-1 p-2 ms-3 notification-card">
                <img src="/<?=$noti["profile_image"];?>" class="rounded-circle d-inline-block" width="40px" height="40px">
                <div class="d-inline-block">
                  <span class="ms-1 d-inline-block f-10"><b>@<?=$noti["username"]?></b></span>
                  <span class="f-10"><?=$user->i18n($noti["notification_type"]);?></span>
                  <span class="text-muted f-10"> - <?=fwTime::getPassedTime($noti["notification_date"]);?></span>
                </div>
              </div>
            </a>
          <?php } ?>
        </div>
      </ul>
    </div>

    <a class="text-white dropdown-invisible" href="/profile/<?=$user_details["username"];?>" aria-expanded="false">
      <img src="/<?=$user_details["profile_image"]; ?>" alt="" width="45px" height="45px" class="rounded">
    </a>
  </div>
</nav>

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
                  '<img src="/'+user["profile_image"]+'" class="rounded-circle d-inline-block" width="40px" height="40px">'+
                  '<div class="d-inline-block">'+
                    '<span class="ms-1 d-inline-block f-8"><b>'+user["name"]+'</b></span>'+
                    '<span class="text-muted ms-1 f-8"> @'+user["username"]+'</span>'+
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