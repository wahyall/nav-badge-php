<?php
$name = $_POST['name'];
$type = $_POST['type'];
move_uploaded_file(
  $_FILES['badge']['tmp_name'],
  "public/img/$name-$type.png"
);
