<html>

    <body style = "margin: 0;">

        <div>
            <p onclick = "toggleContainer('saliencesContainer', -1);" style = "display: inline-block;">Toggle Saliences</p>
        </div>
        
        <?PHP

            /////MAIN VARIABLES
            echo "<script>let animationFPS = 100;</script>";
            echo "<script>let textExtrusion = 20;</script>";

            $imagePath = 'Images/CircleCenter.png';

            $cx = 900; $cy = 400;//offset of whole circle
            echo "<script>let cx = {$cx}; let cy = {$cy};</script>";
            $wholeRadius = 300;//radius boundary

            $salienceCount = 3;
            $salienceOpacity = 1;
            $salienceStroke = 0;
            $salienceColors = array(
                "#eaeaea", "#e0e0e0", "#d1d1d1"
            );
            $salienceMin = 0.55; $salienceMax = 1;

            $factorCount = 5;
            $factorOpacity = 1;
            $factorStroke = 0;
            $factorColors = array(
                "#4000FF", "#FF5500", "#FFE600", "#34EBA4", "#FF0061"
            );
            $factorMin = 0.55; $factorMax = 1;
            $factorTime = 0.3;
            // $factorNames = array(
            //     "Openness", "Conscientiousness", "Extraversion", "Agreeableness", "Neuroticism"
            // );
            $factorRadii = array();//setup later

            $faucetCount = 30;//must be divisible by factorCount
            $faucetOpacity = 1;
            $faucetStroke = 0;
            $faucetColors = array(
                "#7a00ff", "#0079ff", "#000d1c", "#aaa9ff", "#00d2ff", "#5100ff",//o
                "#ff6200", "#ff4300", "#ff9600", "#ff2900", "#1c0c00", "#ffbca9",//c
                "#fff800", "#ffbf00", "#ffee00", "#a9aa9a", "#fff300", "#ffefa9",//e
                "#00ffac", "#00ff11", "#9fff00", "#a9ffc5", "#585e5a", "#00ff5f",//a
                "#ff008c", "#d8d3d6", "#ff00ba", "#ff0000", "#ffa9c0", "#ff0062",//n
            );
            $faucetNames = array(
                "Fantasy", "Aesthetics", "Feelings", "Actions", "Ideas", "Values",//o
                "Competence", "Order", "Dutifulness", "Achievement Striving", "Self-Discipline", "Deliberation",//c
                "Warmth", "Gregariousness", "Assertiveness", "Activity", "Excitement Seeking", "Positive Emotions",//e
                "Trust", "Straightforwardness", "Altruism", "Compliance", "Modesty", "Tender-Mindedness",//a
                "Anxiety", "Hostility", "Depression", "Self-Consciousness", "Impulsiveness", "Vulnerability"//n
            );
            $faucetMin = $factorMin; $faucetMax = $factorMax;
            $faucetTime = 0.1;//in seconds
            $faucetRadii = array();//setup later


            //ADDITIONAL SETUP
            $angle = 0;//rotation of the ellipse relative to x axis
            echo "<script>let angle = {$angle};</script>";
            $largeArcFlag = 0;//1 => large arc, 0 => small arc
            echo "<script>let largeArcFlag = {$largeArcFlag};</script>";
            $sweepFlag = 1;//0 => ccwise, 1 => cwise
            echo "<script>let sweepFlag = {$sweepFlag};</script>";

            echo "<script>let locks = [];</script>";

            //setup faucetRadii
            for ($i = 0; $i < $faucetCount; $i++) {
                $numLevels = 3;
                $randNum = rand(0, $numLevels - 1);
                $percent = (($randNum)/($numLevels-1));
                array_push($faucetRadii, $faucetMin + ($faucetMax - $faucetMin)*$percent);
            }
            
            //setup factorRadii
            $faucetsInFactor = $faucetCount / $factorCount;
            for ($i = 0; $i < $factorCount; $i++) {
                $relevantFaucets = array();
                for ($j = 0; $j < $faucetsInFactor; $j++) {
                    array_push($relevantFaucets, $faucetRadii[$i*$faucetsInFactor + $j]);
                }
                array_push($factorRadii, array_sum($relevantFaucets) / count($relevantFaucets));
            }


            /////MAIN FUNCTIONS
            function f($x, $r, $restriction) {//circle function
                return sqrt($r*$r - $x*$x) * (pi()/2 < $restriction && $restriction <= 3*pi()/2 ? -1 : 1);
            }

            function createArcs($radii, $count, $colors, $opacity, $stroke, $isFactor) {

                global $wholeRadius, $cx, $cy, $angle, $largeArcFlag, $sweepFlag, $faucetsInFactor, $faucetTime, $faucetNames, $imagePath;

                for ($i = 0; $i < $count; $i++) {
                
                    /////////////////////////////////////set up math
                    $r = $wholeRadius * $radii[$i%count($radii)];//arc radius
                    $intervalSize = 2*pi()/$count;//arc length
                    $a = $intervalSize * $i;//[0, 2pi] //arc start point
                    $x1 = sin($a)*$r;//[-pi/2, pi/2]
                    $b = $intervalSize * ($i + 1);//[0, 2pi] //arc end point
                    $x2 = sin($b)*$r;//[-pi/2, pi/2]
                    $y1 = 2*pi() - f($x1, $r, $a);//[-pi/2, pi/2] //(must invert y relative to the circle's diameter because svg has an inverted y axis)//////////TODO: fix
                    $y2 = 2*pi() - f($x2, $r, $b);//[-pi/2, pi/2]
                    $arcStartX = $x1 + $cx; $arcStartY = $y1 + $cy;//start point from which to draw eclipse
                    $arcEndX = $x2 + $cx; $arcEndY = $y2 + $cy;//new point for next command

                    /////////////////////////////////////render semicircle/texts

                    $factorCondition = $isFactor;
                    $faucetConditionStart = (!$isFactor && $i % $faucetsInFactor == 0);
                    $faucetConditionEnd = (!$isFactor && $i % $faucetsInFactor == $faucetsInFactor - 1);
                    $idKey = $isFactor ? $i : floor($i / $faucetsInFactor);//faucet is 0-5 => 0, 6-11 => 1, etc

                    if ($factorCondition) {
                        echo '<svg width = "100%" height = "100%" style = "position: absolute; display: block; pointer-events: none; opacity: 1;" id = "factorsContainer'.$i.'">';
                        echo '<script>thisContainer = document.getElementById("factorsContainer'.$i.'");</script>';
                    } else if ($faucetConditionStart) {
                        echo '<svg width = "100%" height = "100%" style = "position: absolute; display: block; pointer-events: none;" class = "_faucetsContainer'.$idKey.'">';
                        echo '<script>thisContainer = document.getElementsByClassName("_faucetsContainer'.$idKey.'")['.$i%$faucetsInFactor.'];</script>';
                    }
                    
                    $color = $colors[$i%count($colors)];

                    echo "
                        <path d = '
                                M {$arcStartX}, {$arcStartY}
                                A {$r}, {$r} {$angle}, {$largeArcFlag}, {$sweepFlag} {$arcEndX}, {$arcEndY}
                                L {$cx}, {$cy}
                                L {$arcStartX}, {$arcStartY}
                        ' fill = '{$color}' fill-opacity = '{$opacity}' stroke = '#000' stroke-width = '{$stroke}'
                        ".($isFactor ? 'style = \'cursor: pointer; pointer-events: all;\' id = \'factorArc'.$idKey.'\' onclick = \'locks['.$idKey.'] = !locks['.$idKey.'];\' onmouseenter = \'slideArcs(true, '.$faucetTime.', '.$idKey.'); fadeElement("factorArc'.$idKey.'", '.$idKey.', true, 0.3)\' onmouseleave = \'slideArcs(false, '.$faucetTime.', '.$idKey.'); fadeElement("factorArc'.$idKey.'", '.$idKey.', false, 0.3)\'' : 'class = \'_faucets'.$idKey.'\'')." />";
                    
                    echo $isFactor ? '<script>thisArc = document.getElementById("factorArc'.$idKey.'");</script>' : '<script>thisArc = document.getElementsByClassName("_faucets'.$idKey.'")['.$i%$faucetsInFactor.'];</script>';
                    echo '<script>function heyy(c, a) { setTimeout(function() { c.prepend(a); }, 1); } heyy(thisContainer, thisArc); </script>';

                    if (!$isFactor) {
                        $text = strtolower($faucetNames[$i%count($faucetNames)]);
                        echo "<text x = '0' y = '0' opacity = '1' font-family = 'verdana' text-anchor = '".($i < $count/2 || $i == 15 || $i == 16 || $i == 17 ? 'start' : 'end')."' fill = '".$color."' stroke = '#000' stroke-width = '0.015vw' class = '_faucetText".$idKey."'>{$text}</text>";
                    }
                    // } else {
                    //     $text = strtoupper($factorNames[$i%count($factorNames)]);
                    //     echo "<text font-family = 'verdana' font-weight = 'bold' stroke = '#000' stroke-width = '0.05vw' x = '".($arcStartX+$arcEndX+$cx)/3 ."' y = '".($arcStartY+$arcEndY+$cy)/3 ."' opacity = '1' text-anchor = 'middle' fill = '#FFF'>{$text}</text>";
                    // }

                    if ($factorCondition || $faucetConditionEnd) {
                        echo '</svg>';
                    }

                    echo '<img src="' . $imagePath . '" alt="Image" style="position: absolute; top: '.$cy.'px; left: '.$cx.'px; transform: translate(-50%, -50%);">';
                
                }

            }


            //MAIN BODY (ordered in back to front layer)

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //SALIENCES
            echo '<svg width = "100%" height = "100%" style = "position: absolute; display: block; pointer-events: none;" id = "saliencesContainer0">';
            for ($i = 0; $i < $salienceCount; $i++) {
                echo "<circle
                    cx = '{$cx}' cy = '{$cy}'
                    r = '".((($salienceMax - $salienceMin)*(($salienceCount-$i)/$salienceCount))+$salienceMin)*$wholeRadius."'
                    fill = '{$salienceColors[$i%count($salienceColors)]}' fill-opacity = '{$salienceOpacity}'
                    stroke = '#000' stroke-width = '{$salienceStroke}' />";
            }
            echo '</svg>';
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //FAUCETS
            createArcs($faucetRadii, $faucetCount, $faucetColors, $faucetOpacity, $faucetStroke, false);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //FACTORS
            createArcs($factorRadii, $factorCount, $factorColors, $factorOpacity, $factorStroke, true);
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        ?>

    </body>

    <script>

        function toggleContainer(containerName, idx) {//-1 idx => All
            let i = 0;
            let isToggled = null;
            while (true) {
                let thisDiv = document.getElementById(containerName + i);
                if (thisDiv == null) {
                    break;
                }

                if (idx == -1 || i == idx) {
                    if (isToggled == null) isToggled = thisDiv.style.display == "block";
                    thisDiv.style.display = isToggled ? "none" : "block";
                }

                i++;
            }
        }

        let thisInterval = 0;
        let ivs = [];
        let ivs2 = [];
        let thisIntervals = [];
        let thisIntervals2 = [];

        let currentFaucetTransforms = [];
        let i = 0;
        while (true) {
            let theseArcs = document.getElementsByClassName("_faucets" + i);
            let theseTexts = document.getElementsByClassName("_faucetText" + i);
            if (theseArcs.length == 0) {
                break;
            }

            currentFaucetTransforms[i] = [];
            
            let regexpM = /\bM.([0-9.]+)\b,\s([0-9.]+)/m;
            let regexpA = /\bA.(\d+)/m;
            let regexpA2 = /\bA.([0-9.]+)\b,\s([0-9.]+)\s([0-9.]+)\b,\s([0-9.]+)\b,\s([0-9.]+)\s([0-9.]+)\b,\s([0-9.]+)/m;

            j = 0;
            
            for (arc of theseArcs) {
                let d = arc.getAttribute("d");
                let as = regexpM.exec(d);
                let asx = as[1];
                let asy = as[2];
                let ae = regexpA2.exec(d);
                let aex = ae[6];
                let aey = ae[7];
                let rr = regexpA.exec(arc.getAttribute("d"))[1];
                
                currentFaucetTransforms[i].push({
                    element: arc,
                    text: theseTexts[j],
                    arcStartX: asx,
                    arcStartY: asy,
                    arcEndX: aex,
                    arcEndY: aey,
                    r: rr
                });

                slideArcs(false, 0, i);

                j++;
            }

            i++;
        }

        function slideArcs(outNotIn, seconds, idKey) {

            let intervals = animationFPS * seconds;
            
            while (thisIntervals.length <= idKey) thisIntervals[thisIntervals.length] = outNotIn ? intervals : 0;

            let unitInterval = thisIntervals[idKey] / intervals;
            
            if (locks[idKey] == undefined) locks[idKey] = false;
            
            if (ivs.length <= idKey) ivs[idKey] = undefined;
            else if (locks[idKey] == false)
            {
                clearInterval(ivs[idKey]);

                ivs[idKey] = setInterval(() => {

                    thisIntervals[idKey] += outNotIn ? 1 : -1;
                    unitInterval = intervals == 0 ? 0 : (thisIntervals[idKey] / intervals > 0 ? Math.sqrt(thisIntervals[idKey] / intervals) : 0);
                    let prevP = {x: 0, y: 0};

                    for (let j = 0; j < currentFaucetTransforms[idKey].length; j++) {
                        
                        let faucet = currentFaucetTransforms[idKey][j];

                        let arcStartX = cx + (faucet.arcStartX - cx)*unitInterval; let arcStartY = cy + (faucet.arcStartY - cy)*unitInterval;
                        let arcEndX = cx + (faucet.arcEndX - cx)*unitInterval; let arcEndY = cy + (faucet.arcEndY - cy)*unitInterval;
                        let r = faucet.r * unitInterval;
                        
                        faucet.element.setAttribute("d", `
                                M ${arcStartX}, ${arcStartY}
                                A ${r}, ${r} ${angle}, ${largeArcFlag}, ${sweepFlag} ${arcEndX}, ${arcEndY}
                                L ${cx}, ${cy}
                                L ${arcStartX}, ${arcStartY}
                            `
                        );

                        faucet.text.setAttribute("opacity", unitInterval);

                        //see Desmos extrusion model for text:
                        let i = 999999;
                        let t = textExtrusion;
                        let A = {x: arcStartX, y: arcStartY};
                        let B = {x: arcEndX, y: arcEndY};
                        let C = {x: cx, y: cy};

                        function f(x) {
                            let v = B.x-A.x == 0 ? i*x - i*B.x : ((B.y-A.y)/(B.x-A.x))*(x-A.x);
                            return v + A.y;
                        }

                        function g(x) {
                            let v = B.y-A.y == 0 ? i*x - (B.x + (A.x-B.x)/2)*i : -1*((B.x-A.x)/(B.y-A.y))*(x - ((B.x-A.x)/2 + A.x));
                            return v + (B.y-A.y)/2 + A.y;
                        }

                        function h(x) {
                            let v = C.y < f(C.x) ? t : -t;
                            let v2 = B.x-A.x == 0 ? i : Math.sqrt(1 + Math.pow(f(1)-f(0), 2));
                            return v*v2 + f(x);
                        }

                        let bg = g(0);
                        let bh = h(0);
                        let mg = g(1) - bg;
                        let mh = h(1) - bh;

                        let P = mh-mg == 0 ? {x: A.x, y: A.y} : {x: (bg-bh)/(mh-mg), y: (mh*bg - mg*bh)/(mh-mg)};
                        let proximityYOffset = (Math.abs(prevP.y - P.y) <= 15) ? 20 : 0;
                        P.y += proximityYOffset;
                        prevP = P;
                        
                        faucet.text.setAttribute("x", P.x);
                        faucet.text.setAttribute("y", P.y);

                    }

                    if (thisIntervals[idKey] < 0 || intervals < thisIntervals[idKey]) {
                        clearInterval(ivs[idKey]);
                    }
                    
                }, seconds*1000 / intervals);
            }
        }

        function fadeElement(id, idKey, outNotIn, seconds) {
            
            let intervals = animationFPS * seconds;
            while (thisIntervals2.length <= idKey) thisIntervals2[thisIntervals2.length] = outNotIn ? intervals : 0;
            let unitInterval = thisIntervals2[idKey] / intervals;

            if (ivs2.length <= idKey) ivs2[idKey] = undefined;

            if (locks[idKey] == undefined) locks[idKey] = false;
            
            if ((!outNotIn && locks[idKey] == false) || (outNotIn && thisIntervals2[idKey] != -1))
            {
                clearInterval(ivs2[idKey]);

                ivs2[idKey] = setInterval(() => {

                    thisIntervals2[idKey] += outNotIn ? -1 : 1;
                    unitInterval = thisIntervals2[idKey] / intervals;

                    let element = document.getElementById(id);
                    element.style.opacity = unitInterval;

                    if (thisIntervals2[idKey] < 0 || intervals < thisIntervals2[idKey]) {
                        clearInterval(ivs2[idKey]);
                    }

                }, seconds*1000 / intervals);
            }

        }

        toggleContainer('saliencesContainer', -1);

    </script>

</html>
