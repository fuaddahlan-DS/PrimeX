var amount = 800;
var sky = $('.sky');

for (var i = 0 ; i < amount ; i++ ) {
	var s = $('<div class="star-blink"><div></div></div>');
	s.css({
		'top': Math.random() * 100 + '%',
		'left': Math.random() * 100 + '%',
		'animation': 'blinkAfter 15s infinite ' + Math.random() * 100 + 's ease-out',
		'width': Math.random() * 2 + 7 + 'px',
		'height': Math.random() * 2 + 7 + 'px',
		'opacity': Math.random() * 5 / 10 + 0.5
		});
	if (i % 8 === 0) {
		s.addClass('red');
	} else if (i % 10 === 6) {
		s.addClass('blue');
	}
	sky.append(s);
}
 
$('#step2 , #step3 ').hide();

function goStep2() {
	$('#step1').fadeOut('fast');
    $('#step2').fadeIn('slow');  
    $('#entryform').scrollTop(0);
}

function goStep3() {
	$('#step2').fadeOut('fast');
    $('#step3').fadeIn('slow'); 
    $('#entryform').scrollTop(0);
}
 

function prevstep1() {		
    $('#step2').fadeOut('slow'); 
	$('#step1').fadeIn('fast');
	$('#entryform').scrollTop(0);
}

function prevstep2() {		
    $('#step3').fadeOut('slow'); 
	$('#step2').fadeIn('fast');
	$('#entryform').scrollTop(0);
}


$("#step1-next").click(function() { 
   goStep2();
});

$("#step2-next").click(function() { 
   goStep3();
});


$("#step1-prev").click(function() { 
   prevstep1();
});

$("#step2-prev").click(function() { 
   prevstep2();
});

	 
$(document).ready(function(){
  $("#myModal").on("hidden.bs.modal",function(){
    $("#iframeYoutube").attr("src","#");
  })
})

function changeVideo(vId){
  var iframe=document.getElementById("iframeYoutube");
  iframe.src="https://www.youtube.com/embed/"+vId;

  $("#showcasevideos").modal("show");
}

var $window, $document, $body;

$window = $(window);
$document = $(document);
$body = $("body");

    $window.bind("resizeEnd", function () {
            $(".banner-animation, #fullscreen-banner").height($window.height());
        });

        $window.resize(function () {
            if (this.resizeTO) clearTimeout(this.resizeTO);
            this.resizeTO = setTimeout(function () {
                $(this).trigger("resizeEnd");
            }, 300);
        }).trigger("resize");
