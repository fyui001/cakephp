<?php
$photo_n = count($photo);
for ($i=0; $i < $photo_n; $i++) {
 echo "<img src='{$photo[$i]}'>";
}
