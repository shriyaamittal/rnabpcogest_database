<?php

echo "
    <link rel='stylesheet' type='text/css' href='./css/home.css'>
    <link rel='icon' href='./images/favicon.ico' type='image/x-icon'> 
    <link rel='shortcut icon' href='./images/favicon.ico' type='image/x-icon'> 
    <title>
      Base Pair Information
    </title>

    <hr size=\"15px\" noshade>
    <hr>

<table>
      <tr>
        <td align=\"left\"><img src=\"./images/monogram.png\" alt=\"monogram\" width=\"150px\"></td>
        <td align=\"center\" width=\"80%\"><img src=\"./images/home.png\" alt=\"logo\" width=\"500px\"></td>
        <td align=\"right\"><a href=\"http://iiit.ac.in/\"><img src=\"./images/IIIT.jpg\" alt=\"IIIT-H\" width=\"150px\"></a></td>
      </tr>
    </table>
<hr size=\"15px\" noshade><hr>
<p><a href='./index.html'><img align='right' src='./images/icon_home.jpg' alt='Go to home page' border='0' width='40px'></a></p>
<p><a href='javascript:history.go(-1)'><img align='right' src='./images/icon_back.jpg' alt='Go back' border='0' width='40px'></a></p> ";

    // Create connection
    $host=localhost;
    $username=root;
    $password=trisha95;
    $dbname=BP_database;

    $con=mysqli_connect($host,$username,$password,$dbname);

    // Check connection

if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$name=strtoupper($_POST[bp][0]).":".strtoupper($_POST[bp][1]);
$namer1=strtoupper($_POST[bp][0]).":r".strtoupper($_POST[bp][1]);
$namer2="r:".strtoupper($_POST[bp][0]).strtoupper($_POST[bp][1]);
$namer3="r:".strtoupper($_POST[bp][0]).":r".strtoupper($_POST[bp][1]);
$type=strtoupper($_POST[bp][2]).":".strtoupper($_POST[bp][3]);

echo "<table border='2'>
<tr>
<th>BP name</th>
<th>desciption</th>
<th>frequency</th>
<th>protonation</th>
<th>Choose/submit</th>
</tr>";

$result = mysqli_query($con,"select BP_name, description, BP_type, glyc_bond, frequency, protonation, freq_id from Base_pair where (BP_name LIKE '$name%' or BP_name LIKE '$namer1%' or BP_name LIKE '$namer2%' or BP_name LIKE '$namer3%') and BP_type='$type'");


$i=0;
$folder="";
while($row = mysqli_fetch_array($result))
{
	$freq_query = mysqli_query($con,"select count(freq_id) from Frequency where Frequency.freq_id='$row[freq_id]'");
        while ($row1= mysqli_fetch_array($freq_query))
        {
         $freq=$row1['count(freq_id)'];
        }	
	echo "<tr>";		
	echo "<td>" . $row['BP_name'] . " " . $row['BP_type'] . " " . $row['glyc_bond'] . "</b></br></br>";
	echo "<td>" . $row['description'] . "</td>";
//	echo "<td>" . $row['frequency'] . "</td>";
	
	if (!isset ($row['freq_id']))
        {
                echo "<td align=\"center\">-</td>";
        }
        else
        {
                        echo "<td>".$freq."</td>";
        }

	echo "<td>" . $row['protonation'] . "</td>";
	$variable=$row['BP_name']."_".$row['BP_type']."_".$row['glyc_bond']."_".$row['protonation'];
	echo "<td align=\"center\"><form action=\"home2.php\" method=\"post\"><input type=\"radio\" name=\"inputfromtable\" value=\"$variable\"></td>";
	echo "</tr>";
}
echo "</table></br>";
echo "<input type=\"submit\"></form>";

mysqli_close($con);
?>
