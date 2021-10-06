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
    <button class="dateButton"  data-bind="daterangepicker: dateRange,  daterangepickerOptions: { maxDate: moment() }">aaaaaaaaaa</button>


    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/jquery/src/sizzle/dist/sizzle.js"></script>
    <script src="bower_components/moment/min/moment.min.js"></script>
    <script src="bower_components/knockout/dist/knockout.js"></script>
    <script src="bower_components/knockout-daterangepicker/dist/daterangepicker.js?<?=rand(1,1000)?>"></script>
    <?php include 'data.php' ?>
   
    <script>
/*get data form daterangepicker*/
var Obj  ={
  startDate:"",
  endDate:""
} 
const  searchDataObj={
  startDate:null,
  endDate:null,
  period:null
}
/*cofiguration for each chart*/ 
const tableConfig = {

}


$(".dateButton").daterangepicker({
  minDate: moment().subtract(2, 'years')
}, function (startDate, endDate, period) { 
  startDate = startDate.format("DD-MM-YYYY");
  endDate = endDate.format("DD-MM-YYYY");
  
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

 var aaa =data[period][startDate];
console.log(aaa,period)
 


}









</script>
   

</body>
</html>