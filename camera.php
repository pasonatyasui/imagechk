<!DOCTYPE html>
<html lang="ja" dir="ltr" itemscope itemtype="http://schema.org/Article">
<head>
  <meta charset="utf-8">
</head>
<body>
    <div class="camera">
        <video id="video">Video stream not available.</video>
    </div><br>
    <button id="startbutton">Take photo</button><br>
    <canvas id="canvas">
    <textarea id="readStr"></textarea>
    </canvas>
<script>
let width = 320    // We will scale the photo width to this
let height = 0     // This will be computed based on the input stream

let streaming = false

let video = null
let canvas = null
let photo = null
let startbutton = null
let constrains = { video: true, audio: false }

/**
 * ���[�U�[�̃f�o�C�X�ɂ��J�����\�����J�n���A
 * �e�{�^���̋�����ݒ肷��
 *
 */
function startup() {
  video = document.getElementById('video')
  canvas = document.getElementById('canvas')
  photo = document.getElementById('photo')
  startbutton = document.getElementById('startbutton')

  videoStart()

  video.addEventListener('canplay', function(ev){
    if (!streaming) {
      height = video.videoHeight / (video.videoWidth/width)

      video.setAttribute('width', width)
      video.setAttribute('height', height)
      canvas.setAttribute('width', width)
      canvas.setAttribute('height', height)
      streaming = true
    }
  }, false)

  // �utake photo�v�{�^�����Ƃ鋓�����`
  startbutton.addEventListener('click', function(ev){
    takepicture()
    ev.preventDefault()
  }, false);

  clearphoto()
}

/**
 * �J����������J�n����
 */
function videoStart() {
  streaming = false
  navigator.mediaDevices.getUserMedia(constrains)
  .then(function(stream) {
      video.srcObject = stream
      video.play()
  })
  .catch(function(err) {
      console.log("An error occured! " + err)
  })
}

/**
 * canvas�̎ʐ^�̈������������
 */
function clearphoto() {
  let context = canvas.getContext('2d')
  context.fillStyle = "#AAA"
  context.fillRect(0, 0, canvas.width, canvas.height)
}

/**
 * �J�����ɕ\������Ă��錻�݂̏󋵂��B�e����
 */
function takepicture() {
  let context = canvas.getContext('2d')
  if (width && height) {
    canvas.width = width
    canvas.height = height
    context.drawImage(video, 0, 0, width, height)
  } else {
    clearphoto()
  }
}

startup()

</script>
</body>




