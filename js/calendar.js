complete = false;
var selectedMonth;
var selectedDay;
var selectedHour;
var selectedYear = "2015";
$(window).scroll(function(){

        if ($(window).scrollTop() > $("#visualization").offset().top - 50 && complete == false){
            //alert("opa");
            $("#instructions").animate({
              marginLeft: "0px"
            },700,function(){

              complete = true;
              setTimeout(function(){

               $("#instructions").animate({
                marginLeft : "-350px"
               },700)

              }, 3000);

            });
        }

    });



$(".month").hover(function() {
  $(this).animate({
    backgroundColor: "#3A111C",
    color: "#F4D03F",
  }, 200);
}, function() {
  if ($(this).hasClass("open")) {} else {
    $(this).animate({
      backgroundColor: "#50A5C7",
      color: "#3A111C"
    }, 200);
  }
});

$('#daypicker').on('mouseenter', '.hours', function() {
  $(this).animate({
    backgroundColor: "#3A111C",
    color: "white"
  }, 200);
});

$('#daypicker').on('mouseout', '.hours', function() {
  $(this).animate({
    backgroundColor: "#4188A3",
    color: "#3A111C"
  }, 200);
});

//CLICKING IN

$(".month").click(function() {

  $("#calendarHeader").text("Pick A Day");

  $('html, body').animate({
        scrollTop: $("#calendarHeader").offset().top-250
    }, 1000);


  $(this).text($(this).attr("id"));


  selectedMonth = getMonthFromString($(this).attr("id"));

  $(this).addClass("open");

  $("#close").show();

  month = ($(this)[0].innerHTML);

  $('.month').not($(this)).hide(300);

  $(this).animate({
    width: "100%",
    fontSize: "50"

  });

  $("#daypicker").animate({
    height: "400px",
    marginTop: "-100px"
  });

  $("#calendarHeader").animate({
    marginBottom: "50px"
    

  });

  $(".days30").remove();
  $(".days31").remove();
  $(".hours").remove();
  if (month == "January" || month == "March" || month == "May" || month == "July" || month == "August" || month == "October" || month == "December") {
    //31 days
    for (i = 1; i <= 31; i++) {
      $("#daypicker").append("<div class='days31' id='" + i + "'>" + i + "</div>");
    }

  } else if (month == "April" || month == "June" || month == "September" || month == "November") {

    //30 days
    for (i = 1; i <= 30; i++) {
      $("#daypicker").append("<div class='days30' id='" + i + "'>" + i + "</div>");
    }

  } else {

    //29 days
    for (i = 1; i <= 29; i++) {
      $("#daypicker").append("<div class='days30' id='" + i + "'>" + i + "</div>");
    }

  }

  

});
//CLICKING OUT
$("div").not("#daypicker").not(".month").click(function() {

  $("#calendarHeader").text("Pick A Month");

  $("#close").hide();
  console.log(window.width);

  
  $(".month").animate({
    width: /*"8.3%"*/""+(((window.width+55)/12)-2)+"px",
    fontSize: "13"
  }, function() {
    $(this).text($(this).attr("id"));

  });
  $(".month").show(300);

  $("#daypicker").animate({
    height: "100px",
    marginBottom: "0px",
    marginTop:"0px"

  });

  $("#calendarHeader").animate({
    marginBottom: "0px"
  });

  $(".days30").remove();
  $(".days31").remove();
  $(".hours").remove();
  $(".month.open").removeClass("open");
  $(".month").animate({
    backgroundColor: "#50A5C7",
    color: "#000624"
  });
});

//DAYS 

$('#daypicker').on('click', '.days30', function() {

  $("#calendarHeader").text("Pick An Hour");

  $(".hours").remove();

  $(".days30").not($(this)).hide(300);

  $(this).animate({
    width: "100%",
    height: "70px",
    fontSize: "30",
    lineHeight: "60px",
    backgroundColor: "#3A111C",
    color: "F4D03F",

  }, function() {
    var day = $(this).text();
    $(this).addClass("yellow");
    $(this).slideUp("slow");

    var month = $(".open").text();
    $(".open").text(day + " " + month);
     selectedDay = day;
    
  });

  for (i = 1; i <= 24; i++) {
    if(i == 24){
      $("#daypicker").append("<div class='hours' id='00'>00</div>");
    }else{
    $("#daypicker").append("<div class='hours' id='" + i + "'>" + i + "</div>");
  }
  }

 
});

$('#daypicker').on('click', '.days31', function() {

  $("#calendarHeader").text("Pick An Hour");

  $(".hours").remove();

  $('.days31').not($(this)).hide(300);
  $(this).animate({
    width: "100%",
    height: "70px",
    fontSize: "30",
    lineHeight: "60px",
    backgroundColor: "#3A111C",

  }, function() {
    var day = $(this).text();
    $(this).addClass("yellow");
    $(this).slideUp("slow");

    var month = $(".open").text();
    $(".open").text(day + " " + month);
    selectedDay = day;
  });

  for (i = 1; i <= 24; i++) {
    if(i == 24){
      $("#daypicker").append("<div class='hours' id='00'>00</div>");
    }else{
    $("#daypicker").append("<div class='hours' id='" + i + "'>" + i + "</div>");
  }
  }
});

$('#daypicker').on('click', '.hours', function() {

   $("#calendarHeader").text("");

  $(".hours").not($(this)).hide(300);
  $(this).animate({
    width: "100%",
    height: "70px",
    fontSize: "30",
    lineHeight: "60px",
    backgroundColor: "#3A111C",
    color: "F4D03F",

  }, function() {
    var hour = $(this).text();
    $(this).addClass("yellow");
    $(this).slideUp("slow");

    var month = $(".open").text();
    $(".open").text(hour + ":00, " + month +", 2015");
    
    //console.log($(".open").text());
    $("#daypicker").animate({
      height: "100px",
      marginTop: "0px"
    },function(){
      $("#calendarHeader").animate({
         marginBottom: "0px"
      },300);
       $('html, body').animate({
        scrollTop: $("#visualization").offset().top+20
    }, 1000);
    });

    month = ("0" + selectedMonth).slice(-2);
  
    day = ("0" + selectedDay).slice(-2);
    hour = ("0" + hour).slice(-2);

    var dir = "../nodenews/backend/data/" +selectedYear+"-"+month+"-"+day+"-"+hour+"/basic-graph-data.json";
    todate = selectedYear+"-"+month+"-"+day+"-"+hour;
     UpdateGraph(width, height, r, color, force, svg, dir,640,todate)
    
  });



  

});

function getMonthFromString(mon){
   return new Date(Date.parse(mon +" 1, 2012")).getMonth()+1
}