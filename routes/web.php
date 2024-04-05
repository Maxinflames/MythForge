<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home Page
Route::get('/', function () {
    if (Session::has('active_campaign')) {
        session()->forget('active_campaign');
    }

    return view('welcome');
});

Route::get('/future-goals', function () {
    if (Session::has('active_campaign')) {
        session()->forget('active_campaign');
    }

    return view('future');
});

// Login/Logout Functionality
Route::get('/login', 'LoginController@index')->name('login'); //

Route::post('/login', 'LoginController@create')->name('login-create'); //

Route::post('/logout', 'LoginController@logout')->name('logout'); //

Route::get('/register', 'RegisterController@index')->name('register'); //

Route::post('/register', 'RegisterController@create')->name('register-create'); //


// User/Account Routes
Route::get('/user', 'UserController@index')->name('account'); //

Route::get('/user/edit', 'UserController@edit')->name('account-edit'); //

Route::post('/user/update', 'UserController@update')->name('account-update'); //

Route::get('/user/{user}', 'UserController@show')->name('account-show'); //



// Item Routes
Route::get('/items', 'ItemController@index')->name('items'); //

Route::post('/items', 'ItemController@itemSearch')->name('itemsSearch'); //

Route::get('/my-items', 'ItemController@itemsById')->name('itemById'); //

Route::post('/my-items', 'ItemController@itemSearch ById')->name('itemSearchById'); //

Route::get('/items/create', 'ItemController@create')->name('itemCreate'); //

Route::post('/items/store', 'ItemController@store')->name('itemStore'); //

Route::get('/items/edit/{item}', 'ItemController@edit')->name('itemEdit'); //

Route::post('/items/update/{item}', 'ItemController@update')->name('itemUpdate'); //

Route::get('/items/{item}', 'ItemController@show')->name('itemDisplay'); //

// Subscribed Item Routes
Route::get('/subscribed-items', 'SubscribedItemController@index')->name('item-subscriptions'); //

Route::post('/subscribed-items', 'SubscribedItemController@search')->name('subscriptionsSearch'); //

Route::post('/subscribe', 'SubscribedItemController@store')->name('subscribe'); //

Route::post('/unsubscribe', 'SubscribedItemController@destroy')->name('unsubscribe'); //

// Application Routes
Route::get('/applications', 'ApplicationController@index')->name('applications'); //

Route::get('/applications/create/{campaign}', 'ApplicationController@create')->name('application-create'); //

Route::post('/applications/store', 'ApplicationController@store')->name('application-store'); //

Route::get('/applications/edit/{application}', 'ApplicationController@edit')->name('applications-edit'); //

Route::post('/applications/update', 'ApplicationController@update')->name('application-update'); //

Route::get('/applications/{application}', 'ApplicationController@show')->name('applications-show'); //

// Loot Group Routes
Route::get('/loot-groups', 'LootGroupController@index')->name('lootGroup');

Route::get('/loot-groups/create', 'LootGroupController@create')->name('lootGroup-create'); //

Route::get('/loot-groups/{loot_group}/edit', 'LootGroupController@edit')->name('lootGroup-edit');

Route::post('/loot-groups/{loot_group}/update', 'LootGroupController@update')->name('lootGroup-update');

Route::post('/loot-groups/store', 'LootGroupController@store')->name('lootGroup-store');

Route::get('/loot-groups/{loot_group}/destroy', 'LootGroupController@destroy')->name('lootGroup-destroy');

Route::get('/loot-groups/{loot_group}', 'LootGroupController@show')->name('lootGroup-show');

// Loot Group Items Routes
Route::get('/loot-groups/{loot_group}/items/add', 'LootGroupItemController@create')->name('lootGroupItem-create');

Route::get('/loot-groups/{loot_group}/loot-table/add', 'LootGroupItemController@lootTable')->name('lootGroupItem-lootTable');

Route::post('/loot-groups/{loot_group}/items/store', 'LootGroupItemController@store')->name('lootGroupItem-store');

Route::post('/loot-groups/{loot_group}/loot-table/{loot_table}/store', 'LootGroupItemController@lootTableStore')->name('lootGroupItem-lootTableStore');

Route::get('/loot-groups/{loot_group}/items/{loot_group_item}/edit', 'LootGroupItemController@edit')->name('lootGroupItemEdit');

Route::post('/loot-groups/{loot_group}/items/{loot_group_item}/update', 'LootGroupItemController@update')->name('lootGroupItemUpdate');

Route::post('/loot-groups/{loot_group}/items/{loot_group_item}/remove', 'LootGroupItemController@destroy')->name('lootGroupItemDestroy');

// Loot Table Routes
Route::get('/loot-tables', 'LootTableController@index')->name('lootTable');

Route::get('/loot-tables/create', 'LootTableController@create')->name('lootTablesCreate');

Route::get('/loot-tables/{loot_table}/edit', 'LootTableController@edit')->name('lootGroupEdit');

Route::post('/loot-tables/{loot_table}/update', 'LootTableController@update')->name('lootGroupUpdate');

Route::post('/loot-tables/store', 'LootTableController@store')->name('lootGroup-store');

Route::get('/loot-tables/{loot_table}/destroy', 'LootTableController@destroy')->name('lootGroupDestroy');

Route::get('/loot-tables/{loot_table}', 'LootTableController@show')->name('lootGroup-show');

// Loot Table Items Routes
Route::get('/loot-tables/{loot_table}/items/add', 'LootTableItemController@create')->name('lootTableItem-create');

Route::post('/loot-tables/{loot_table}/items/store', 'LootTableItemController@store')->name('lootTableItem-store');

Route::get('/loot-tables/{loot_table}/items/{loot_table_item}/edit', 'LootTableItemController@edit')->name('lootTableItem-edit');

Route::post('/loot-tables/{loot_table}/items/{loot_table_item}/update', 'LootTableItemController@update')->name('lootTableItem-update');

Route::post('/loot-tables/{loot_table}/items/{loot_table_item}/remove', 'LootTableItemController@destroy')->name('lootTableItem-destroy');

// Campaign Routes
Route::get('/open-campaigns', 'CampaignController@index')->name('allCampaigns'); //

Route::post('/open-campaigns', 'CampaignController@campaignSearch')->name('allCampaignsSearch'); //

Route::get('/my-campaigns', 'CampaignController@campaignsById')->name('myCampaigns'); //

Route::post('/my-campaigns', 'CampaignController@campaignSearchById')->name('myCampaignsSearch'); //

Route::get('/campaign/create', 'CampaignController@create')->name('campaignCreate'); //

Route::post('/campaign/store', 'CampaignController@store')->name('campaignStore'); //

Route::get('/campaign/edit/{campaign}', 'CampaignController@edit')->name('campaignsEdit'); //

Route::post('/campaign/update/{campaign}', 'CampaignController@update')->name('campaignsUpdate'); //

Route::get('/campaign/{campaign}', 'CampaignController@show')->name('campaign'); //

// Party Display
Route::get('/campaign/{campaign}/players', 'PlayerController@index')->name('player'); //

Route::get('/campaign/{campaign}/players/{player}/edit', 'PlayerController@edit')->name('playerEdit'); //

Route::post('/campaign/{campaign}/players/{player}/update', 'PlayerController@update')->name('playerUpdate'); # Has an issue with specific tiny (file size) image files... No idea why

Route::get('/campaign/{campaign}/players/{player}', 'PlayerController@show')->name('playerDisplay'); //

// Post Routes
Route::get('/campaign/{campaign}/posts', 'CampaignPostController@index')->name('CampaignPosts'); //

Route::get('/campaign/{campaign}/posts/create', 'CampaignPostController@create')->name('CampaignPostCreate'); //

Route::post('/campaign/{campaign}/posts/store', 'CampaignPostController@store')->name('CampaignPoststore'); //

Route::get('/campaign/{campaign}/posts/{post}', 'CampaignPostController@show')->name('CampaignPostDisplay'); //

Route::get('/campaign/{campaign}/posts/{post}/edit', 'CampaignPostController@edit')->name('CampaignPostEdit'); //

Route::post('/campaign/{campaign}/posts/{post}/update', 'CampaignPostController@update')->name('CampaignPostUpdate'); //

// Chats Routes
Route::get('/campaign/{campaign}/chats', 'CampaignChatController@index')->name('CampaignChat'); //

Route::get('/campaign/{campaign}/chats/create', 'CampaignChatController@create')->name('CampaignChatCreate'); //

Route::post('/campaign/{campaign}/chats/store', 'CampaignChatController@store')->name('CampaignChatStore'); //

Route::get('/campaign/{campaign}/chats/{chat}', 'CampaignChatController@show')->name('CampaignChatDisplay'); //

Route::post('/campaign/{campaign}/chats/{chat}/send', 'CampaignMessageController@store')->name('CampaignMessageStore'); //

// Party Inventory
Route::get('/campaign/{campaign}/party-inventory/{party_inventory}', 'PartyInventoryController@index')->name('partyInventory');

Route::get('/campaign/{campaign}/party-inventory/{party_inventory}/add', 'PartyInventoryItemController@create')->name('partyInventoryAdd');

Route::get('/campaign/{campaign}/party-inventory/{party_inventory}/loot-group', 'LootGroupController@partyInventoryDisplay')->name('partyInventoryAdd');

Route::post('/campaign/{campaign}/party-inventory/{party_inventory}/loot-group/{loot_group}/add', 'PartyInventoryItemController@addLootGroup')->name('partyInventoryAddLootGroup');

Route::post('/campaign/{campaign}/party-inventory/{party_inventory}/store', 'PartyInventoryItemController@store')->name('partyInventoryStore');

Route::post('/campaign/{campaign}/party-inventory/{party_inventory}/send', 'PartyInventoryController@send')->name('partyInventorySend');

// Personal Inventory
Route::get('/campaign/{campaign}/player-inventory/{player_inventory}', 'PlayerInventoryController@index')->name('playerInventory');

Route::get('/campaign/{campaign}/player-inventory/{player_inventory}/add', 'PlayerInventoryItemController@create')->name('playerInventoryAdd');

Route::get('/campaign/{campaign}/player-inventory/{player_inventory}/loot-group', 'LootGroupController@playerInventoryDisplay')->name('playerInventoryAdd');

Route::post('/campaign/{campaign}/player-inventory/{player_inventory}/loot-group/{loot_group}/add', 'PlayerInventoryItemController@addLootGroup')->name('playerInventoryAddLootGroup');

Route::post('/campaign/{campaign}/player-inventory/{player_inventory}/store', 'PlayerInventoryItemController@store')->name('playerInventoryStore');

Route::post('/campaign/{campaign}/player-inventory/{player_inventory}/send', 'PlayerInventoryController@send')->name('playerInventorySend');

// Campaign Applications
Route::get('/campaign/{campaign}/applications', 'ApplicationController@applicationById')->name('applications-applicationById'); //
