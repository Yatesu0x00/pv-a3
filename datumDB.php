<?php	
        $db = mysqli_connect("localhost", "root", "", "it31_goralewski");

        if (mysqli_connect_errno())
        {
            printf("Verbindung fehlgeschlagen: " . mysqli_connect_error());
            exit();
        }

        $jahr = mysqli_real_escape_string($db, $_POST['jahr']);
        $monat = mysqli_real_escape_string($db, $_POST['monat']);
        $tag = mysqli_real_escape_string($db, $_POST['tag']);

        if ($_POST['usecase'] == "datum")
        {
            $query = "SELECT year, month, day FROM data WHERE year = '$jahr' and month = '$monat' and day='$tag'";
            $res = mysqli_query($db, $query);
            
            echo"
            <table>
                    <tr>
                    <p></p>
                    <div>Es wurde an {$std['']} Stunden geprüft</div>
                    <p></p
                    <div>Die durchschnittlichen prozentualen Abweichungen betragen</div>
                    <div>für einen Prüfstück von 500 hPa bar: {$hpa500['']} %</div>
                    <div>für einen Prüfstück von 2500 hPa bar: {$hpa2500['']} %</div>
                    </tr>
            </table>";

                $result = mysqli_query($db, "SELECT year, month, day FROM data ORDER BY day ASC"); 

                if(mysqli_num_rows($result)) 
                {   
                    echo"   
                    <body style=\"background-color: rgb(220, 203, 247);\">               
                    <table border='1' style=\"background-color: white\">
                    <tr style=\"background-color: darkgray;\">
                        <td><div style=\"font-family: arial; font-weight: bold\">Jahr&nbsp;&nbsp;</div></td>
                        <td><div style=\"font-family: arial; font-weight: bold\">Monat&nbsp;&nbsp;</div></td>
                        <td><div style=\"font-family: arial; font-weight: bold\">Tag&nbsp;&nbsp;</div></td>
                        <td><div style=\"font-family: arial; font-weight: bold\">Stunde&nbsp;&nbsp;</div></td>
                        <td><div style=\"font-family: arial; font-weight: bold\">Diff.500[hPa]&nbsp;&nbsp;</div></td>
                        <td><div style=\"font-family: arial; font-weight: bold\">Diff.2500[hPa]&nbsp;&nbsp;</div></td>
                    </tr>";

                    while($row = mysqli_fetch_array($result)) 
                    { 
                        echo"        
                        <tr>
                            <td>{$row['Year']}</td>
                            <td>{$row['Month']}</td>
                            <td>{$row['Day']}</td>
                            <td>{$row['Hour']}</td>
                            <td>{$row['D500']}</td>
                            <td>{$row['D2500']}</td>
                        </tr>"; 
    
                        $index++;
                    }
                }
        }
?>