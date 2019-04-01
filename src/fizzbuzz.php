<?php

for ($i = 1; $i <= 100; $i++) {
    if ($i % 15 == 0 ) {
        echo ' FuzzBuzz ';
    }  elseif ($i % 5 == 0) {
        echo ' Buzz ';
    }  elseif ($i % 3 == 0) {
        echo ' Fuzz ';
    }  else {
        echo  ' ' . $i . ' ';
    }
}
