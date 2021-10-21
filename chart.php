
<style>
.parent {
    display: flex;
    width: 100%;
   
    flex-wrap:wrap;
  
}
.canvas-c {
    width: 50%;
    flex: 1 1 auto;
    display: flex;
    justify-content: center;
    align-items: center;
}




</style> 
<div class="parent">
<div class="canvas-c">
 
    <canvas class="chart1"  ></canvas>
 
</div>
<div class="canvas-c">
  
    <canvas class="chart2" ></canvas>
 
</div>
<div class="canvas-c">
  
    <canvas class="chart3" ></canvas>
 
</div>
<div class="canvas-c">
  
    <canvas class="chart4"  ></canvas>
  
</div>


</div> 





<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
<script type="text/javascript" src="chartdata.js"></script>
<script type="text/javascript" src="chartconfig.js"></script>

<script>
/*      
Stacked Bar Chart with Groups
Line Chart
Doughnut
Line Chart Boundaries
*/



var chart1= $('.chart1')[0].getContext('2d');
var myChart = new Chart(chart1,chartConfig.chart1);
var chart2= $('.chart2')[0].getContext('2d');
var myChart2 = new Chart(chart2,chartConfig.chart2);
var chart3= $('.chart3')[0].getContext('2d');
var myChart3 = new Chart(chart3,chartConfig.chart3);
var chart4= $('.chart4')[0].getContext('2d');
var myChart4 = new Chart(chart4,chartConfig.chart4);

</script>    
</body>
</html>