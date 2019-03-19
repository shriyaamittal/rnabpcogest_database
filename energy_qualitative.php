<?php

echo "
    <link rel='stylesheet' type='text/css' href='./css/energy.css'>
    <link rel='icon' href='./images/favicon.ico' type='image/x-icon'> 
    <link rel='shortcut icon' href='./images/favicon.ico' type='image/x-icon'> 
    <title>
      Energy
    </title>

<hr size=\"15px\" noshade>
    <hr>

<table>
      <tr>
        <td align=\"left\"><img src=\"./images/monogram.png\" alt=\"monogram\" width=\"150px\"></td>
        <td align=\"center\" width=\"80%\"><img src=\"./images/energy.png\" alt=\"logo\" width=\"500px\"></td>
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

if (mysqli_connect_errno())
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

$type=$_POST['qualitative'];

echo "<b>List of ". strtoupper($type)." energy Base Pairs</b></br></br>";

$select= "SELECT BP_name, BP_type, glyc_bond, protonation, Opt_type, level_of_theory, basis_set, phase, E_interaction";
$from= "FROM Base_pair, Optimization_methods, Energy";

if ($type=="weak")
{
	$where="WHERE E_interaction>-6 and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id";
}
elseif ($type=="medium")
{
	$where="WHERE E_interaction>-15.4 and E_interaction<-10 and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id";
}
elseif ($type=="strong")
{
	$where="WHERE E_interaction<-15.4 and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id";
}

$query=$select." ".$from." ".$where;

$result = mysqli_query($con, $query) or die("Query failed!</br>Please try again!");
$i=0;
echo "<table border='2'>";
echo "<tr>";
echo "<th>Base Pair</th>";
echo "<th>Protonation</th>";
echo "<th>Optimization method";
echo "<th>E_interaction";
echo "</tr>";

while($row = mysqli_fetch_array($result))
{
        $i=0;
        echo "<tr>";
        echo "<td>" . $row['BP_name'] . " ". $row['BP_type'] . " ". $row['glyc_bond'] . "</td>";
        echo "<td>" . $row['protonation']. "</td>";
        echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " ". $row['basis_set'] . " ".$row['phase']. "</td>";
        echo "<td>" . $row['E_interaction']. "</td>";
}




// Close connection
mysqli_close($con);

?>
