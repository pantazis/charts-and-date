<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="bower_components\knockout-daterangepicker\dist\daterangepicker.css">
</head>
<body>
    <button class="dateButton"  data-bind="daterangepicker: dateRange,  daterangepickerOptions: { maxDate: moment() }">Επιλογή Εύρους Ημερομηνιών</button>
    <?php include "chart.php"?>


    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery/src/sizzle/dist/sizzle.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/moment/locale/el.js"></script>
    <script src="bower_components/knockout/dist/knockout.js"></script>
    <script src="bower_components/knockout-daterangepicker/dist/daterangepicker.js?<?=rand(1,1000)?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>
    <script type="text/javascript" src="chartdata.js?<?=rand(1,1000)?>"></script>
    <script type="text/javascript" src="chartconfig.js?<?=rand(1,1000)?>"></script>

    <?php include 'data.php' ?>

    <script>
/*--------------------init chart ------------------------------------*/
var chart1= $('.chart1')[0].getContext('2d');
var myChart = new Chart(chart1,chartConfig.chart1);
var chart2= $('.chart2')[0].getContext('2d');
var myChart2 = new Chart(chart2,chartConfig.chart2);
var chart3= $('.chart3')[0].getContext('2d');
var myChart3 = new Chart(chart3,chartConfig.chart3);
var chart4= $('.chart4')[0].getContext('2d');
var myChart4 = new Chart(chart4,chartConfig.chart4);






/*--------------------init chart end ------------------------------------*/
/*
Stacked Bar Chart with Groups
Line Chart
Doughnut
Line Chart Boundaries
*/
/*get data form daterangepicker*/
var dateFormat ="DD/MM/YYYY";
var Obj  ={
  startDate:"",
  endDate:""
}
const  searchDataObj={
  startDate:null,
  endDate:null,
  period:null
}
//cofiguration for each chart
const tableConfig = {

}

//data after selection
var filteredData;


$(".dateButton").daterangepicker({
  minDate: moment().subtract(2, 'years')
}, function (startDate, endDate, period) {
  startDate = startDate.format(dateFormat);
  endDate = endDate.format(dateFormat);

  hackDates(period);



  var start =Obj.startDate;
  var end = Obj.endDate;

  $(this).html(start + ' – ' + end );
  getCalendarData(start,end,period)
  getQueriedData();
  updatecharts();

  
  




});

function updatecharts(){
  myChart.update();
  myChart2.update();
  myChart3.update();
  myChart4.update();
}


function getCalendarData(start,end,period){
  searchDataObj.startDate =start;
  searchDataObj.endDate=end;
  searchDataObj.period=period;
 
}

function hackDates(period){

  switch (period) {
    case "day":
      Obj.startDate =Object.keys(data.day)[0];
      Obj.endDate = Object.keys(data.day)[2];
    break;
    case "week":
      Obj.startDate = Object.keys(data.week)[0];
      Obj.endDate = Object.keys(data.week)[1];
    break;
    case "month":
      Obj.startDate = Object.keys(data.month)[0];
      Obj.endDate = Object.keys(data.month)[3];
    break;
    case "quarter":
      Obj.startDate = Object.keys(data.quarter)[0];
      Obj.endDate = Object.keys(data.quarter)[2];
    break;
    case "year":
      Obj.startDate = Object.keys(data.year)[0];
      Obj.endDate = Object.keys(data.year)[3];
    break;
  }
}

function getQueriedData(){
 var period = searchDataObj.period;
 var startDate = searchDataObj.startDate;
 var endDate = searchDataObj.endDate;

var starDateEndOfDay = moment(startDate,"DDMMYYYY").startOf(period);
var endDateEndOfDay = moment(endDate,"DDMMYYYY").startOf(period);

filteredData = {};
filteredData[period] = {};

filteredData[period][starDateEndOfDay.format(dateFormat)] = data[period][starDateEndOfDay.format(dateFormat)];


while ( starDateEndOfDay.add(1, period+'s').diff(endDateEndOfDay) <= 0 ) {

  filteredData[period][starDateEndOfDay.format(dateFormat)] = data[period][starDateEndOfDay.format(dateFormat)];

}
mergeAndGiveData(period);


}

function mergeAndGiveData(period){

 emptyLocalDataArr();
 var datanew = filteredData[period];
 
 
 for (const singleData in datanew) {
   date =  datanew[singleData];
   
  for (const chart in  date ) {
   

    var label= createLabel(date[chart],singleData,period);

    


    var datasets =date[chart]["datasets"];
    localData[chart]["labels"].push(label);

      $(datasets).each(function(index){
        var localdataset =localData[chart]["datasets"][index];
        localdataset["label"]=datasets[index]["label"];      
        localdataset["data"].push(datasets[index]["data"][0]);
        
      })
      
      //localData[chart]["datasets"]
      
      
  
   
    
   

   
    
    

  }
     
      
}


  

}


function emptyLocalDataArr(){
  for (const chart in  localData ) {     
  localData[chart]["labels"]=[];
  var datasets =  localData[chart]["datasets"];
  $(datasets).each(function(index){
    var localdataset =localData[chart]["datasets"][index];   
    localdataset["data"]=[];

    
  })
  }
 


}


function createLabel(el,date,period){


  switch(period) {
  case "year":
   return moment(date,"DDMMYYYY").format('YYYY');  
    break;    
    case "quarter":
   var quarter =moment(date,"DDMMYYYY").utc().quarter();   
   return "Q"+quarter;
  
    break;
    case "month":
   return moment(date,"DDMMYYYY").format('MMMM');
  
    break;
    case "day":
   return moment(date,"DDMMYYYY").format("MMM Do");   
    break;
  default:
  return el["labels"][0];
  
    // code block
}


}







</script>


</body>
</html>