var mediaRecorder = null;
var audioPlayback = null;
var streamingDevice = null;
var recordedChunks = [];
var recordButton = null;
var stopButton = null;
var playButton = null;
var pauseButton = null;
var saveButton = null;
var cancelButton = null;
var maxAudioDuration = 30;
var countDownTimer = null;
var countDown = maxAudioDuration;
// audio-recorder-polyfill.js is used for Safari
var audioPolyFillLocation = document.currentScript.src.replace('easy-voice-mail.js', 'audio-recorder-polyfill.js');

function initVoiceMailUI() {
    var maxDurationInput = document.getElementById("easy_voice_mail_max_duration");

    if (maxDurationInput && parseInt(maxDurationInput.value) >= 10) {
        maxAudioDuration = parseInt(maxDurationInput.value);
    }
    recordButton = document.getElementById("easy_voice_mail_record");
    stopButton = document.getElementById("easy_voice_mail_stop");
    playButton = document.getElementById("easy_voice_mail_play");
    pauseButton = document.getElementById("easy_voice_mail_pause");
    saveButton = document.getElementById("easy_voice_mail_save");
    cancelButton = document.getElementById("easy_voice_mail_cancel");
    countDownP = document.getElementById("easy_voice_mail_countdown");
    if (countDownP !== null) countDownP.innerHTML = maxAudioDuration;

    navigator.getUserMedia = navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia;

    if (navigator.getUserMedia === undefined) {
        updateUI("none", "none", "none", "none", "none", "none");
        return;
    }

    if (!window.MediaRecorder) {
        var script = document.createElement('script');
        script.setAttribute('src', audioPolyFillLocation);
        document.body.appendChild(script);
    }
    recordButton.addEventListener("click", record);
    stopButton.addEventListener("click", stop);
    playButton.addEventListener("click", play);
    pauseButton.addEventListener("click", pause);
    saveButton.addEventListener("click", save);
    cancelButton.addEventListener("click", cancel);
    updateUI("block", "none", "none", "none", "none", "none");
}

function updateUI(btnRecord, btnStop, btnPlay, btnPause, btnSave, btnCancel) {
    recordButton.style.display = btnRecord;
    stopButton.style.display = btnStop;
    playButton.style.display = btnPlay;
    pauseButton.style.display = btnPause;
    saveButton.style.display = btnSave;
    cancelButton.style.display = btnCancel;
}

function record() {
    navigator.mediaDevices.getUserMedia({ audio: true, video: false })
        .then(handleSuccess).catch(error => {
            alert("Please check if microphone access is granted");
        })
}

function stop() {
    if (mediaRecorder) mediaRecorder.stop();
    if (streamingDevice) {
        streamingDevice.getTracks().forEach(function (track) {
            track.stop();
        });
    }
    updateUI("none", "none", "block", "none", "block", "block");
    clearInterval(countDownTimer);
    if (countDownP !== null) countDownP.innerHTML = maxAudioDuration;
}

function play() {
    if (audioPlayback) audioPlayback.play();
    updateUI("none", "none", "none", "block", "block", "block");
}

function pause() {
    if (audioPlayback) audioPlayback.pause();
    updateUI("none", "none", "block", "none", "block", "block");
}

function save() {
    var reader = new FileReader();
    reader.readAsDataURL(recordedChunks[0]);
    reader.onloadend = function () {
        var base64data = reader.result;
        var form = document.querySelector("#easy-voice-mail-form");
        form.querySelector("input").value = base64data;
        form.submit();
    }
}

function cancel() {
    recordedChunks = [];
    if (streamingDevice) {
        streamingDevice.getTracks().forEach(function (track) {
            track.stop();
        });
    }
    updateUI("block", "none", "none", "none", "none", "none");
    clearInterval(countDownTimer);
    if (countDownP !== null) countDownP.innerHTML = maxAudioDuration;
}



const handleSuccess = function (stream) {
    countDown = maxAudioDuration;
    countDownTimer = setInterval(() => {
        if (countDownP !== null) countDownP.innerHTML = countDown;
        if (countDown > 0) countDown--;
        else stop();
    }, 1000);
    streamingDevice = stream;
    updateUI("none", "block", "none", "none", "none", "block");
    const options = { mimeType: 'audio/webm', audioBitsPerSecond: 8000 };
    mediaRecorder = new MediaRecorder(stream, options);
    mediaRecorder.addEventListener('dataavailable', function (e) {
        if (e.data.size > 0) {
            recordedChunks.push(e.data);
        }
    });

    mediaRecorder.addEventListener('stop', function () {
        audioPlayback = new Audio();
        audioPlayback.src = URL.createObjectURL(new Blob(recordedChunks));
        audioPlayback.onended = function () {
            updateUI("none", "none", "block", "none", "block", "block");
        }
    });
    mediaRecorder.start();
}

window.onload = function () {
    initVoiceMailUI();
}
