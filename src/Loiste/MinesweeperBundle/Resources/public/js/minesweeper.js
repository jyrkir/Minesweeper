/*!
 * This file contains the front-end logic for the Minesweeper game.
 */

$(function() {
    // Find out the route to the makeMove -action.
    var routeMakeMove = $('#game').data('route-make-move');

    $('.game-cell').click(function() {
        
        var audio = $("#beep")[0];
        audio.play();
        // Find out the index of column & row.
        var column = $(this).index();
        var $tr = $(this).parents('tr');
        var row = $tr.index();

    
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

/*
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
    
*/
    
    


/*
 *$("#game-container").css( "left","0px" );
$("game-container").css( "top","0px" );
$("#game-container").css( "position","fixed" );
$("#game-container").css( "width","100%" );
$("game-container").css( "height","100%" );
*/
 


});
/*
$(window).resize(function() {
$("#gameAside").html('<p> window w : ' + $(window).width() + '</p>');
$("#gameAside").append('<p> document w : ' + $(document).width() + '</p>');
$("#gameAside").append('<p> window h ' + $(window).height() + '</p>');
$("#gameAside").append('<p> document h : ' + $(document).height() + '</p>');
});
*/