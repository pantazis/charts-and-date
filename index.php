<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="scss/daterangepicker.css">
</head>
<body>

    <button class="dateButton"  data-bind="daterangepicker: dateRange'">Επιλογή Εύρους Ημερομηνιών</button>
   
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
    <div class="label1"></div>
    <div class="label2"></div>


    <script src="bower_components/jquery/dist/jquery.min.js"></script>



    <script src="js/sizzle.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/el.js"></script>
    <script src="js/knockout.js"></script>
    <script src="js/daterangepicker.js?<?=rand(1,1000)?>"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chartdata.js?<?=rand(1,1000)?>"></script>
    <script src="js/chartconfig.js?<?=rand(1,1000)?>"></script>

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


var template =  {
            "label":"date1",
            "data":[

            ],
            "backgroundColor":[
               "rgb(255, 99, 132)",
               "rgb(255, 159, 64)",
               "rgb(255, 205, 86)",
               "rgb(75, 192, 192)",
               "rgb(54, 162, 235)",
               "rgb(153, 102, 255)",
               "rgb(201, 203, 207)"
            ]
         };



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
var parentDatesChart3=[];
var hasNoData;


$(".dateButton").daterangepicker({
  ranges: {
  'Προηγούμενος μήνας': [moment().subtract(1, 'months'), moment()],
  'Τελευταίοι 6 μήνες': [moment().subtract(180, 'days'), moment()],
  'Πρηγούμενο έτος': [moment().subtract(1, 'year').add(2,'day').startOf('year'), moment()],
  'Όλα τα έτη': 'all-time', /* [minDate, maxDate] */
  'Custom Range': 'custom'
  },
  minDate: moment(Object.keys(data.day)[0],"DDMMYYYY"),
  firstDayOfWeek: 1,
  orientation: 'left',
  expanded: true,
 // forceUpdate: true
  }, function (startDate, endDate, period) {
  Obj.startDate = startDate.format(dateFormat);
  Obj.endDate = endDate.format(dateFormat);





  //setInputval(period);



  var start =Obj.startDate;
  var end = Obj.endDate;

  $(this).html(start + ' – ' + end );
  hasNoData = false;
  getCalendarData(start,end,period);
  getQueriedData();
  if(hasNoData==true){
    return;
  }
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

    break;
  }
}

function gefilteredDatat(){

}


function getQueriedData(){
 var period = searchDataObj.period;
 var startDate = searchDataObj.startDate;
 var endDate = searchDataObj.endDate;



var starDateEndOfDay = moment(startDate,"DDMMYYYY").endOf(period);
var endDateEndOfDay = moment(endDate,"DDMMYYYY").endOf(period);

//console.log(starDateEndOfDay.format("DD/MM/YYYY"));
//console.log(endDateEndOfDay.format("DD/MM/YYYY"));



filteredData = {};

filteredData[period] = {};



filteredData[period][starDateEndOfDay.endOf(period).format(dateFormat)] = data[period][starDateEndOfDay.endOf(period).format(dateFormat)];


while ( starDateEndOfDay.add(1, period+'s').endOf(period).diff(endDateEndOfDay) <= 0 ) {

  filteredData[period][starDateEndOfDay.endOf(period).format(dateFormat)] = data[period][starDateEndOfDay.endOf(period).format(dateFormat)];

}


mergeAndGiveData(period);



}


function loopAndPush(Value,arrs){
      for (const singleValue in Value) {

        if( Value[singleValue] == undefined ){
          nodata([singleValue]["chart1"]);

          hasNoData = true;
          return;

        }




   var datasets = Value[singleValue]["chart1"]["datasets"];
   $(datasets).each(function(index){
    if(arrs.length<datasets.length){
    arrs.push(this.data[0]);
    }else{
      arrs[index]=arrs[index]+this.data[0];
    }
   });

}
}


function nodata(data){


 var charts =[myChart,myChart2,myChart3,myChart4];

  $(charts).each(function(){
      var Chart = this;

        // No data is present
      var ctx = Chart.ctx;
      var width = Chart.width;
      var height = Chart.height


      ctx.save();
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.font = "16px normal 'Helvetica Nueue'";
      ctx.fillText('No data to display', width / 2, height / 2);
      ctx.restore();

  });

}

function joinvalues(sumValue){
  console.log(0);


  var parentArr = [];
  var arrSum = [];
  var arrSum2 = [];
  var arrSum3 = [];


  loopAndPush(sumValue,arrSum);
  if(hasNoData){
    return;
  }







if( moment(Obj.startDate,"DDMMYYYY").add(1, 'years') > moment(Obj.endDate,"DDMMYYYY")){
  console.log(1);



  var yearEndEndOf = moment(Obj.endDate,"DDMMYYYY").endOf('year')
  var  yearEndOfformat = yearEndEndOf.format("YYYY");
  var yearStartEndOf =moment(Obj.startDate,"DDMMYYYY").endOf('year')
  var  yearStartEndOfformat =yearStartEndOf.format("YYYY");





  if( yearStartEndOfformat != yearEndOfformat){
    console.log(2);
    var Value1 = data["year"][yearStartEndOf.format("DD/MM/YYYY")]["chart1"]["datasets"];
    var Value2 = data["year"][yearEndEndOf.format("DD/MM/YYYY")]["chart1"]["datasets"];

    $(Value1).each(function(index){
    arrSum2.push(this["data"][0]);
  });
  parentDatesChart3.push(yearStartEndOfformat);



  $(Value2).each(function(index){
    arrSum3.push(this["data"][0]);
  });

  parentDatesChart3.push(yearEndOfformat);






  }else{

    var sumValue2 = data["year"][yearStartEndOf.format("DD/MM/YYYY")]["chart1"]["datasets"];
  $(sumValue2).each(function(index){
    arrSum2.push(this["data"][0]);
  });

  parentDatesChart3.push(yearStartEndOfformat);


  }
//console.log(moment(Obj.startDate,"DDMMYYYY").format("DD/MM/YYYY"));
//console.log(moment(Obj.endDate,"DDMMYYYY").format("DD/MM/YYYY"));
}


parentDatesChart3.push(moment(Obj.startDate,"DDMMYYYY").format("DD/MM/YYYY")+" - "+moment(Obj.endDate,"DDMMYYYY").format("DD/MM/YYYY"));
parentArr =[arrSum,arrSum2, arrSum3];


return parentArr;

}

function mergeAndGiveData(period){



 emptyLocalDataArr();
 var datanew = filteredData[period];

 var elValuesSort =  joinvalues(datanew);


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




    localData["chart3"]["datasets"] = [];



    $(elValuesSort).each(function(index){


     var timeperiod = parentDatesChart3;

      var valueArr = this;
      if(valueArr.length!=0){


      var ArrNum = index;

        var newdata = JSON.parse(JSON.stringify(template));
        newdata.label = timeperiod[ArrNum];
        localData["chart3"]["datasets"].push(newdata);









      //localData["chart3"]["datasets"][ArrNum]["label"]="asas"+ ArrNum;
      $(valueArr).each(function(){



        localData["chart3"]["datasets"][ArrNum]["data"].push(this);

      });
      }
    });





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
/*
period = data.year;
for(var date in period){
  charts = period[date];
  for(var  chart in  charts){
    var chart=  charts[chart];
    datasets =  chart.datasets;
    $(datasets).each(function(){
      this.data=[];
      var data = this.data;
      data.push(Math.random()*1000);
    });

  }

}
*/

















</script>


</body>
</html>