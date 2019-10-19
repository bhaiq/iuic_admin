<?php

Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

// 公共接口
Route::group(['prefix' => 'common'], function () {

    Route::post('upload', 'CommonController@upload'); // 上传

});

Route::group(['middleware' => ['auth:admin', 'menu', 'authAdmin']], function () {

    Route::get('/', ['as' => 'admin.index.index', 'uses' => 'IndexController@index']);
    Route::get('/index', ['as' => 'admin.index.index', 'uses' => 'IndexController@index']);

    // 权限管理
    Route::get('permission', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::any('permission/index', ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index']);
    Route::get('permission/create', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@create']);
    Route::post('permission', ['as' => 'admin.permission.create', 'uses' => 'PermissionController@store']);
    Route::get('permission/{id}/edit', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@edit'])->where('id', '[0-9]+');
    Route::put('permission/{id}', ['as' => 'admin.permission.edit', 'uses' => 'PermissionController@update'])->where('id', '[0-9]+');
    Route::delete('permission/{id}', ['as' => 'admin.permission.destroy', 'uses' => 'PermissionController@destroy'])->where('id', '[0-9]+');

    // 角色管理
    Route::any('role/index', ['as' => 'admin.role.index', 'uses' => 'RoleController@index']);
    Route::resource('role', 'RoleController', ['names' => ['update' => 'admin.role.edit', 'store' => 'admin.role.create']]);

    // 管理员
    Route::any('admin/index', ['as' => 'admin.admin.index', 'uses' => 'AdminController@index']);
    Route::post('admin/ajax', ['as' => 'admin.admin.edit', 'uses' => 'AdminController@ajax']);
    Route::resource('admin', 'AdminController', ['names' => ['update' => 'admin.admin.edit', 'store' => 'admin.admin.create']]);

    // 管理日志
    Route::get('admin_log', ['as' => 'admin.admin_log.index', 'uses' => 'AdminLogController@index']);
    Route::any('admin_log/index', ['as' => 'admin.admin_log.index', 'uses' => 'AdminLogController@index']);

    // 用户管理
    Route::any('user/status', ['as' => 'admin.user.edit', 'uses' => 'UserController@setStatus']);
    Route::any('user/add_ore_pool', ['as' => 'admin.user.edit', 'uses' => 'UserController@addOrePool']);
    Route::any('user/ajax', ['as' => 'admin.user.edit', 'uses' => 'UserController@ajax']);
    Route::any('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
    Route::resource('user', 'UserController', ['names' => ['update' => 'admin.user.edit', 'store' => 'admin.user.create']]);

    // 钱包列表
    Route::any('wallet/ajax', ['as' => 'admin.wallet.edit', 'uses' => 'WalletController@ajax']);
    Route::get('wallet', ['as' => 'admin.wallet.index', 'uses' => 'WalletController@index']);
    Route::any('wallet/index', ['as' => 'admin.wallet.index', 'uses' => 'WalletController@index']);

    // 用户认证
    Route::post('user_auth/ajax', ['as' => 'admin.user_auth.edit', 'uses' => 'UserAuthController@ajax']);
    Route::get('user_auth', ['as' => 'admin.user_auth.index', 'uses' => 'UserAuthController@index']);
    Route::any('user_auth/index', ['as' => 'admin.user_auth.index', 'uses' => 'UserAuthController@index']);

    // 钱包日志
    Route::get('wallet_log', ['as' => 'admin.wallet_log.index', 'uses' => 'WalletLogController@index']);
    Route::any('wallet_log/index', ['as' => 'admin.wallet_log.index', 'uses' => 'WalletLogController@index']);

    // 商品列表
    Route::any('goods/index', ['as' => 'admin.goods.index', 'uses' => 'GoodsController@index']);
    Route::resource('goods', 'GoodsController', ['names' => ['update' => 'admin.goods.edit', 'store' => 'admin.goods.create']]);

    // 商城订单
    Route::get('shop_order', ['as' => 'admin.shop_order.index', 'uses' => 'ShopOrderController@index']);
    Route::any('shop_order/index', ['as' => 'admin.shop_order.index', 'uses' => 'ShopOrderController@index']);

    // 交易对
    Route::any('ex_team/index', ['as' => 'admin.ex_team.index', 'uses' => 'ExTeamController@index']);
    Route::resource('ex_team', 'ExTeamController', ['names' => ['update' => 'admin.ex_team.edit', 'store' => 'admin.ex_team.create']]);

    // 币种设置
    Route::any('coin/index', ['as' => 'admin.coin.index', 'uses' => 'CoinController@index']);
    Route::resource('coin', 'CoinController', ['names' => ['update' => 'admin.coin.edit', 'store' => 'admin.coin.create']]);

    // 提现订单
    Route::post('coin_extract/ajax', ['as' => 'admin.coin_extract.edit', 'uses' => 'CoinExtractController@ajax']);
    Route::get('coin_extract', ['as' => 'admin.coin_extract.index', 'uses' => 'CoinExtractController@index']);
    Route::any('coin_extract/index', ['as' => 'admin.coin_extract.index', 'uses' => 'CoinExtractController@index']);

    // 公告列表
    Route::any('notice/index', ['as' => 'admin.notice.index', 'uses' => 'NoticeController@index']);
    Route::resource('notice', 'NoticeController', ['names' => ['update' => 'admin.notice.edit', 'store' => 'admin.notice.create']]);

    // 资讯列表
    Route::any('news/index', ['as' => 'admin.news.index', 'uses' => 'NewsController@index']);
    Route::resource('news', 'NewsController', ['names' => ['update' => 'admin.news.edit', 'store' => 'admin.news.create']]);

    // 轮播图
    Route::any('banner/index', ['as' => 'admin.banner.index', 'uses' => 'BannerController@index']);
    Route::resource('banner', 'BannerController', ['names' => ['update' => 'admin.banner.edit', 'store' => 'admin.banner.create']]);

    // 版本管理
    Route::any('version/index', ['as' => 'admin.version.index', 'uses' => 'VersionController@index']);
    Route::resource('version', 'VersionController', ['names' => ['update' => 'admin.version.edit', 'store' => 'admin.version.create']]);

    // 商家认证
    Route::any('business_auth/ajax', ['as' => 'admin.business_auth.edit', 'uses' => 'BusinessAuthController@ajax']);
    Route::get('business_auth', ['as' => 'admin.business_auth.index', 'uses' => 'BusinessAuthController@index']);
    Route::any('business_auth/index', ['as' => 'admin.business_auth.index', 'uses' => 'BusinessAuthController@index']);

    // 配置列表
    Route::post('config/update', ['as' => 'admin.config.edit', 'uses' => 'ConfigController@update']);
    Route::get('config', ['as' => 'admin.config.index', 'uses' => 'ConfigController@index']);
    Route::any('config/index', ['as' => 'admin.config.index', 'uses' => 'ConfigController@index']);

    // 额外的奖励
    Route::any('extra_bonus/index', ['as' => 'admin.extra_bonus.index', 'uses' => 'ExtraBonusController@index']);
    Route::resource('extra_bonus', 'ExtraBonusController', ['names' => ['update' => 'admin.extra_bonus.edit', 'store' => 'admin.extra_bonus.create']]);

    // 免手续费
    Route::any('not_tip/index', ['as' => 'admin.not_tip.index', 'uses' => 'NotTipController@index']);
    Route::resource('not_tip', 'NotTipController', ['names' => ['update' => 'admin.not_tip.edit', 'store' => 'admin.not_tip.create']]);

    // 用户关系图
    Route::get('user_relation', ['as' => 'admin.user_relation.index', 'uses' => 'UserRelationController@index']);
    Route::any('user_relation/index', ['as' => 'admin.user_relation.index', 'uses' => 'UserRelationController@index']);

    // 持币统计
    Route::get('hold_coin', ['as' => 'admin.hold_coin.index', 'uses' => 'HoldCoinController@index']);
    Route::any('hold_coin/index', ['as' => 'admin.hold_coin.index', 'uses' => 'HoldCoinController@index']);

    // 持币详细
    Route::get('hold_user', ['as' => 'admin.hold_user.index', 'uses' => 'HoldCoinController@user']);
    Route::any('hold_user/index', ['as' => 'admin.hold_user.index', 'uses' => 'HoldCoinController@user']);

    // 数据汇总
    Route::get('info_collect', ['as' => 'admin.info_collect.index', 'uses' => 'InfoCollectController@index']);
    Route::any('info_collect/index', ['as' => 'admin.info_collect.index', 'uses' => 'InfoCollectController@index']);

    // OTC交易订单
    Route::post('otc_order/ajax', ['as' => 'admin.otc_order.edit', 'uses' => 'OtcOrderController@ajax']);
    Route::get('otc_order', ['as' => 'admin.otc_order.index', 'uses' => 'OtcOrderController@index']);
    Route::any('otc_order/index', ['as' => 'admin.otc_order.index', 'uses' => 'OtcOrderController@index']);

    // 币币订单
    Route::get('ex_order', ['as' => 'admin.ex_order.index', 'uses' => 'ExOrderController@index']);
    Route::any('ex_order/index', ['as' => 'admin.ex_order.index', 'uses' => 'ExOrderController@index']);

    // 币币深度
    Route::get('bb_depth', ['as' => 'admin.bb_depth.index', 'uses' => 'BbDepthController@index']);
    Route::any('bb_depth/index', ['as' => 'admin.bb_depth.index', 'uses' => 'BbDepthController@index']);

    // 余额统计
    Route::get('wallet_total', ['as' => 'admin.wallet_total.index', 'uses' => 'WalletTotalController@index']);
    Route::any('wallet_total/index', ['as' => 'admin.wallet_total.index', 'uses' => 'WalletTotalController@index']);

    // 报单统计
    Route::get('bd_total', ['as' => 'admin.bd_total.index', 'uses' => 'BdTotalController@index']);
    Route::any('bd_total/index', ['as' => 'admin.bd_total.index', 'uses' => 'BdTotalController@index']);

    // 合伙人列表
    Route::any('partner/ajax', ['as' => 'admin.partner.edit', 'uses' => 'PartnerController@ajax']);
    Route::get('partner', ['as' => 'admin.partner.index', 'uses' => 'PartnerController@index']);
    Route::any('partner/index', ['as' => 'admin.partner.index', 'uses' => 'PartnerController@index']);

    // 社区列表
    Route::any('community/ajax', ['as' => 'admin.community.edit', 'uses' => 'CommunityController@ajax']);
    Route::get('community', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']);
    Route::any('community/index', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']);

});
