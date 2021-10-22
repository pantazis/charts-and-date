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
    <div class="label1"></div>
    <div class="label2"></div>


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
  minDate: moment().subtract(2, 'years'),
  firstDayOfWeek: 1
}, function (startDate, endDate, period) {
  Obj.startDate = startDate.format(dateFormat);
  Obj.endDate = endDate.format(dateFormat);

  setInputval(period);



  var start =Obj.startDate;
  var end = Obj.endDate;

  $(this).html(start + ' – ' + end ); 
  getCalendarData(start,end,period);
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

function setInputval(period){



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
      Obj.startDate = Object.keys(data.year)[5];
      Obj.endDate = Object.keys(data.year)[3];
      console.log(Obj);
    break;
  }
}

function gefilteredDatat(period,starDateEndOfDay,endDateEndOfDay){

  filteredData[period][starDateEndOfDay.endOf(period).format(dateFormat)] = data[period][starDateEndOfDay.endOf(period).format(dateFormat)];


while ( starDateEndOfDay.add(1, period+'s').endOf(period).diff(endDateEndOfDay) <= 0 ) {

  filteredData[period][starDateEndOfDay.endOf(period).format(dateFormat)] = data[period][starDateEndOfDay.endOf(period).format(dateFormat)];

}

}


function getQueriedData(){
 var period = searchDataObj.period;
 var startDate = searchDataObj.startDate;
 var endDate = searchDataObj.endDate;
 


var starDateEndOfDay = moment(startDate,"DDMMYYYY").endOf(period);
var endDateEndOfDay = moment(endDate,"DDMMYYYY").endOf(period);

console.log(starDateEndOfDay.format("DD/MM/YYYY"));
console.log(endDateEndOfDay.format("DD/MM/YYYY"));



filteredData = {};

filteredData[period] = {};

gefilteredDatat(period,starDateEndOfDay,endDateEndOfDay)

gefilteredDatat("year")





console.log(filteredData);
mergeAndGiveData(period);



}

function joinvalues(sumValue){
 
  var arrSum = [];
  for (const singleValue in sumValue) {

 
   var datasets = sumValue[singleValue]["chart1"]["datasets"];
   $(datasets).each(function(index){
    if(arrSum.length<datasets.length){
    arrSum.push(this.data[0]);
    }else{      
      arrSum[index]=arrSum[index]+this.data[0];
    }

   });

}
return arrSum;
}

function mergeAndGiveData(period){
 
  

 emptyLocalDataArr();
 var datanew = filteredData[period];

 var elValuesSort =  joinvalues(datanew);
 var elValuesLong =  joinvalues(datanew);
 
 var i = 0;
 for (const singleData in datanew) {
   
   date =  datanew[singleData];
   
  for (const chart in  date ) {

   if(chart!='chart3'){  
   

    var label= createLabel(date[chart],singleData,period);

    


    var datasets =date[chart]["datasets"];
    localData[chart]["labels"].push(label);

      $(datasets).each(function(index){
        var localdataset =localData[chart]["datasets"][index];
        localdataset["label"]=datasets[index]["label"];      
        localdataset["data"].push(datasets[index]["data"][0]);
        
      })

    };   
    if(chart=='chart3' ){

      if(i==0){
      var obj = {};
      $(date["chart1"].datasets).each(function(){
        
      obj[this.label]=this.label;

      })

      for (const label in obj) {      
      localData["chart3"]["labels"].push(label)
    }
   
              
    $(elValuesSort).each(function(){        
    //localData["chart3"]["datasets"][1]["data"].push(this)
    
    });
    $(elValuesLong).each(function(){        
    localData["chart3"]["datasets"][0]["data"].push(this)
    
    });
    $(".label1 .label2").html("");
    $(".label1").html(localData["chart3"]["datasets"][0]["label"])
    $(".label2").html(localData["chart3"]["datasets"][1]["label"])

   

    
  }


    }

   
    
      
      //localData[chart]["datasets"]
      
      
  
   
    
   

   
    
    

  }
     
i++;    
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
   return "Q"+quarter+" "+moment(date,"DDMMYYYY").format('YYYY');
  
    break;
    case "month":
   return moment(date,"DDMMYYYY").format('MMMM');
  
    break;  
    
      case "week":
   return moment(date,"DDMMYYYY").format("dddd DD MMM");   
    break;
    case "day":
   return moment(date,"DDMMYYYY").format("dd DD MMM");   
    break;
  default:
  return el["labels"][0];
  
    // code block
}


}







</script>


</body>
</html>