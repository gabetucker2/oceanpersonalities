<!DOCTYPE html>
<html>
  <body style="margin: 0;">
    <svg width="100%" height="100%" style="position: absolute; display: block; pointer-events: none;">
      <?php

        // main vars
        $factorNames = array("Openness", "Conscientiousness", "Extraversion", "Agreeableness", "Neuroticism");
        $factorColors = array("#4000FF", "#FF5500", "#FFE600", "#34EBA4", "#FF0061");
        $factorCount = count($factorNames);

        $eyeX = 650;
        $eyeY = 650;

        // upper padding
        $eyeYTrans = -24;
        $eyeVertRadius = 195;
        $eyeHorizRadius = 460;
        echo '<path d="M' . ($eyeX-$eyeHorizRadius) . ',' . ($eyeY+$eyeYTrans) . ' q' . ($eyeHorizRadius) . ',' . (-$eyeVertRadius) . ' ' . ($eyeHorizRadius * 2) . ',0 q' . (-$eyeHorizRadius) . ',' . ($eyeVertRadius) . ' ' . (-$eyeHorizRadius * 2) . ',0" fill="#000"></path>';

        // main eyedrop
        $eyeVertRadius = 150;
        $eyeHorizRadius = 400;
        echo '<path d="M' . ($eyeX-$eyeHorizRadius) . ',' . $eyeY . ' q' . $eyeHorizRadius . ',' . (-$eyeVertRadius) . ' ' . ($eyeHorizRadius * 2) . ',0 q' . (-$eyeHorizRadius) . ',' . $eyeVertRadius . ' ' . (-$eyeHorizRadius * 2) . ',0" fill="#4000FF"></path>';

        // text on top
        echo '<text font-family="verdana" font-weight="bold" font-size="40" x="' . ($eyeX-$eyeHorizRadius) + $eyeHorizRadius . '" y="' . $eyeY . '" text-anchor="middle" alignment-baseline="middle" fill="#FFFFFF">Openness</text>';

        // line below
        $lineRadius = 400;
        $lineY = $eyeY + 150;
        echo '<line x1="' . ($eyeX-$lineRadius) . '" y1="' . $lineY . '" x2="' . ($eyeX+$lineRadius) . '" y2="' . $lineY . '" stroke="black" stroke-width="5" />';

        // line arrow
        $imagePath = "Images/Arrow.png";
        $arrowXOffset = -300;
        $arrowYOffset = 5;
        $arrowWidth = 35;
        echo '<img src="' . $imagePath . '" alt="Image" style="pointer-events: none; position: absolute; left: '.($eyeX+$arrowXOffset).'px; top: '. ($lineY+$arrowYOffset) .'px; width: '.$arrowWidth.'px; height: auto; transform: translate(-50%, -50%);">';

        // buttons
        $textYOffset = 50;
        $textXOffsets = 100;
        for ($f = 0; $f < $factorCount; $f++) {
          $xTrans = ($f-2)*$textXOffsets;
          echo '<text style="cursor: pointer; position: absolute;" font-family="verdana" font-weight="bold" font-size="40" x=' . ($eyeX+$xTrans+$eyeHorizRadius) . ' y=' . ($lineY+$textYOffset) . ' text-anchor="middle" alignment-baseline="middle" fill="#FFFFFF">'.$factorNames[$f].'</text>';
        }

      ?>
    </svg>

  </body>
</html>
