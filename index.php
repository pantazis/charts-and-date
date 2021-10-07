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


    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery/src/sizzle/dist/sizzle.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/moment/locale/el.js"></script>
    <script src="bower_components/knockout/dist/knockout.js"></script>
    <script src="bower_components/knockout-daterangepicker/dist/daterangepicker.js?<?=rand(1,1000)?>"></script>
    <?php include 'data.php' ?>

    <script>
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

});


function getCalendarData(start,end,period){
  searchDataObj.startDate =start;
  searchDataObj.endDate=end;
  searchDataObj.period=period;
  console.log(searchDataObj);
}

function hackDates(period){

  switch (period) {
    case "day":
      Obj.startDate =Object.keys(data.day)[0];
      Obj.endDate = Object.keys(data.day)[3];
    break;
    case "week":
      Obj.startDate = Object.keys(data.week)[0];
      Obj.endDate = Object.keys(data.week)[3];
    break;
    case "month":
      Obj.startDate = Object.keys(data.month)[0];
      Obj.endDate = Object.keys(data.month)[3];
    break;
    case "quarter":
      Obj.startDate = Object.keys(data.quarter)[0];
      Obj.endDate = Object.keys(data.quarter)[3];
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
filteredData.period = period;
filteredData[starDateEndOfDay.format(dateFormat)] = data[period][starDateEndOfDay.format(dateFormat)];


while ( starDateEndOfDay.add(1, period+'s').diff(endDateEndOfDay) <= 0 ) {

  filteredData[starDateEndOfDay.format(dateFormat)] = data[period][starDateEndOfDay.format(dateFormat)];

}
console.log(filteredData);
}
</script>


</body>
</html>