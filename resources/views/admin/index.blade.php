@extends('admin.base')

@section('pageHeaderOne', '首页')
@section('pageHeaderTwo', '首页')
@section('pageHeaderTwoUrl', '/admin/index')

@section('body')

    <div style="padding: 20px; background-color: #F2F2F2;">


        <div class="layui-row layui-col-space15">

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">注册用户</div>
                    <div class="layui-card-body">
                        {{$zc_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC高级会员</div>
                    <div class="layui-card-body">
                        {{$gj_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC普通会员</div>
                    <div class="layui-card-body">
                        {{$pt_user}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">能量会员数</div>
                    <div class="layui-card-body">
                        {{$nl_user}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md12"></div>

            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">交易挖矿释放总数</div>
                    <div class="layui-card-body">
                        {{$total_trade_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC矿池释放总数</div>
                    <div class="layui-card-body">
                        {{$total_ore_pool}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">灵活矿机释放总数</div>
                    <div class="layui-card-body">
                        {{$total_linghuo_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">当日释放总数</div>
                    <div class="layui-card-body">
                        {{$today_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC累计释放总数</div>
                    <div class="layui-card-body">
                        {{$total_release}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md12"></div>

            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">IUIC剩余矿池总数</div>
                    <div class="layui-card-body">
                        {{$iuic_surplus_kc_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">灵活矿机剩余总数</div>
                    <div class="layui-card-body">
                        {{$linghuo_surplus_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">能量剩余矿池总数</div>
                    <div class="layui-card-body">
                        {{$energy_surplus_total}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">能量矿池当日释放数</div>
                    <div class="layui-card-body">
                        {{$energy_today_release}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md2">
                <div class="layui-card">
                    <div class="layui-card-header">能量累计释放总数</div>
                    <div class="layui-card-body">
                        {{$energy_total_release}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md12"></div>

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

            <div class="layui-col-md12"></div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT币币钱包数量</div>
                    <div class="layui-card-body">
                        {{$usdt_bb_num}}
                    </div>
                </div>
            </div>
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">USDT法币钱包数量</div>
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
            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">用户矿池手续费数量</div>
                    <div class="layui-card-body">
                        {{$service_charge}}
                    </div>
                </div>
            </div>

        </div>

    </div>

@stop
