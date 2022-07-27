/* 
https://github.com/ai/audio-recorder-polyfill/ 

*/

let waveEncoder = () => {
  let BYTES_PER_SAMPLE = 2

  let recorded = []

  function encode (buffer) {
    let length = buffer.length
    let data = new Uint8Array(length * BYTES_PER_SAMPLE)
    for (let i = 0; i < length; i++) {
      let index = i * BYTES_PER_SAMPLE
      let sample = buffer[i]
      if (sample > 1) {
        sample = 1
      } else if (sample < -1) {
        sample = -1
      }
      sample = sample * 32768
      data[index] = sample
      data[index + 1] = sample >> 8
    }
    recorded.push(data)
  }

  function dump (sampleRate) {
    let bufferLength = recorded.length ? recorded[0].length : 0
    let length = recorded.length * bufferLength
    let wav = new Uint8Array(44 + length)
    let view = new DataView(wav.buffer)

    // RIFF identifier 'RIFF'
    view.setUint32(0, 1380533830, false)
    // file length minus RIFF identifier length and file description length
    view.setUint32(4, 36 + length, true)
    // RIFF type 'WAVE'
    view.setUint32(8, 1463899717, false)
    // format chunk identifier 'fmt '
    view.setUint32(12, 1718449184, false)
    // format chunk length
    view.setUint32(16, 16, true)
    // sample format (raw)
    view.setUint16(20, 1, true)
    // channel count
    view.setUint16(22, 1, true)
    // sample rate
    view.setUint32(24, sampleRate, true)
    // byte rate (sample rate * block align)
    view.setUint32(28, sampleRate * BYTES_PER_SAMPLE, true)
    // block align (channel count * bytes per sample)
    view.setUint16(32, BYTES_PER_SAMPLE, true)
    // bits per sample
    view.setUint16(34, 8 * BYTES_PER_SAMPLE, true)
    // data chunk identifier 'data'
    view.setUint32(36, 1684108385, false)
    // data chunk length
    view.setUint32(40, length, true)

    // eslint-disable-next-line unicorn/no-for-loop
    for (let i = 0; i < recorded.length; i++) {
      wav.set(recorded[i], i * bufferLength + 44)
    }

    recorded = []
    postMessage(wav.buffer, [wav.buffer])
  }

  onmessage = e => {
    if (e.data[0] === 'encode') {
      encode(e.data[1])
    } else if (e.data[0] === 'dump') {
      dump(e.data[1])
    }
  }
}

let AudioContext = window.AudioContext || window.webkitAudioContext

function createWorker (fn) {
  let js = fn
    .toString()
    .replace(/^(\(\)\s*=>|function\s*\(\))\s*{/, '')
    .replace(/}$/, '')
  let blob = new Blob([js])
  return new Worker(URL.createObjectURL(blob))
}

function error (method) {
  let event = new Event('error')
  event.data = new Error('Wrong state for ' + method)
  return event
}

let context, processor

/**
 * Audio Recorder with MediaRecorder API.
 *
 * @example
 * navigator.mediaDevices.getUserMedia({ audio: true }).then(stream => {
 *   let recorder = new MediaRecorder(stream)
 * })
 */
class MediaRecorder {
  /**
   * @param {MediaStream} stream The audio stream to record.
   */
  constructor (stream) {
    /**
     * The `MediaStream` passed into the constructor.
     * @type {MediaStream}
     */
    this.stream = stream

    /**
     * The current state of recording process.
     * @type {"inactive"|"recording"|"paused"}
     */
    this.state = 'inactive'

    this.em = document.createDocumentFragment()
    this.encoder = createWorker(MediaRecorder.encoder)

    let recorder = this
    this.encoder.addEventListener('message', e => {
      let event = new Event('dataavailable')
      event.data = new Blob([e.data], { type: recorder.mimeType })
      recorder.em.dispatchEvent(event)
      if (recorder.state === 'inactive') {
        recorder.em.dispatchEvent(new Event('stop'))
      }
    })
  }

  /**
   * Begins recording media.
   *
   * @param {number} [timeslice] The milliseconds to record into each `Blob`.
   *                             If this parameter isn’t included, single `Blob`
   *                             will be recorded.
   *
   * @return {undefined}
   *
   * @example
   * recordButton.addEventListener('click', () => {
   *   recorder.start()
   * })
   */
  start (timeslice) {
    if (this.state !== 'inactive') {
      return this.em.dispatchEvent(error('start'))
    }

    this.state = 'recording'

    if (!context) {
      context = new AudioContext()
    }
    this.clone = this.stream.clone()
    this.input = context.createMediaStreamSource(this.clone)

    if (!processor) {
      processor = context.createScriptProcessor(2048, 1, 1)
    }

    let recorder = this

    recorder.encoder.postMessage(['init', context.sampleRate])

    processor.onaudioprocess = function (e) {
      if (recorder.state === 'recording') {
        recorder.encoder.postMessage([
          'encode', e.inputBuffer.getChannelData(0)
        ])
      }
    }

    this.input.connect(processor)
    processor.connect(context.destination)

    this.em.dispatchEvent(new Event('start'))

    if (timeslice) {
      this.slicing = setInterval(() => {
        if (recorder.state === 'recording') recorder.requestData()
        alert('recording.');
      }, timeslice)
    }

    return undefined
  }

  /**
   * Stop media capture and raise `dataavailable` event with recorded data.
   *
   * @return {undefined}
   *
   * @example
   * finishButton.addEventListener('click', () => {
   *   recorder.stop()
   * })
   */
  stop () {
    if (this.state === 'inactive') {
      return this.em.dispatchEvent(error('stop'))
    }

    this.requestData()
    this.state = 'inactive'
    this.clone.getTracks().forEach(track => {
      track.stop()
    })
    this.input.disconnect()
    return clearInterval(this.slicing)
  }

  /**
   * Pauses recording of media streams.
   *
   * @return {undefined}
   *
   * @example
   * pauseButton.addEventListener('click', () => {
   *   recorder.pause()
   * })
   */
  pause () {
    if (this.state !== 'recording') {
      return this.em.dispatchEvent(error('pause'))
    }

    this.state = 'paused'
    return this.em.dispatchEvent(new Event('pause'))
  }

  /**
   * Resumes media recording when it has been previously paused.
   *
   * @return {undefined}
   *
   * @example
   * resumeButton.addEventListener('click', () => {
   *   recorder.resume()
   * })
   */
  resume () {
    if (this.state !== 'paused') {
      return this.em.dispatchEvent(error('resume'))
    }

    this.state = 'recording'
    return this.em.dispatchEvent(new Event('resume'))
  }

  /**
   * Raise a `dataavailable` event containing the captured media.
   *
   * @return {undefined}
   *
   * @example
   * this.on('nextData', () => {
   *   recorder.requestData()
   * })
   */
  requestData () {
    if (this.state === 'inactive') {
      return this.em.dispatchEvent(error('requestData'))
    }

    return this.encoder.postMessage(['dump', context.sampleRate])
  }

  /**
   * Add listener for specified event type.
   *
   * @param {"start"|"stop"|"pause"|"resume"|"dataavailable"|"error"}
   * type Event type.
   * @param {function} listener The listener function.
   *
   * @return {undefined}
   *
   * @example
   * recorder.addEventListener('dataavailable', e => {
   *   audio.src = URL.createObjectURL(e.data)
   * })
   */
  addEventListener (...args) {
    this.em.addEventListener(...args)
  }

  /**
   * Remove event listener.
   *
   * @param {"start"|"stop"|"pause"|"resume"|"dataavailable"|"error"}
   * type Event type.
   * @param {function} listener The same function used in `addEventListener`.
   *
   * @return {undefined}
   */
  removeEventListener (...args) {
    this.em.removeEventListener(...args)
  }

  /**
   * Calls each of the listeners registered for a given event.
   *
   * @param {Event} event The event object.
   *
   * @return {boolean} Is event was no canceled by any listener.
   */
  dispatchEvent (...args) {
    this.em.dispatchEvent(...args)
  }
}

/**
 * The MIME type that is being used for recording.
 * @type {string}
 */
MediaRecorder.prototype.mimeType = 'audio/wav'

/**
 * Returns `true` if the MIME type specified is one the polyfill can record.
 *
 * This polyfill supports `audio/wav` and `audio/mpeg`.
 *
 * @param {string} mimeType The mimeType to check.
 *
 * @return {boolean} `true` on `audio/wav` and `audio/mpeg` MIME type.
 */
MediaRecorder.isTypeSupported = mimeType => {
  return MediaRecorder.prototype.mimeType === mimeType
}

/**
 * `true` if MediaRecorder can not be polyfilled in the current browser.
 * @type {boolean}
 *
 * @example
 * if (MediaRecorder.notSupported) {
 *   showWarning('Audio recording is not supported in this browser')
 * }
 */
MediaRecorder.notSupported = !navigator.mediaDevices || !AudioContext

/**
 * Converts RAW audio buffer to compressed audio files.
 * It will be loaded to Web Worker.
 * By default, WAVE encoder will be used.
 * @type {function}
 *
 * @example
 * MediaRecorder.prototype.mimeType = 'audio/ogg'
 * MediaRecorder.encoder = oggEncoder
 */
MediaRecorder.encoder = waveEncoder
