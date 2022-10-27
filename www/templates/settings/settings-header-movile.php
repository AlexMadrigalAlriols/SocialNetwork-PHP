<div class="card-header border-bottom mb-3 d-flex d-md-none">
    <ul class="nav nav-tabs card-header-tabs nav-gap-x-1 mb-3" role="tablist">
        <li class="nav-item">
            <a href="/settings" data-toggle="tab" class="nav-link has-icon text-white" id="settings-movile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <?= $user->i18n("profile_info"); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="/settings/account" data-toggle="tab" class="nav-link has-icon text-white" id="settings-account-movile">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings mr-2">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <?= $user->i18n("account_settings"); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="/settings/shop" data-toggle="tab" class="nav-link has-icon text-white" id="settings-shop-movile">
                <i class="fa-solid fa-store f-20"></i>
                <?= $user->i18n("shop_settings"); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="/settings/blockusers" data-toggle="tab" class="nav-link has-icon text-white" id="settings-blockusers-movile">
                <i class="fa-solid fa-ban f-20"></i>
                <?= $user->i18n("blocked_users"); ?>
            </a>
        </li>
        <li class="nav-item">
            <a href="/logout" data-toggle="tab" class="nav-link has-icon text-white">
                <i class="bx bx-log-out f-28 align-middle"></i>
                <?= $user->i18n("logout"); ?>
            </a>
        </li>
    </ul>
</div>