<?php

echo $photo[0];
$photo_n = count($photo);
echo $photo_n;
for ($i=0; $i < $photo_n; $i++) {
 echo "<img src='{$photo[$i]}'>";

}
