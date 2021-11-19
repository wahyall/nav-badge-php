<?php
if (!isset($_GET['text']) || !isset($_GET['type'])) {
  exit;
}

$text = $_GET['text'];
$type = $_GET['type'];

if (file_exists("public/img/$text-$type.png")) {
  $badge = 'public/img/' . $text . '-' . $type . '.png';
  $fp = fopen($badge, 'rb');

  // send the right headers
  header("Content-Type: image/png");
  header("Content-Length: " . filesize($badge));

  // dump the picture and stop the script
  fpassthru($fp);
  exit;
}

if ($type === 'prev') {
  echo '
    <div class="nav-button" style="box-sizing: border-box; background-color: #555555; display: inline-flex;">
      <div class="icon" style="box-sizing: border-box; background-color: #44cc11; display: flex; align-items: center; justify-content: center; padding: 0.375rem 0.75rem;">
        <img src="public/img/arrow.png" style="box-sizing: border-box; transform: rotateY(180deg); width: 16px;" />
      </div>
      <span class="text" style="box-sizing: border-box; font-family: ' . 'Poppins' . ', sans-serif; padding: 0.375rem 0.75rem; color: #ffffff; min-width: 37px; min-height: 37px; letter-spacing: 1px; font-weight: 300;">' . $text . '</span>
    </div>
  ';
} else {
  echo '
    <div class="nav-button" style="box-sizing: border-box; background-color: #555555; display: inline-flex;">
      <span class="text" style="box-sizing: border-box; font-family: ' . 'Poppins' . ', sans-serif; padding: 0.375rem 0.75rem; color: #ffffff; min-width: 37px; min-height: 37px; letter-spacing: 1px; font-weight: 300;">' . $text . '</span>
      <div class="icon" style="box-sizing: border-box; background-color: #44cc11; display: flex; align-items: center; justify-content: center; padding: 0.375rem 0.75rem;">
        <img src="public/img/arrow.png" style="box-sizing: border-box; width: 16px;" />
      </div>
    </div>
  ';
}

echo '
<script src="public/js/dom-to-image.min.js"></script>
<script>
  window.onload = () => {
    domtoimage.toBlob(document.querySelector(".nav-button"))
    .then(function(blob) {
      const formData = new FormData();
      formData.append("badge", blob);
      formData.append("name", "' . $text . '");
      formData.append("type", "' . $type . '");
      fetch("upload.php", {
          method: "POST",
          body: formData
        })
    });
  }
</script>
';

// header("Location: ./?text=$text&type=$type", true, 301);
// exit();
