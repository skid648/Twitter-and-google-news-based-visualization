
$(function() {
    var state = true;
    $( "#Instructions" ).click(function() {
    	
      if ( state ) {
        $( "#instructions_text" ).show().animate({
          opacity: 1,
        }, 1000 );
        $("#visualization").addClass("blurred");
        $("#Instructions > i").removeClass("fa fa-question-circle");
        $("#Instructions > i").addClass("fa fa-times-circle");

        
      } else {
        $( "#instructions_text" ).animate({
          opacity: 0,
        }, 1000 ).hide();
         $("#visualization").removeClass("blurred");
         $("#Instructions > i").removeClass("fa fa-times-circle");
         $("#Instructions > i").addClass("fa fa-question-circle");
         
      }
      state = !state;
    });
    $("#page1Content").click(function(){{
    	console.log("clicked page content 1 have to go to page2");
    	$("#page2").css("color","white");
    	$("#page1").css("color","#6B6969");
    	$("#page3").css("color","#6B6969");
    	$("#page1Content").hide();
    	$("#page2Content").show();


    }});
    $("#page2Content").click(function(){{
    	console.log("clicked page content 2 have to go to page3");
    	$("#page3").css("color","white");
    	$("#page2").css("color","#6B6969");
    	$("#page1").css("color","#6B6969");
    	$("#page2Content").hide();
    	$("#page3Content").show();

    }});
    $("#page3Content").click(function(){{
    	console.log("clicked page content 3 have to go to page1");
    	$("#page1").css("color","white");
    	$("#page3").css("color","#6B6969");
    	$("#page2").css("color","#6B6969");
    	$("#page3Content").hide();
    	$("#page1Content").show();

    }});

    $("#page1").click(function(){{
    	console.log("clicked page content 1 have to go to page2");
    	$("#page1").css("color","white");
    	$("#page3").css("color","#6B6969");
    	$("#page2").css("color","#6B6969");
    	$("#page3Content").hide();
    	$("#page2Content").hide();
    	$("#page1Content").show();


    }});
    $("#page2").click(function(){{
    	console.log("clicked page content 2 have to go to page3");
    	$("#page2").css("color","white");
    	$("#page1").css("color","#6B6969");
    	$("#page3").css("color","#6B6969");
    	$("#page1Content").hide();
    	$("#page3Content").hide();
    	$("#page2Content").show();
    	

    }});
    $("#page3").click(function(){{
    	console.log("clicked page content 3 have to go to page1");
    	$("#page3").css("color","white");
    	$("#page2").css("color","#6B6969");
    	$("#page1").css("color","#6B6969");
    	$("#page2Content").hide();
    	$("#page1Content").hide();
    	$("#page3Content").show();

    }});
  });