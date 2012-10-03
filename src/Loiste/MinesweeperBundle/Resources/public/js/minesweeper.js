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

/*
$('#game img').each(function() {
  var pwidth = $(this).parent('td').width();
  $(this).css( "width",pwidth );
    
    var pHeight = $(this).parent('td').height();
  $(this).css( "height",pHeight );
});

*/

    //if not first page hide info..
    if(window.location.href.indexOf("makeMove") >=0) {
        $("#info").css( "width","0" );
        $("#message").text("");                 

    } else {
        

        $("#info").css( "width","100%" );
        $("#info").css( "height","100%" );
    
        //hide info on click
        $("#play").click(function() {


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
            fontSize: "150%m",
            borderWidth: "10px"
        }, 1500 );
  
        $("#message").text("YOU LOOOSE, BOOM");
        $("#urls").show("fast");
    });

 /*
$("#gameAside").append('<p>' + $(window).width() + '</p>');
$("#gameAside").append('<p>' + $(document).width() + '</p>');
$("#gameAside").append('<p>' + $(window).height() + '</p>');
$("#gameAside").append('<p>' + $(document).height() + '</p>');

$("#game-container").css( "left","0px" );
$("game-container").css( "top","0px" );
$("#game-container").css( "position","fixed" );
$("#game-container").css( "width","100%" );
$("game-container").css( "height","100%" );
*/
 


});
