@extends('layouts.main')
@section('title', 'Gráfica de '.$data[10])


@section('icon_title')
<i class="far fa-chart-bar"></i>
@endsection


@section('content')
                <input type="hidden" value="{{$data[0]}}" id="one">
                <input type="hidden" value="{{$data[1]}}" id="two">
                <input type="hidden" value="{{$data[2]}}" id="three">
                <input type="hidden" value="{{$data[3]}}" id="four">
                <input type="hidden" value="{{$data[4]}}" id="five">
                <input type="hidden" value="{{$data[5]}}" id="six">
                <input type="hidden" value="{{$data[6]}}" id="seven">
                <form>
                Total de tickets
                <input type=text readonly  class="form-control" value="{{$data[7]}}">
                Promedio de satisfacción en el servicio brindado
                <input type=text readonly  class="form-control" value="{{$data[8]}}">
                Actividad en la que está más involucrado
                <input type=text readonly  class="form-control" value="{{$data[9]}}">
                </form>
                    

<br>

<div class="row col-12">
<canvas id="myChart" width="800" height="400"></canvas>
</div>

         
   
@endsection
@section('scripts')
<script>
    var one = document.getElementById('one').value;
    var two = document.getElementById('two').value;
    var three = document.getElementById('three').value;
    var four = document.getElementById('four').value;
    var five = document.getElementById('five').value;
    var six = document.getElementById('six').value;
    var seven = document.getElementById('seven').value;
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Abiertos','Proceso', 'Cancelados','Cerrados','Cerrados en reapertura', 'Vencidos', 'Vencidos en reapertura'],
        datasets: [{
            label: 'Tickets',
            data: [document.getElementById('one').value,
            document.getElementById('two').value,
            document.getElementById('three').value,
            document.getElementById('four').value,
            document.getElementById('five').value,
            document.getElementById('six').value,
            document.getElementById('seven').value,
            ],
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
                    beginAtZero: true
                }
            }]
        }
    }
});
  

</script>

@endsection




