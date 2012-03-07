<?php Configure::write('debug', 0); ?>
<?php
foreach ($themes as $k => $v):
    echo "<option value=\"" . $k . "\">$v</option>\n";
endforeach;