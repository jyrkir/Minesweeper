/*!
 * This file contains the front-end logic for the Minesweeper game.
 */


(function($){ 
    $.fn.extend({ 
        setGameClick: function () {
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
        },
        setGameSize: function () {
       
            var landscape=new Boolean(false);
            var rowCount = $(this).find("tr").length;  
            var colCount =$(this).find("tr:first td").length;
            var width=$(this).parent().width();//$(window).width();
            var height=$(this).parent().height()//$(window).height();
        
            if (width>height) {
                landscape=true;
            }else {
                landscape=false;
            };
    
            var cellHeight=height/rowCount;
            var cellWidth= width/colCount;
            var size =0;

            if (cellHeight>cellWidth) {
                size=Math.floor(cellWidth) ;
            } else {
                size=Math.floor(cellHeight);
            }
            var containerWidth=size*colCount;
            var containerHeight=size*rowCount;
            size=size-5; //borders to show..
            $('.game-cell',this).css( "height",size + "px");
            $('.game-cell',this).css( "width",size + "px");
            
            $('img',this).css( "width",size + "px");
            $('img',this).css( "width",size + "px");
            
             
            $($(this)).css( "width", containerWidth + "px");
            $('#game',this).css( "height",containerHeight + "px");
 
        
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
            //    $('.header-container',this).remove();
            //    $('.footer-container',this).remove();
            //    $('aside',this).remove();
            $("*",this).css( "margin","auto");
            $("*",this).css( "padding","0" );
            //$("*").css( "width","0" );
            return this;
        },
        fullscreen: function() { 
            
            return this.each(function() {
                    
                $("#first").css( "z-index","1000");
                $("#first").css( "background-color","black");
                $("#first").css( "position","absolute");
                $("#first").css( "left","0");
                $("#first").css( "right","0");
                $("#first").css( "top","0");
                $("#first").css( "bottom","0");
                $("#first").css( "width","100%");
                $("#first").css( "height","100%");
                $(this).appendTo("#first");
                    
            });
        },
        gameOver: function() { 

            return this.each(function() {
                
                $(document).ready(function () {
                    $(this).css( "height","0" );
                    $(this).css( "width","0" );
                    $(this).animate({
                        width: "100%",
                        height: "100%",
                        opacity: 0.6,
                        fontSize: "150%",
                        borderWidth: "10px"
                    }, 1500 );
                    
                });
            });
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
                       

    }); 
    



/*
$(window).resize(function() {
$("#gameAside").html('<p> window w : ' + $(window).width() + '</p>');
$("#gameAside").append('<p> document w : ' + $(document).width() + '</p>');
$("#gameAside").append('<p> window h ' + $(window).height() + '</p>');
$("#gameAside").append('<p> document h : ' + $(document).height() + '</p>');
});
*/