function eacyVoiceMailDeleteConfirmation(event){
    if(!confirm( 'Are you sure you want to delete all messages ?' )){
        event.preventDefault();
    }
}