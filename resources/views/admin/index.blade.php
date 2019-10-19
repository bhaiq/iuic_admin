@extends('admin.base')

@section('pageHeaderOne', '首页')
@section('pageHeaderTwo', '首页')
@section('pageHeaderTwoUrl', '/admin/index')

@section('body')

    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">注册用户</div>
                    <div class="layui-card-body">
                        {{$zc_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">高级会员</div>
                    <div class="layui-card-body">
                        {{$gj_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">普通会员</div>
                    <div class="layui-card-body">
                        {{$pt_user}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">矿池总数</div>
                    <div class="layui-card-body">
                        {{$total_ore_pool}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">购买赠送矿池数</div>
                    <div class="layui-card-body">
                        {{$buy_ore_pool}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">推荐赠送矿池数</div>
                    <div class="layui-card-body">
                        {{$recommend_ore_pool}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">单日释放</div>
                    <div class="layui-card-body">
                        {{$dr_release}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">累计释放</div>
                    <div class="layui-card-body">
                        {{$lj_release}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">单日交易手续费</div>
                    <div class="layui-card-body">
                        {{$today_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">单日交易分红手续费</div>
                    <div class="layui-card-body">
                        {{$today_bonus_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">单日燃烧费</div>
                    <div class="layui-card-body">
                        {{$today_burn}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">交易手续费累计</div>
                    <div class="layui-card-body">
                        {{$total_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">交易分红手续费累计</div>
                    <div class="layui-card-body">
                        {{$total_bonus_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">燃烧费累计</div>
                    <div class="layui-card-body">
                        {{$total_burn}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">单日节点奖累计</div>
                    <div class="layui-card-body">
                        {{$jiedian_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">节点奖累计</div>
                    <div class="layui-card-body">
                        {{$jiedian_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">单日管理奖累计</div>
                    <div class="layui-card-body">
                        {{$guanli_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">管理奖累计</div>
                    <div class="layui-card-body">
                        {{$guanli_total}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">单日团队奖累计</div>
                    <div class="layui-card-body">
                        {{$tuandui_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">团队奖累计</div>
                    <div class="layui-card-body">
                        {{$tuandui_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">单日后台奖累计</div>
                    <div class="layui-card-body">
                        {{$houtai_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">后台奖累计</div>
                    <div class="layui-card-body">
                        {{$houtai_total}}
                    </div>
                </div>
            </div>


            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">单日市场奖累计</div>
                    <div class="layui-card-body">
                        {{$shichang_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">市场奖累计</div>
                    <div class="layui-card-body">
                        {{$shichang_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">合伙人当日分红</div>
                    <div class="layui-card-body">
                        {{$partner_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">合伙人累计分红</div>
                    <div class="layui-card-body">
                        {{$partner_total}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">单日结余</div>
                    <div class="layui-card-body">
                        {{$jieyu_today}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">结余累计</div>
                    <div class="layui-card-body">
                        {{$jieyu_total}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT当日提现手续费累计</div>
                    <div class="layui-card-body">
                        {{$today_tb_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT提现手续费累计</div>
                    <div class="layui-card-body">
                        {{$total_tb_tip}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户可用USDT总量</div>
                    <div class="layui-card-body">
                        {{$user_usdt_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户冻结USDT总量</div>
                    <div class="layui-card-body">
                        {{$user_frozen_usdt_num}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC币币钱包数量</div>
                    <div class="layui-card-body">
                        {{$iuic_bb_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC法币钱包数量</div>
                    <div class="layui-card-body">
                        {{$iuic_fb_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户IUIC卖盘中锁定数量</div>
                    <div class="layui-card-body">
                        {{$iuic_sell_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户IUIC买盘中锁定数量</div>
                    <div class="layui-card-body">
                        {{$iuic_buy_num}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
