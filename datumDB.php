<?php	
        function success($anz, $d500, $d2500)
        {
            return "<!DOCTYPE html>
            <html lang=\"de\">
            <title>Datenbank</title>
                    <head>
                        <meta charset=\"utf-8\">
                        <style>
                        body
                        {
                            background-color: rgb(220, 203, 247);
                        }
                        .success 
                        {                
                            font-size:12px;
                            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                        }
                        .title
                        {
                            background-color: lightgrey;
                            font-size: 15px; 
                            font-weight: bold;
                        }
                        .tablebody
                        {
                            background-color: white;
                        }
                        #year
                        {
                            background-color: white;
                            font-weight: bold;
                        }
                        </style>
                    </head>     
                    <body> 
                        <form>           
                            <div class=\"success\">Es wurde an $anz Stunden geprüft</div>
                            <div class=\"success\">Die durschittlichen prozentualen Abweichungen betragen</div>
                            <div class=\"success\">für einen Prüfdruck von 500hPa bar: $d500 %</div>
                            <div class=\"success\">für einen Prüfdruck von 2500hPa bar: $d2500 %</div>
                        </form>
                    </body>
            </html>";
        }
        
        function error($str)
        {
            return "<!DOCTYPE html>
            <html lang=\"de\">
            <title>Datenbank</title>
                    <head>
                        <meta charset=\"utf-8\">
                        <style>
                        body
                        {
                            background-color: lightgrey;
                        }
                        #errorText
                        {                
                            font-size:12;
                            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                            color: red;
                        }
                        #back
                        {
                            font-size: 12px;                     
                            font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
                        } 
                        </style>
                    </head>     
                    <body> 
                        <form>    
                            <p id = \"errorText\">$str</p>       
                            <p>
                                <a id=\"back\" href=\"index.html\">Zurück</a> 
                            </p>
                        </form>
                    </body>
            </html>";
        }

        $db = mysqli_connect("localhost", "root", "", "it31_goralewski");

        if (mysqli_connect_errno())
        {
            printf("Verbindung fehlgeschlagen: " . mysqli_connect_error());
            exit();
        }

        $jahr = mysqli_real_escape_string($db, $_POST['jahr']);
        $monat = mysqli_real_escape_string($db, $_POST['monat']);
        $tag = mysqli_real_escape_string($db, $_POST['tag']);
        
        $query = "SELECT year, month, day FROM data WHERE year = '$jahr' and month = '$monat' and day='$tag'";
        $res = mysqli_query($db, $query);

        $anz = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(Year) as anz_ FROM data WHERE Year = '$jahr' AND Month = '$monat' AND Day = '$tag'"));     

        $diff500= 0;
        $diff2500 = 0;

        if($anz['anz_'] == 0) 
        {
            printf(error("Keine Werte gefunden"));
            mysqli_close($db);
            exit();
        }
        else
        {           
            echo(success($anz['anz_'], $diff500, $diff2500));        
            
            $result = mysqli_query($db, "SELECT * FROM data WHERE day = '$tag'");

            if(mysqli_num_rows($result)) 
            {
                echo"
                <table border='1'>
                    <tr>
                        <td class=\"title\">Year&nbsp;&nbsp;</td>
                        <td class=\"title\">Mopnth&nbsp;&nbsp;</td>
                        <td class=\"title\">Day&nbsp;&nbsp;</td>
                        <td class=\"title\">Hour&nbsp;&nbsp;</td>
                        <td class=\"title\">Diff.500[hPa]&nbsp;&nbsp;</td>
                        <td class=\"title\">Diff.2500[hPa]&nbsp;&nbsp;</td>
                    </tr>";

                while($row = mysqli_fetch_array($result)) 
                { 
                    echo"<p></p>
                        <tr>
                            <td id=\"year\">{$row['Year']}</td>
                            <td class=\"tablebody\">{$row['Month']}</td>
                            <td class=\"tablebody\">{$row['Day']}</td>
                            <td class=\"tablebody\">{$row['Hour']}</td> 
                            <td class=\"tablebody\">{$row['D500']}</td> 
                            <td class=\"tablebody\">{$row['D2500']}</td>  
                        </tr>
                    ";
                }
            } 
        }   
?>