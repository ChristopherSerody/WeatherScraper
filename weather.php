<?php
    
    $weather="";
    
    $error = "";
    
    if (array_key_exists('city', $_POST)) {
        
        $city = $_POST["city"];
    
        $city = str_replace(' ','',$city);
        
        $file_headers = @get_headers("https://www.weather-forecast.com/locations/$city/forecasts/latest");
        
        if ($file_headers[0] == 'HTTP/1.1 404 Not Found') {
            
            $error = "That city could not be found.";
            
        } else {
            
            $url = "https://www.weather-forecast.com/locations/$city/forecasts/latest";
        
            $regex = '#<p class="summary">(.*?)</p>#';
        
            $content = file_get_contents($url);
            
            preg_match($regex, $content, $matches);
            
            if (sizeof($matches) > 1) {
                $weather.= $matches[0];
            } else {
                $error = "That city could not be found.";
            }
        }
    }
?>

<html>

    <head>
    
        <title>Weather Scraper</title>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
    
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">    
    
        <script type="text/javascript" src="jquery-3.2.1.min.js"></script>
        
        <style>
            
            body {
                background:url("weatherbackground.jpg");
                background-size:100%;
                text-align:center;
            }
            
            #content {
                text-align:center;
                margin-top:50px;
                width:450px;
                margin:50px auto;
            }
            
            h1 {
                font-weight:bold;
            }
            
            p {
                font-size:120%;
            }
            
            input {
                width:200px;
            }
            
            #submitbutton {
                width:100px;
                margin-top:15px;
            }
            
            #message {
                margin-top:40px;
            }
            
        </style>
    
    </head>
    
    <body>
        
        <div id="content">
        
            <h1>What's The Weather?</h1>
            
            <p>Enter the name of a city.</p>
            
            <div class="container">
                <form method="post">
                  <fieldset class="form-group">
                    <input type="text" class="form-control" name="city" id="city" placeholder="Eg. London, Tokyo" value = "<?php 
                    
                    if (array_key_exists('city', $_POST)) {
                        
                        echo $_POST['city']; 
                        
                    }
                        
                    ?>">
                        
                  </fieldset>
                  <button type="submit" id="submitbutton" class="btn btn-primary">Submit</button>
                </form>
                
                <div id="weather"><?php
                
                if ($weather) {
                
                    echo '<div class="alert alert-success" role="alert">
                    '.$weather.'</div>';
                
                } else if ($error) {
                        
                    echo '<div class="alert alert-danger" role="alert">
                    '.$error.'</div>';
                    
                }
                                    
                ?></div>
                
            </div>

        </div>
        
        <script type="text/javascript">
            
            
            
        </script>
    
    </body>
    
</html>
