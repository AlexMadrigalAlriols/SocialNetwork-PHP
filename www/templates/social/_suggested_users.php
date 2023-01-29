<div class="mt-4 bg-dark text-white rounded container suggested-users-container">
                <div class="p-3">
                    <img src="<?=$user_details["profile_image"];?>" class="rounded-circle d-inline-block" width="50px" height="50px" referrerpolicy="no-referrer">
                    <div class="d-inline-block p-1">
                            <h6 class="f-14"><b><?=$user_details["name"];?> <?php if(userService::checkIfAccountVerified($user_details["user_id"])) { ?> <i class="fa-solid fa-certificate text-purple"></i> <?php } ?></b></h6>
                            <p class="text-muted ms-1 f-12">@<?=$user_details["username"];?></p>
                    </div>
                    <div class="text-center">
                        <a class="btn btn-dark active w-100 mt-3" href="/profile/<?=$user->get("id_user");?>"><?=$user->i18n("view_profile");?></a>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <form method="post" id="frm">
                            <p class="f-13"><b><?=$user->i18n("new_accounts");?></b></p>
                            <?php foreach ($suggested_users as $idx => $user_sugg) { ?>
                                <?php if(!in_array($user_sugg["user_id"], json_decode($user_details["followed"],true)) && $user_sugg["user_id"] != $user->get("id_user") && !userService::isUserBlocked($user->get("id_user"), $user_sugg["user_id"]) && !userService::isUserBlocked($user_sugg["user_id"], $user->get("id_user"))) {?>
                                    <div class="mt-1 p-2 suggested-user-card">
                                        <a href="/profile/@<?=$user_sugg["username"];?>" class="text-decoration-none">
                                            <img src="<?=$user_sugg["profile_image"]?>" class="rounded-circle d-inline-block" width="40px" height="40px" referrerpolicy="no-referrer">
                                            <span class="d-inline-block ms-2 text-white f-13"><b>@<?=$user_sugg["username"]?> <?php if(userService::checkIfAccountVerified($user_sugg["user_id"])) { ?> <i class="fa-solid fa-certificate text-purple"></i> <?php } ?></b></span>
                                        </a>
                                        <button class="mt-2 btn btn-dark btn-follow-suggest" name="commandFollowSuggested" type="submit" value="<?=$user_sugg["user_id"];?>"><b><?=$user->i18n("follow");?></b></button>
                                    </div>
                                <?php } ?> 
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>