<?php
<<<<<<< HEAD

echo $photo[0];
$photo_n = count($photo);
echo $photo_n;
for ($i=0; $i < $photo_n; $i++) {
 echo "<img src='{$photo[$i]}'>";

=======
$photo_n = count($photo);
for ($i=0; $i < $photo_n; $i++) {
 echo "<img src='{$photo[$i]}'>";

>>>>>>> ff7457adbd3ed724cc6dfd6c1309efa8a5075abb
}
