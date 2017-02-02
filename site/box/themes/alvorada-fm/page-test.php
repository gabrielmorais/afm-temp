<?php

echo '<table>';

$row = 1;
if (($handle = fopen(THEME_PATH . "/usuarios-legado.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        echo "<tr>";
        //echo "<p> $num campos na linha $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo '<td>'.$data[$c] . "</td>";
        }
    	echo "</tr>";
    }
    fclose($handle);
}

echo '</table>';

?>