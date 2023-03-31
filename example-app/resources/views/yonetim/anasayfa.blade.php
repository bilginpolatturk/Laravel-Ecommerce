@extends('yonetim.layouts.master')
@section('title','Anasayfa')
@section('content')

    <h1 class="page-header">Dashboard</h1>

    <section class="row text-center placeholders">
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Bekleyen Siparişler</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['asd'] }}</h4>
                    <p>data</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Teslim Edilen Ürün</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['teslim_edilen'] }}</h4>
                    <p>Data</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Toplam Satıştaki Ürün</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['toplam_urun'] }}</h4>
                    <p>Data</p>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="panel panel-primary">
                <div class="panel-heading">Toplam Kullanıcı</div>
                <div class="panel-body">
                    <h4>{{ $istatistikler['toplam_kullanici'] }}</h4>
                    <p>Data</p>
                </div>
            </div>
        </div>
    </section>

    <section class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Çok Satan Ürünler</div>
                <div class="panel-body">
                    <canvas id="myChart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6" >

            <canvas id="ilk" width="400" height="400"></canvas>



        </div>

    </section>
    <section class="row">
        <div class="col-sm-6">
            <div class="panel panel-primary">
                <div class="panel-heading">Aylara Göre Satışlar</div>
                <div class="panel-body">
                    <canvas id="chartAylaraGoreSatislar" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
        <div class="col-sm-6" >

            <canvas id="ilk" width="400" height="400"></canvas>



        </div>

    </section>


@endsection

@section('footer')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script>
        @php
        $keys = "";
        $values = "";
        foreach($cok_satan_urunler as $rapor){
            $keys .= "\"$rapor->urun_adi\", ";
            $values .= "$rapor->adet, ";
        }
        @endphp
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [{!! $keys !!}],
                datasets: [{
                    label: 'Çok Satan Ürünler',
                    data: [{!! $values !!}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });

        @php
            $keys1 = "";
            $values1 = "";
            foreach($aylara_gore_satislar as $rapor){
                $keys1 .= "\"$rapor->ay\", ";
                $values1 .= "$rapor->adet, ";
            }
        @endphp
        var ctx2 = document.getElementById('chartAylaraGoreSatislar').getContext('2d');
        var chartAylaraGoreSatislar = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [{!! $keys1 !!}],
                datasets: [{
                    label: 'Aylara Göre Satışlar',
                    data: [{!! $values1 !!}],
                    fill:false,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            stepSize: 1
                        }
                    }]
                }
            }
        });
    </script>
    <script>
        let miktar = [72, 52, 46, 35, 33 ,30];
        let markalar = ['Samsung', 'Huawei', 'Apple','Xiaomi' , 'Oppo', 'Vivo'];

        let kanvas = document.getElementById('ilk');
        let grafik = new Chart(kanvas, {
            type: 'pie',
            data: {
                labels: markalar,
                datasets: [{
                    label: '2018Q3 Telefon Satışı',
                    data: miktar,
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.2)",
                        "rgba(54, 162, 235, 0.2)",
                        "rgba(255, 206, 86, 0.2)",
                        "rgba(75, 192, 192, 0.2)",
                        "rgba(153, 102, 255, 0.2)"
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)"
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    position: "top",
                    align: "middle"
                }}
        });



    </script>
@endsection
