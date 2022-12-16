jQuery(document).ready(function( $ ) {
	//Add Input for answer
	$('#easy-voice-mail-form').append('<input type="hidden" id="question-input" name="question_id">');
	//When click number
	$('.q-number').click(function(){
		//Hide text
		$('.q-text').hide();
		//Get number & id
		var questionNumber = $(this).data('number');
		var questionID = $(this).data('id');
		//Show question
		$("#q-text-"+questionNumber).show();
		//Set ID
		$("#question-input").val(questionID); 
	});
		//Hide / Show animation
		$('#easy_voice_mail_record').click(function(){
			$('.talk-animation').show();
		});
		$('#easy_voice_mail_cancel').click(function(){
			$('.talk-animation').hide();
		});
		$('#easy_voice_mail_stop').click(function(){
			$('.talk-animation').hide();
		});
	//Set images 
	var recordUrl = $('#talk-thumb').val() ; 
	$("#easy_voice_mail_record").html('<img src="'+recordUrl+'">');
	var playUrl = $('#play-icon').val() ; 
	$("#easy_voice_mail_play").html('<img src="'+playUrl+'">');
	var stopUrl = $('#stop-icon').val() ; 
	$("#easy_voice_mail_pause").html('<img src="'+stopUrl+'">');
	$("#easy_voice_mail_stop").html('<img src="'+stopUrl+'">');
	var cancelUrl = $('#cancel-icon').val() ; 
	$("#easy_voice_mail_cancel").html('<img src="'+cancelUrl+'">');
	var saveUrl = $('#save-icon').val() ; 
	var saveText = $('#send-text').val() ; 
	$("#easy_voice_mail_save").html('<img src="'+saveUrl+'">'+'<span>'+saveText+'</span>');
});