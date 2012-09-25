/*!
 * This file contains the front-end logic for the Minesweeper game.
 */

$(function() {
    // Find out the route to the makeMove -action.
    var routeMakeMove = $('#game').data('route-make-move');

    $('.game-cell').click(function() {
        // Find out the index of column & row.
        var column = $(this).index();
        var $tr = $(this).parents('tr');
        var row = $tr.index();
      
        var audio = $("#beep")[0];
        audio.play();

    
        // Make a move.

        window.location = routeMakeMove + '?column=' + column + '&row=' + row; // Simple URL param concatenation.
    });
});

$(document).ready(function () {

    //if not first page hide info..
    if(window.location.href.indexOf("makeMove") >=0) {
        $("#info").css( "width","0" );
        $("#message").text("");                 

    } else {
        
        $("#message").text("Game info here...");
        $("#message").append("<br>Click anywhere to start..")
        $("#info").css( "width","100%" );
        $("#info").css( "height","100%" );
    
        //hide info on click
        $("#info").click(function() {

            $("#message").text("");
            $("#urls").text("");
            $("#info").stop().animate({
                "width": "0"
            }, {
                duration:500
            });
        }); 
    }
    
 

    
    
    $(".mine").each(function(){
        var audio = $("#boom")[0];
        audio.play();
        $("#info").animate({
            width: "100%",
            height: "100%",
            opacity: 0.4,
            fontSize: "3em",
            borderWidth: "10px"
        }, 1500 );
  
        $("#message").text("YOU LOOSS, BOOM");
        $("#urls").show("fast");
    });

 
    
   


});
