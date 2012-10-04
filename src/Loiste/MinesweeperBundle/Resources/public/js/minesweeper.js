/*!
 * This file contains the front-end logic for the Minesweeper game.
 */$(function() {
    // Find out the route to the makeMove -action.
    var routeMakeMove = $('#game').data('route-make-move');

    $('.game-cell').click(function() {
        
        var audio = $("#beep")[0];
        audio.play();
        // Find out the index of column & row.
        var column = $(this ).index();
        var $tr = $(this).parents('tr');
        var row = $tr.index();

    
        // Make a move.

        window.location = routeMakeMove + '?column=' + column + '&row=' + row; // Simple URL param concatenation.
    });
});

(function($){ 
    $.fn.extend({ 
        
        setGameSize: function () {
       
            var landscape=new Boolean(false);
            var rowCount = $(this).find("tr").length;  
            var colCount =$(this).find("tr:first td").length;
            var width=$(window).width();
            var height=$(window).height();
        
            if (width>height) {
                landscape=true;
            };
    
            var cellHeight=height/rowCount;
            var cellWidth= width/colCount;
            var size =0;

            if (cellHeight>cellWidth) {
                size=Math.floor(cellWidth) ;
            } else {
                size=Math.floor(cellHeight);
            }
            $('img',this).css( "height",size + "px");
            $('img',this).css( "width",size + "px");
        
            /*
        $("#gameAside").html('<p> rows : ' + rowCount + '</p>');
        $("#gameAside").append('<p> cols : ' + colCount + '</p>');
        $("#gameAside").append('<p> window w : ' + width + '</p>');
        $("#gameAside").append('<p> window height: ' + height + '</p>');
        $("#gameAside").append('<p> landscape: ' + landscape + '</p>');
        $("#gameAside").append('<p> cellWidth: ' + cellWidth + '</p>');
        $("#gameAside").append('<p> cellHeight: ' + cellHeight + '</p>');
        $("#gameAside").append('<p> size: ' + (size + "px") + '</p>');
        */
            return this;
        }, 
        removeExtra: function() { 
            $('.header-container',this).remove();
            $('.footer-container',this).remove();
            $('aside',this).remove();
            $("*",this).css( "margin","0");
            $("*",this).css( "padding","0" );
            //$("*").css( "width","0" );
            return this;
        } 
    }); 
})(jQuery);



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