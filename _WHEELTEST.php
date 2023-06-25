<!DOCTYPE html>
<html>
  <body style="margin: 0;">
    <svg width="100%" height="100%" style="position: absolute; display: block; pointer-events: none;">
      <?php

        $eyeX = 600;
        $eyeY = 700;

        // upper padding
        $eyeYTrans = -23;
        $eyeVertRadius = 195;
        $eyeHorizRadius = 460;
        echo '<path d="M' . ($eyeX-$eyeHorizRadius) . ',' . ($eyeY+$eyeYTrans) . ' q' . ($eyeHorizRadius) . ',' . (-$eyeVertRadius) . ' ' . ($eyeHorizRadius * 2) . ',0 q' . (-$eyeHorizRadius) . ',' . ($eyeVertRadius) . ' ' . (-$eyeHorizRadius * 2) . ',0" fill="#000"></path>';

        // main eyedrop
        $eyeVertRadius = 150;
        $eyeHorizRadius = 400;
        echo '<path d="M' . ($eyeX-$eyeHorizRadius) . ',' . $eyeY . ' q' . $eyeHorizRadius . ',' . (-$eyeVertRadius) . ' ' . ($eyeHorizRadius * 2) . ',0 q' . (-$eyeHorizRadius) . ',' . $eyeVertRadius . ' ' . (-$eyeHorizRadius * 2) . ',0" fill="#4000FF"></path>';

        // text on top
        echo '<text font-family="verdana" font-weight="bold" font-size="40" x="' . ($eyeX-$eyeHorizRadius) + $eyeHorizRadius . '" y="' . $eyeY . '" text-anchor="middle" alignment-baseline="middle" fill="#FFFFFF">Openness</text>'

      ?>
    </svg>
  </body>
</html>
