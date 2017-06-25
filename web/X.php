<?php

exec("php ../bin/console debug:router", $output, $return_var);

echo "Result: $return_var<br><br>output:<br>";
echo implode("<br>", $output);

