<?php

require_once("{$_SERVER['DOCUMENT_ROOT']}/router.php");

// Static GET
// In the URL -> http://localhost
// The output -> Index
any('/', 'cards/index.php');
any('/publication/$publication_id', 'cards/www/templates/social/publication_details.php');
// Dynamic GET. Example with 1 variable
// Views
// Search
any('/search', 'cards/www/templates/searchCards.php');
//Card Collection
any('/cards/$id_page', 'cards/www/templates/collection-list.php');
any('/cards', 'cards/www/templates/collection-list.php');
get('/get-collection-price', 'cards/www/templates/collection-price.php');

// Users
any('/login', 'cards/www/templates/users/login.php');
any('/forgot-password', 'cards/www/templates/users/forgot_password.php');
any('/forgot-password/$verify_code', 'cards/www/templates/users/change_password.php');
any('/register', 'cards/www/templates/users/register.php');
get('/logout', 'cards/www/templates/users/logout.php');
any('/profile/$user_id', 'cards/www/templates/social/profile.php');
any('/start-config', 'cards/www/templates/social/profile_config.php');
any('/messages/$username', 'cards/www/templates/social/messages_conversation.php');

// Decks
get('/decks', 'cards/www/templates/deck-list.php');
get('/decks/$id_page', 'cards/www/templates/deck-list.php');
get('/decks/new-deck', 'cards/www/templates/deck-edit.php');
get('/decks/edit_deck/$id_deck', 'cards/www/templates/deck-edit.php');
get('/decks/new-deck/$id_deck', 'cards/www/templates/deck-edit.php');
get('/check-cards/$id_deck', 'cards/www/templates/deck-getprice.php');
any('/deck/$id_deck', 'cards/www/templates/viewDeck.php');
get('/deck-export/$id_deck', 'cards/www/templates/deck-export.php');
get('/deck/get-proxies/$id_deck', 'cards/www/templates/get-proxies.php');

// Dashboard
any('/reports', 'cards/www/templates/reports-list.php');
get('/dashboard/$id_verification', 'cards/www/templates/reports-list.php');
any('/settings', 'cards/www/templates/settings/settings.php');
any('/settings/account', 'cards/www/templates/settings/settings-account.php');
any('/settings/shop', 'cards/www/templates/settings/settings-shop.php');
any('/settings/blockusers', 'cards/www/templates/settings/settings-blocked.php');

//Tournaments
get('/tournaments', 'cards/www/templates/tournaments-list.php');
any('/tournaments/$id_page', 'cards/www/templates/tournaments-list.php');
get('/tournaments/view-details/$id_tournament', 'cards/www/templates/tournaments-details.php');
any('/tournaments/edit-tournament/$id_tournament', 'cards/www/templates/tournaments-edit.php');

// Controllers
// Search Cards
get('/searchCards', 'cards/procesos/cards/searchAllCards.php');
post('/addCardsCollection', 'cards/procesos/cards/addCards.php');
post('/autoComplet', 'cards/procesos/cards/autoComplet.php');
post('/getCardById', 'cards/procesos/cards/getCardById.php');
any('/card/$id_card', 'cards/www/templates/card-info.php');

//Card Collection
post('/getCards', 'cards/procesos/cards/getAllCards.php');
post('/removeCard', 'cards/procesos/cards/removeCards.php');

// Decks
post('/procesos/settings/checkSettings', 'cards/procesos/settings/checkSettings.php');
post('/procesos/settings/setSettings', 'cards/procesos/settings/setSettings.php');
post('/procesos/decks/deleteDeck', 'cards/procesos/decks/deleteDeck.php');
get('/procesos/decks/getFirstEdition', 'cards/procesos/cards/getFirstCard.php');
post('/procesos/decks/addDeck', 'cards/procesos/decks/addDeck.php');
post('/getTournamentDetails', 'cards/procesos/tournaments/getTournamentDetails.php');

// USERS
post('/procesos/user/login', "cards/procesos/registerLogin/login.php");
post('/procesos/user/register', 'cards/procesos/registerLogin/registrarUsuario.php');
post('/procesos/users/mail_verification', 'cards/procesos/registerLogin/mail-verification.php');
post('/procesos/users/getDetails', 'cards/procesos/usuarios/getDetails.php');
post('/procesos/users/generateCode', 'cards/procesos/usuarios/generateCode.php');

// Tournaments
post('/procesos/tournaments/new-tournament', 'cards/procesos/tournaments/addTournaments.php');
post('/procesos/tournaments/getTournaments', 'cards/procesos/tournaments/getTournaments.php');
post('/procesos/tournaments/new-game', 'cards/procesos/tournaments/addGame.php');
post('/procesos/tournaments/new-round', 'cards/procesos/tournaments/addRound.php');
post('/procesos/tournaments/getRounds', 'cards/procesos/tournaments/getRounds.php');
post('/procesos/tournaments/getGames', 'cards/procesos/tournaments/getGames.php');

// ########################## 
// SOCIAL NETWORK
any('/tournament-searcher','cards/www/templates/social/tournament_searcher.php');
post('/procesos/publications/likePublication', 'cards/procesos/publications/likePublication.php');
post('/procesos/publications/commentPublication', 'cards/procesos/publications/commentPublication.php');
post('/procesos/publications/getComments', 'cards/procesos/publications/getComments.php');
post('/procesos/publications/getPublicationDetails', 'cards/procesos/publications/getPublicationDetails.php');
post('/procesos/users/searchUser', 'cards/procesos/users/getSearchUser.php');
any('/get-tournament-image/$id_tournament', 'cards/www/templates/get-tournament-image.php');
post('/getPosts', 'cards/procesos/publications/getMorePublications.php');
any('/messages', 'cards/www/templates/social/messages_list.php');
get('/verify/$verify_code', 'cards/www/templates/verify_user.php');

// any can be used for GETs or POSTs
// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','cards/www/templates/404.php');
