<!DOCTYPE html>
<html>
<head>
  <title>Horizontal Eye Shape</title>
  <style>
    svg {
      background-color: #f0f0f0;
    }
  </style>
</head>
<body>
  <?php
  // Define the SVG dimensions
  $width = 300;
  $height = 150;
  ?>
  <svg width="<?php echo $width; ?>" height="<?php echo $height; ?>">
    <circle cx="<?php echo $width / 2; ?>" cy="<?php echo $height / 2; ?>" r="50" fill="#fff" stroke="#000" stroke-width="2" />
    <script>
      // JavaScript code to draw the eye shape
      var svg = document.querySelector('svg');
      var eyeWidth = <?php echo $width / 2; ?>;
      var eyeHeight = <?php echo $height / 2; ?>;

      var eye = document.createElementNS("http://www.w3.org/2000/svg", "path");
      eye.setAttribute("d", "M" + (eyeWidth - 40) + "," + eyeHeight + " q40,-40 80,0 q-40,40 -80,0");
      eye.setAttribute("fill", "transparent");
      eye.setAttribute("stroke", "#000");
      eye.setAttribute("stroke-width", "2");
      svg.appendChild(eye);
    </script>
  </svg>
</body>
</html>
