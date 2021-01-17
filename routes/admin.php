<?php

Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::get('logout', 'LoginController@logout');
Route::post('logout', 'LoginController@logout');

// 公共接口
Route::group(['prefix' => 'common'], function () {

    Route::post('upload', 'CommonController@upload'); // 上传
    Route::post('send', 'CommonController@send'); // 发送短信

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
  	Route::any('user/minus_ore_pool', ['as' => 'admin.user.edit', 'uses' => 'UserController@minusOrePool']);
    Route::any('user/ajax', ['as' => 'admin.user.edit', 'uses' => 'UserController@ajax']);
    Route::any('user/index', ['as' => 'admin.user.index', 'uses' => 'UserController@index']);
  
  	Route::any('user/opspeed', ['as' => 'admin.user.edit', 'uses' => 'UserController@openSpeed']);
    Route::any('user/ophead', ['as' => 'admin.user.edit', 'uses' => 'UserController@openHead']);
    Route::any('user/opmana', ['as' => 'admin.user.edit', 'uses' => 'UserController@openMana']);
  
  	Route::any('user/enery_head_lv', ['as' => 'admin.user.edit', 'uses' => 'UserController@eneryHeadLv']);
    Route::any('user/enery_head_lv_adjust', ['as' => 'admin.user.edit', 'uses' => 'UserController@eneryHeadLvAdjust']);
  
  	Route::any('user/independent_management', ['as' => 'admin.user.edit', 'uses' => 'UserController@independentManagement']);
    Route::any('user/independent_management_adjust', ['as' => 'admin.user.edit', 'uses' => 'UserController@independentManagementAdjust']);
  
  	Route::any('user/community_sanxia', ['as' => 'adpartnermin.user.edit', 'uses' => 'UserController@communitySanxia']);
    Route::any('user/community_sanxia_adjust', ['as' => 'admin.user.edit', 'uses' => 'UserController@communitySanxiaAdjust']);
  
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

    // 交易手续费
    Route::post('ex_service/ajax', ['as' => 'admin.ex_service.index', 'uses' => 'ExServiceController@ajax']);
    Route::get('ex_service', ['as' => 'admin.ex_service.index', 'uses' => 'ExServiceController@index']);
    Route::any('ex_service/index', ['as' => 'admin.ex_service.index', 'uses' => 'ExServiceController@index']);


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
    Route::resource('partner', 'PartnerController', ['names' => ['update' => 'admin.partner.edit', 'store' => 'admin.partner.create']]);

    // 社区列表
    Route::any('community/ajax', ['as' => 'admin.community.edit', 'uses' => 'CommunityController@ajax']);
    Route::get('community', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']);
    Route::any('community/index', ['as' => 'admin.community.index', 'uses' => 'CommunityController@index']);

    // 新商城分类
    Route::any('mall_category/index', ['as' => 'admin.mall_category.index', 'uses' => 'MallCategoryController@index']);
    Route::resource('mall_category', 'MallCategoryController', ['names' => ['update' => 'admin.mall_category.edit', 'store' => 'admin.mall_category.create']]);

    // 新商城轮播图
    Route::any('mall_banner/index', ['as' => 'admin.mall_banner.index', 'uses' => 'MallBannerController@index']);
    Route::resource('mall_banner', 'MallBannerController', ['names' => ['update' => 'admin.mall_banner.edit', 'store' => 'admin.mall_banner.create']]);

    // 新商城店铺
    Route::post('mall_store/ajax', ['as' => 'admin.mall_store.edit', 'uses' => 'MallStoreController@ajax']);
    Route::get('mall_store', ['as' => 'admin.mall_store.index', 'uses' => 'MallStoreController@index']);
    Route::any('mall_store/index', ['as' => 'admin.mall_store.index', 'uses' => 'MallStoreController@index']);

    // 新商城商品
    Route::any('mall_goods/edit', ['as' => 'admin.mall_goods.edit', 'uses' => 'MallGoodsController@edit']);
    Route::post('mall_goods/ajax', ['as' => 'admin.mall_goods.edit', 'uses' => 'MallGoodsController@ajax']);
    Route::get('mall_goods', ['as' => 'admin.mall_goods.index', 'uses' => 'MallGoodsController@index']);
    Route::any('mall_goods/index', ['as' => 'admin.mall_goods.index', 'uses' => 'MallGoodsController@index']);

    // 新商城订单
    Route::post('mall_order/ajax', ['as' => 'admin.mall_order.edit', 'uses' => 'MallOrderController@ajax']);
    Route::get('mall_order', ['as' => 'admin.mall_order.index', 'uses' => 'MallOrderController@index']);
    Route::any('mall_order/index', ['as' => 'admin.mall_order.index', 'uses' => 'MallOrderController@index']);

    // 矿机列表
    Route::any('kuangji/index', ['as' => 'admin.kuangji.index', 'uses' => 'KuangjiController@index']);
    Route::resource('kuangji', 'KuangjiController', ['names' => ['update' => 'admin.kuangji.edit', 'store' => 'admin.kuangji.create']]);

    // 矿机列表
    Route::any('kuangwei/index', ['as' => 'admin.kuangwei.index', 'uses' => 'KuangWeiController@index']);
    Route::resource('kuangwei', 'KuangWeiController', ['names' => ['update' => 'admin.kuangwei.edit', 'store' => 'admin.kuangwei.create']]);

    // 矿机订单
    Route::get('kuangji_order', ['as' => 'admin.kuangji_order.index', 'uses' => 'KuangjiOrderController@index']);
    Route::any('kuangji_order/index', ['as' => 'admin.kuangji_order.index', 'uses' => 'KuangjiOrderController@index']);

    // 分红数据
    Route::get('reward_data', ['as' => 'admin.reward_data.index', 'uses' => 'RewardDataController@index']);
    Route::any('reward_data/index', ['as' => 'admin.reward_data.index', 'uses' => 'RewardDataController@index']);

    // 分红列表
    Route::get('reward_list', ['as' => 'admin.reward_list.index', 'uses' => 'RewardListController@index']);
    Route::any('reward_list/index', ['as' => 'admin.reward_list.index', 'uses' => 'RewardListController@index']);

    // 灵活矿位
    Route::get('kuangji_linghuo', ['as' => 'admin.kuangji_linghuo.index', 'uses' => 'KuangjiLinghuoController@index']);
    Route::any('kuangji_linghuo/index', ['as' => 'admin.kuangji_linghuo.index', 'uses' => 'KuangjiLinghuoController@index']);

    // 灵活订单
    Route::get('linghuo_order', ['as' => 'admin.linghuo_order.index', 'uses' => 'LinghuoOrderController@index']);
    Route::any('linghuo_order/index', ['as' => 'admin.linghuo_order.index', 'uses' => 'LinghuoOrderController@index']);

    // 指定节点
    Route::any('appoint_bonus/index', ['as' => 'admin.appoint_bonus.index', 'uses' => 'AppointBonusController@index']);
    Route::resource('appoint_bonus', 'AppointBonusController', ['names' => ['update' => 'admin.appoint_bonus.edit', 'store' => 'admin.appoint_bonus.create']]);

    // 能量商品列表
    Route::any('energy_goods/index', ['as' => 'admin.energy_goods.index', 'uses' => 'EnergyGoodsController@index']);
    Route::resource('energy_goods', 'EnergyGoodsController', ['names' => ['update' => 'admin.energy_goods.edit', 'store' => 'admin.energy_goods.create']]);

    // 能量订单列表
    Route::get('energy_order', ['as' => 'admin.energy_order.index', 'uses' => 'EnergyOrderController@index']);
    Route::any('energy_order/index', ['as' => 'admin.energy_order.index', 'uses' => 'EnergyOrderController@index']);

    // 能量兑换列表
    Route::get('energy_exchange', ['as' => 'admin.energy_exchange.index', 'uses' => 'EnergyExchangeController@index']);
    Route::any('energy_exchange/index', ['as' => 'admin.energy_exchange.index', 'uses' => 'EnergyExchangeController@index']);

    // 能量钱包
    Route::any('energy_wallet/addfrozen', ['as' => 'admin.energy_wallet.edit', 'uses' => 'EnergyWalletController@addFrozen']);
    Route::any('energy_wallet/ajax', ['as' => 'admin.energy_wallet.edit', 'uses' => 'EnergyWalletController@ajax']);
    Route::get('energy_wallet', ['as' => 'admin.energy_wallet.index', 'uses' => 'EnergyWalletController@index']);
    Route::any('energy_wallet/index', ['as' => 'admin.energy_wallet.index', 'uses' => 'EnergyWalletController@index']);

    // 质押级别
    Route::any('pledge_levels/index', ['as' => 'admin.pledge_levels.index', 'uses' => 'PledgeLevelsController@index']);
    Route::resource('pledge_levels', 'PledgeLevelsController', ['names' => ['update' => 'admin.pledge_levels.edit', 'store' => 'admin.pledge_levels.create']]);

    // 质押记录
    Route::post('pledge_log/ajax', ['as' => 'admin.pledge_log.edit', 'uses' => 'PledgeLogController@ajax']);
    Route::get('pledge_log', ['as' => 'admin.pledge_log.index', 'uses' => 'PledgeLogController@index']);
    Route::any('pledge_log/index', ['as' => 'admin.pledge_log.index', 'uses' => 'PledgeLogController@index']);

    // 能量日志
    Route::get('energy_log', ['as' => 'admin.energy_log.index', 'uses' => 'EnergyLogController@index']);
    Route::any('energy_log/index', ['as' => 'admin.energy_log.index', 'uses' => 'EnergyLogController@index']);

    // 高级管理奖订单
    Route::post('senior_admin/ajax', ['as' => 'admin.senior_admin.edit', 'uses' => 'SeniorAdminController@ajax']);
    Route::get('senior_admin', ['as' => 'admin.senior_admin.index', 'uses' => 'SeniorAdminController@index']);
    Route::any('senior_admin/index', ['as' => 'admin.senior_admin.index', 'uses' => 'SeniorAdminController@index']);

    // 抽奖商品
    Route::any('lottery_goods/index', ['as' => 'admin.lottery_goods.index', 'uses' => 'LotteryGoodsController@index']);
    Route::resource('lottery_goods', 'LotteryGoodsController', ['names' => ['update' => 'admin.lottery_goods.edit', 'store' => 'admin.lottery_goods.create']]);

    // 抽奖日志
    Route::get('lottery_log', ['as' => 'admin.lottery_log.index', 'uses' => 'LotteryLogController@index']);
    Route::any('lottery_log/index', ['as' => 'admin.lottery_log.index', 'uses' => 'LotteryLogController@index']);

    // 抽奖配置
    Route::post('lottery_config/update', ['as' => 'admin.lottery_config.edit', 'uses' => 'LotteryConfigController@update']);
    Route::get('lottery_config', ['as' => 'admin.lottery_config.index', 'uses' => 'LotteryConfigController@index']);
    Route::any('lottery_config/index', ['as' => 'admin.lottery_config.index', 'uses' => 'LotteryConfigController@index']);

    // 机器人订单
    Route::get('robot_order', ['as' => 'admin.robot_order.index', 'uses' => 'RobotOrderController@index']);
    Route::any('robot_order/index', ['as' => 'admin.robot_order.index', 'uses' => 'RobotOrderController@index']);

    // 机器人配置
    Route::post('robot_config/update', ['as' => 'admin.robot_config.edit', 'uses' => 'RobotConfigController@update']);
    Route::get('robot_config', ['as' => 'admin.robot_config.index', 'uses' => 'RobotConfigController@index']);
    Route::any('robot_config/index', ['as' => 'admin.robot_config.index', 'uses' => 'RobotConfigController@index']);

    // 指定锁仓用户
    Route::any('energy_appoint_user/index', ['as' => 'admin.energy_appoint_user.index', 'uses' => 'EnergyAppointUserController@index']);
    Route::resource('energy_appoint_user', 'EnergyAppointUserController', ['names' => ['update' => 'admin.energy_appoint_user.edit', 'store' => 'admin.energy_appoint_user.create']]);

    // 锁仓能量转账
    Route::get('energy_lock_transfer', ['as' => 'admin.energy_lock_transfer.index', 'uses' => 'EnergyLockTransferController@index']);
    Route::any('energy_lock_transfer/index', ['as' => 'admin.energy_lock_transfer.index', 'uses' => 'EnergyLockTransferController@index']);
  
  	// 星级社群
    Route::any('star_community/index', ['as' => 'admin.star_community.index', 'uses' => 'StarCommunityController@index']);
    Route::resource('star_community', 'StarCommunityController', ['names' => ['update' => 'admin.star_community.edit', 'store' => 'admin.star_community.create']]);

    //iuic矿池信息
    Route::any('iuic_info/index', ['as' => 'admin.iuic_info.index', 'uses' => 'IuicInfoController@index']);
    Route::resource('iuic_info', 'IuicInfoController', ['names' => ['update' => 'admin.iuic_info.edit', 'store' => 'admin.iuic_info.create']]);

    //回购销毁记录
    Route::any('buy_back/index', ['as' => 'admin.buy_back.index', 'uses' => 'BuyBackController@index']);
    Route::resource('buy_back', 'BuyBackController', ['names' => ['update' => 'admin.buy_back.edit', 'store' => 'admin.buy_back.create']]);

    //免责协议
    Route::any('agreement/index', ['as' => 'admin.agreement.index', 'uses' => 'AgreementController@index']);
    Route::resource('agreement', 'AgreementController', ['names' => ['update' => 'admin.agreement.edit', 'store' => 'admin.agreement.create']]);
  
  	Route::any('ceshi', ['as' => 'admin.energy_lock_transfer.index', 'uses' => 'EnergyLockTransferController@index']);
  	
  	
  	//交易手续费抵扣记录
    Route::any('deducion_logs/index', ['as' => 'admin.deducion_logs.index', 'uses' => 'DeducionLogController@index']);
    Route::resource('deducion_logs', 'DeducionLogController', ['names' => ['update' => 'admin.deducion_logs.edit', 'store' => 'admin.deducion_logs.create']]);

    //用户业绩记录
    Route::any('community_div/ajax', ['as' => 'admin.community_div.edit', 'uses' => 'CommunityDivController@ajax']);
    Route::any('community_div/index', ['as' => 'admin.community_div.index', 'uses' => 'CommunityDivController@index']);
    Route::resource('community_div', 'CommunityDivController', ['names' => ['update' => 'admin.community_div.edit', 'store' => 'admin.community_div.create']]);


    // 月度分红日志
    Route::get('bonus_record', ['as' => 'admin.bonus_record.index', 'uses' => 'BonusRecordController@index']);
    Route::any('bonus_record/index', ['as' => 'admin.bonus_record.index', 'uses' => 'BonusRecordController@index']);


    // 团队长加速分红列表
    Route::any('speed_bonus/ajax', ['as' => 'admin.speed_bonus.edit', 'uses' => 'SpeedBonusController@ajax']);
    Route::get('speed_bonus', ['as' => 'admin.speed_bonus.index', 'uses' => 'SpeedBonusController@index']);
    Route::any('speed_bonus/index', ['as' => 'admin.speed_bonus.index', 'uses' => 'SpeedBonusController@index']);
    Route::resource('speed_bonus', 'SpeedBonusController', ['names' => ['update' => 'admin.speed_bonus.edit', 'store' => 'admin.speed_bonus.create']]);

});
