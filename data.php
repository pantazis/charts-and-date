<script>
var data ={};
<?php  include "period/day.php" ?>
<?php  include "period/week.php" ?>
<?php include "period/quarter.php" ?>
<?php include "period/month.php" ?>
<?php  include "period/year.php" ?>
/*

var aadata = data.year["31/12/2001"];
var ppp = "week"
var starDateEndOfDay = moment("01/01/2000","DDMMYYYY").endOf(ppp);
var endDateEndOfDay = moment("01/01/2021","DDMMYYYY").endOf(ppp);
console.log(starDateEndOfDay.format("DD/MM/YYYY"),endDateEndOfDay.format("DD/MM/YYYY"))


var i = 0;

var endofyear = starDateEndOfDay.format("DD/MM/YYYY");
data[ppp][endofyear]=aadata

while ( (starDateEndOfDay.add(1, ppp+'s').endOf(ppp)).diff(endDateEndOfDay) <= 0 ) {

console.log(starDateEndOfDay.format("DD/MM/YYYY"),endDateEndOfDay.format("DD/MM/YYYY"))

var endofyear = starDateEndOfDay.endOf(ppp).format("DD/MM/YYYY")

data[ppp][endofyear]=aadata

}

console.log(JSON.stringify(data[ppp]));

*/











</script>