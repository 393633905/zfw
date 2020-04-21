@extends('admin.common.main')
@section('cnt')
<div class="page-container">
    <p class="f-20 text-success">尊敬的管理员：<span class="f-18">{{auth()->user()->username}} </span></p>
    <p>上次登录IP：222.35.131.79.1  上次登录时间：2014-6-14 11:19:55</p>

    <article>
        <div id="echarts" style="width: 600px;height:400px; margin-top: 20px"></div>
    </article>
</div>
@endsection

@section('js')
    <script src="/js/echarts.min.js"></script>
    <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
        var myChart = echarts.init(document.getElementById('echarts'));

        myChart.setOption({
            title: {
                text: '房屋出租率统计',
                subtext: '出租率',
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
                orient: 'vertical',
                left: 'left',
                data: ['已出租', '未出租']
            },
            series: [
                {
                    name: '访问来源',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '60%'],
                    data: [
                        {value: "{{$rent_num}}", name: '已出租'},
                        {value: "{{$no_rent_num}}", name: '未出租'},
                    ],
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: 'rgba(0, 0, 0, 0.5)'
                        }
                    }
                }
            ]
        });
    </script>
@endsection