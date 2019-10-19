@extends('admin.base')

@section('pageHeaderOne', '首页')
@section('pageHeaderTwo', '首页')
@section('pageHeaderTwoUrl', '/admin/index')

@section('body')

    <div style="padding: 20px; background-color: #F2F2F2;">
        <div class="layui-row layui-col-space15">

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">交易手续费</div>
                    <div class="layui-card-body">
                        当日：{{$today_tip}} <br>
                        累计：{{$total_tip}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">交易分红手续费</div>
                    <div class="layui-card-body">
                        当日：{{$today_bonus_tip}} <br>
                        累计：{{$total_bonus_tip}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">交易燃烧费</div>
                    <div class="layui-card-body">
                        当日：{{$today_burn}} <br>
                        累计：{{$total_burn}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md3">
                <div class="layui-card">
                    <div class="layui-card-header">交易手续费结余</div>
                    <div class="layui-card-body">
                        当日：{{$today_trade_jy}} <br>
                        累计：{{$total_trade_jy}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">矿机手续费</div>
                    <div class="layui-card-body">
                        当日：{{$today_kuangji_tip}} <br>
                        累计：{{$total_kuangji_tip}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md6">
                <div class="layui-card">
                    <div class="layui-card-header">矿机手续费结余</div>
                    <div class="layui-card-body">
                        当日：{{$today_kuangji_jy}} <br>
                        累计：{{$total_kuangji_jy}}
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">节点奖</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_jd_reward}} <br>
                        交易累计：{{$total_trade_jd_reward}} <br>
                        挖矿单日：{{$today_kuangji_jd_reward}} <br>
                        挖矿累计：{{$total_kuangji_jd_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">小节点奖</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_xjd_reward}} <br>
                        交易累计：{{$total_trade_xjd_reward}} <br>
                        挖矿单日：{{$today_kuangji_xjd_reward}} <br>
                        挖矿累计：{{$total_kuangji_xjd_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">大节点奖</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_djd_reward}} <br>
                        交易累计：{{$total_trade_djd_reward}} <br>
                        挖矿单日：{{$today_kuangji_djd_reward}} <br>
                        挖矿累计：{{$total_kuangji_djd_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">超级节点奖</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_cjjd_reward}} <br>
                        交易累计：{{$total_trade_cjjd_reward}} <br>
                        挖矿单日：{{$today_kuangji_cjjd_reward}} <br>
                        挖矿累计：{{$total_kuangji_cjjd_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">管理奖</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_guanli_reward}} <br>
                        交易累计：{{$total_trade_guanli_reward}} <br>
                        挖矿单日：{{$totay_kuangji_guanli_reward}} <br>
                        挖矿累计：{{$total_kuangji_guanli_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">后台奖励</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_houtai_reward}} <br>
                        交易累计：{{$total_trade_houtai_reward}} <br>
                        挖矿单日：{{$totay_kuangji_houtai_reward}} <br>
                        挖矿累计：{{$total_kuangji_houtai_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">市场奖励</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_shichang_reward}} <br>
                        交易累计：{{$total_trade_shichang_reward}} <br>
                        挖矿单日：{{$totay_kuangji_shichang_reward}} <br>
                        挖矿累计：{{$total_kuangji_shichang_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">团队奖励</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_tuandui_reward}} <br>
                        交易累计：{{$total_trade_tuandui_reward}} <br>
                        挖矿单日：{{$totay_kuangji_tuandui_reward}} <br>
                        挖矿累计：{{$total_kuangji_tuandui_reward}} <br>
                    </div>
                </div>
            </div>

            <div class="layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">合伙人奖励</div>
                    <div class="layui-card-body">
                        交易单日：{{$today_trade_hhr_reward}} <br>
                        交易累计：{{$total_trade_hhr_reward}} <br>
                        挖矿单日：{{$totay_kuangji_hhr_reward}} <br>
                        挖矿累计：{{$total_kuangji_hhr_reward}} <br>
                    </div>
                </div>
            </div>

        </div>
    </div>

@stop
