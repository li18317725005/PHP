<?php
		ob_start();
        include "leapsoulcn.html";
        $contents = ob_get_contents();
        ob_end_clean();
        echo $contents;