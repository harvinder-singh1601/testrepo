
$(document).ready(function(){
	//Main Aside Navbar
    $(".asideNavBtn button").click(function() {
		if ($(".asideArea").hasClass("in")) {
			$(".asideArea").removeClass("in");
			$('.asideNavBtn button img').attr('src', 'assets/img/side_menu_close.png');
		} else {
		    $(".asideArea").addClass("in");
		    $('.asideNavBtn button img').attr('src', 'assets/img/side_menu_active.png');
		};
    });

    //Gird or List
    $('.dList').click(function(event){
    	event.preventDefault();
    	$('.dContent .item').addClass('list-style');
    	$('.dContent .item').removeClass('grid-style');
    	if ($(".dGrid").hasClass("in")) {
			$(".dGrid").removeClass("in");
			$(".dList").addClass("in");
		}
    });
    $('.dGrid').click(function(event){
    	event.preventDefault();
    	$('.dContent .item').removeClass('list-style');
    	$('.dContent .item').addClass('grid-style');
    	if ($(".dList").hasClass("in")) {
			$(".dList").removeClass("in");
			$(".dGrid").addClass("in");
		}
    });
    $('.pList').click(function(event){
    	event.preventDefault();
    	$('.pContent .item').addClass('list-style');
    	$('.pContent .item').removeClass('grid-style');
    	if ($(".pGrid").hasClass("in")) {
			$(".pGrid").removeClass("in");
			$(".pList").addClass("in");
		}
    });
    $('.pGrid').click(function(event){
    	event.preventDefault();
    	$('.pContent .item').removeClass('list-style');
    	$('.pContent .item').addClass('grid-style');
    	if ($(".pList").hasClass("in")) {
			$(".pList").removeClass("in");
			$(".pGrid").addClass("in");
		}
    });

    $('.gpList').click(function(event){
    	event.preventDefault();
    	$('.gpContent .item').addClass('gp-list');
    	$('.gpContent .item').removeClass('gp-grid');
    	if ($(".gpGrid").hasClass("in")) {
			$(".gpGrid").removeClass("in");
			$(".gpList").addClass("in");
		}
    });
    $('.gpGrid').click(function(event){
    	event.preventDefault();
    	$('.gpContent .item').removeClass('gp-list');
    	$('.gpContent .item').addClass('gp-grid');
    	if ($(".gpList").hasClass("in")) {
			$(".gpList").removeClass("in");
			$(".gpGrid").addClass("in");
		}
    });
    
    //Purchase Credit Pop:: Price bundle
    $(".price-bundle a").click(function() {
    	$(this).addClass('active').siblings().removeClass('active');

    });

    //Get value from the Price Bundle
	$(".price-bundle a").click(function() {

		if($(this).hasClass('active')){
			var creditVal = $(this).text();
			var customCreditVal = $(".cp-value").text();
			$(".total-usd").text(creditVal);
		};    	
	});

	$(function () {
	  var outputPriceVal = $('.total-usd');
	  var customCreditVal = $('.cp-value');

	  $(customCreditVal).on('keyup', function () {
	      outputPriceVal.html("$"+ customCreditVal.val());
	  });
	})

	// Play Game Page: Rating Selection
	$('.rating input').change(function () {
	  var $radio = $(this);
	  $('.rating .selected').removeClass('selected');
	  $radio.closest('label').addClass('selected');
	});

	//For cost range 
   /*  $( function() {
      $( "#cost-range" ).slider({
        range: true,
        min: 0,
        max: 100,
        values: [ 10, 80 ],
        slide: function( event, ui ) {
              $( "#cost-amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
            }
          });

        $( "#cost-amount" ).val( "$" + $( "#cost-range" ).slider( "values", 0 ) +
            " - $" + $( "#cost-range" ).slider( "values", 1 ) );
        });

    //For value range 
     $( function() {
      $( "#value-range" ).slider({
        range: true,
        min: 0,
        max: 1000,
        values: [ 100, 777 ],
        slide: function( event, ui ) {
          $( "#value-amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
        }
      });
      $( "#value-amount" ).val( "$" + $( "#value-range" ).slider( "values", 0 ) +
        " - $" + $( "#value-range" ).slider( "values", 1 ) );
    } );
*/
    //Game Creation Credit Distributor
    $( function() {
      $( "#giCreditSlide" ).slider({
        range: true,
        min: 0,
        max: 100,
        values: [ 30, 60],
        slide: function( event, ui ) {
                $( "#gicdCreator" ).val( ui.values[0] + "%"); 
                $( "#gicdWinner" ).val((ui.values[1] - ui.values[0]) + "%"); 
                $( "#gicdCharity" ).val((100 - ui.values[1]) + "%");
               }
      });
       
    });
    // Am Pm Selection
    $(".giPublish ul li").click(function() {
        $(this).addClass('active').siblings().removeClass('active');

    });
    //Game depends on select
    $('.giDepends select').on('change',function(){ 
        var gidValue = $(this).val();
        var durationBase = $(".duration-base");
        var creditBase = $(".credit-base");

        if (gidValue ==="Duration Based"){
            $(durationBase).addClass("in");
            $(creditBase).removeClass("in");
        }else if (gidValue ==="Min Credit Based"){
            $(creditBase).addClass("in");
            $(durationBase).removeClass("in");
        }else {
            $(durationBase).addClass("in");
            $(creditBase).addClass("in");     
        }
    }); 

    //Game creation title popover
    $(function(){
        $('[data-toggle="popover"]').popover();   
    });

    
});


