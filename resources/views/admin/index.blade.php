@extends('admin.base')

@section('pageHeaderOne', '首页')
@section('pageHeaderTwo', '首页')
@section('pageHeaderTwoUrl', '/admin/index')

@section('body')

    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">

            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">单日交易挖矿释放</div>
                    <div class="layui-card-body">
                        {{$today_trade_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">单日算力挖矿释放</div>
                    <div class="layui-card-body">
                        {{$today_kuangji_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header"> </div>
                    <div class="layui-card-body">

                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">注册用户</div>
                    <div class="layui-card-body">
                        {{$zc_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">高级会员</div>
                    <div class="layui-card-body">
                        {{$gj_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">普通会员</div>
                    <div class="layui-card-body">
                        {{$pt_user}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">累计交易挖矿释放</div>
                    <div class="layui-card-body">
                        {{$total_trade_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">累计算力挖矿释放</div>
                    <div class="layui-card-body">
                        {{$total_kuangji_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">  </div>
                    <div class="layui-card-body">

                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">矿池总数</div>
                    <div class="layui-card-body">
                        {{$total_ore_pool}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">购买赠送矿池数</div>
                    <div class="layui-card-body">
                        {{$buy_ore_pool}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">推荐赠送矿池数</div>
                    <div class="layui-card-body">
                        {{$recommend_ore_pool}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">当日USDT提现手续费</div>
                    <div class="layui-card-body">
                        {{$today_tixian_tip}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">累计USDT提现手续费</div>
                    <div class="layui-card-body">
                        {{$total_tixian_tip}}
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

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT币币钱包数</div>
                    <div class="layui-card-body">
                        {{$usdt_bb_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT法币钱包数</div>
                    <div class="layui-card-body">
                        {{$usdt_fb_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户USDT卖盘中锁定数量</div>
                    <div class="layui-card-body">
                        {{$usdt_sell_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户USDT买盘中锁定数量</div>
                    <div class="layui-card-body">
                        {{$usdt_buy_num}}
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
