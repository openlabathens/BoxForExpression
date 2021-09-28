jQuery(document).ready(function( $ ) {

	/* Audio */
	
	//Create initial audio element
	var audioElement = document.createElement('audio');

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
	
});

