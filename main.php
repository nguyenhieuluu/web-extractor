<html>
   <head>
   </head>

    <style>
        body {
            background: #F2DFD7;
            font-size: 20px;
            text-align: center;
        }
        
        .button, .selection {
            width: 500px;
            background-color: #000000;
            color: white;
            border: none;
            padding: 15px;
            text-align: center;
            display: inline-block;
            margin: 10px;
            font-weight: 600;
        }

        .selection {
            background-color: #D4C1EC;
            color: #000000;
        }

        .mycss {
            background: #ffc8b3;
            padding: 25px;
            width: 50%;
            margin: auto;
            text-align: left;
            display: block;
        }

        .resize {
            color: #736CED;
        }

        .resize img {
            max-width: 600px;
            
        }
    </style>

   <body>
        <?php
            function displayForm(){
                // form is referenced from lecture note
                echo "<h1> Enter Your URL </h1>";
                echo "<form action='main.php' method='GET' class='form'>";
                echo "<textarea cols=60 rows=10 name='formdata'>";
                echo "</textarea>";
                echo "<br>";
            
                echo "<select name='options' class='selection'>";
                echo "<option>";
                echo "Metadata Extraction";
                echo "</option>";
                echo "<option>";
                echo "Count Frequency";
                echo "</option>";
                echo "<option>";
                echo "Image Extraction and Resizing";
                echo "</option>";
                echo "</select>";

                echo "<br>";
                echo "<input class='button' type=submit>";
                echo "</form>";
            }

            function validWebContent($content) {
                if (empty($content)) { 
                    echo "Invalid or empty content"; 
                    return false;
                }
                return true;
            }

            function extract_metadata($content) {
                $htmlchar = array();
                $htmlchar[0] = '&lt;';
                $htmlchar[1] = '&gt;';

                $escletter = array();
                $escletter[0] = '/</';
                $escletter[1] = '/>/';
                $output = preg_replace($escletter, $htmlchar, $content);
                echo $output;
            }

            function countFrequency($content) {
                // regex was tested using http://www.roblocher.com/technotes/regexp.html
                echo "<div class='mycss'>";  
                preg_match_all('/<([^\/!][a-z1-9]*)/i', $content, $matches);
                echo $matches[1];
                print_r(array_count_values($matches[1]));
                echo "</div>";
            }



            // start Form Interaction
            echo "<pre>";
            displayForm(); 
            $url = $_GET["formdata"];
            $content = file_get_contents($url);
            $option = $_GET["options"];    

            if (validWebContent($content)) {
                if (strcmp($option, "Metadata Extraction") == 0) {
                    extract_metadata($content);
                }
                //https://www.quora.com/Is-it-possible-to-extract-images-and-videos-from-websites-using-PHP
                else if (strcmp($option, "Image Extraction and Resizing") == 0) {
                    $doc = new DOMDocument();
                    @$doc->loadHTML($content);
                    $tags = $doc->getElementsByTagName('img');
                    echo "<p> These are original images at orginal sizes </p>";
                    foreach ($tags as $tag) {
                        $link = $tag->getAttribute('src');
                        echo "<img src='".$link."'>";
                        echo "\n";
                    }
                    echo "<div class='resize'>";
                    echo "<p> The original images have been resized to max-width of 600px </p>";
                    foreach ($tags as $tag) {
                        $link = $tag->getAttribute('src');
                        echo "<img src='".$link."'>";
                        echo "\n";
                    }
                    echo "</div>";
                }
                else if (strcmp($option, "Count Frequency") == 0) {
                    countFrequency($content);
                }
            }
            
            
        

        ?>
        
           
        
        

         

    </body>
</html>
