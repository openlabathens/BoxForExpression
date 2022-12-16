jQuery(document).ready(function( $ ) {

	/* Audio */
	
	//Create initial audio element
	var audioElement = document.createElement('audio');

	//Open Listen List
	$("#listen-cta").click(function(){
		$(".explore-cta").hide();
		$("#listen-modal").show();
		$('#close-modal').show();
	});

	//Show Audio Answer
	$(".answer-audio").click(function(){
		//Hide Controls & Stop Audio
		$("#audio-controls").hide();
		audioElement.pause();
		$("#play").show();
		$('#pause').hide();
		//Get Question Text
		var questionText = $(this).data('question');
		$("#view-question-audio").text(questionText);
		//Get Color
		var questionColor = $(this).data('color');
		$("#audio-controls").css("background-color",questionColor);
		//Get Audio
		var audioUrl = $(this).data('audio');
		audioElement.setAttribute('src', audioUrl);
		//Show Controls
		$("#audio-controls").show();
	});

	//Play
	$("#play").click(function(){
		$("#play").hide();
		$('#pause').show();
		audioElement.play();
	});

	$("#pause").click(function(){
		audioElement.pause();
		$("#play").show();
		$('#pause').hide();
	});

	/* Written */

	//Open Read List
	$("#read-cta").click(function(){
		$(".explore-cta").hide();
		$("#read-modal").show();
		$('#close-modal').show();
	});

	//Show Written Answer
	$(".answer-written").click(function(){
		//Hide Controls
		$("#written-controls").hide();
		//Get Question Text
		var questionText = $(this).data('question');
		$("#view-question-written").text(questionText);
		//Get Color
		var questionColor = $(this).data('color');
		$("#written-controls").css("background-color",questionColor);
		//Get Image
		var imgUrl = $(this).data('image');
		$("#image-view").attr('src', imgUrl);
		//Show Controls
		$("#written-controls").show();
	});

	//Show Image Full
	$("#show-image").click(function(){
		$(".image-view-container").addClass("full");
	});

	//Hide Image Full
	$("#hide-image").click(function(){
		$(".image-view-container").removeClass("full");
	});

	/* Close modal */

	$('#close-modal').click(function(){
		$(".explore-modal").hide();
		$('#close-modal').hide();
		$(".explore-cta").show();
	});

	
});

