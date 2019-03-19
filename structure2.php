<?php

echo "
    <link rel='stylesheet' type='text/css' href='./css/energy.css'>
    <link rel='icon' href='./images/favicon.ico' type='image/x-icon'> 
    <link rel='shortcut icon' href='./images/favicon.ico' type='image/x-icon'> 
    <title>
      Structure
    </title>

<hr size=\"15px\" noshade>
    <hr>

<table>
      <tr>
        <td align=\"left\"><img src=\"./images/monogram.png\" alt=\"monogram\" width=\"150px\"></td>
        <td align=\"center\" width=\"80%\"><img src=\"./images/structure.png\" alt=\"logo\" width=\"500px\"></td>
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


$select= "SELECT BP_name, BP_type, glyc_bond, protonation, Opt_type, level_of_theory, basis_set, phase, E_value, E_value_crystal, residue1_no, residue1_name, chain_name_1, residue2_no, residue2_name, chain_name_2, PDB_name";
$where="WHERE ";
$from= "FROM Base_pair, Optimization_methods, Parameters, Frequency";

$cols=array();
$num=0;

// Constructing WHERE

$flag=0;

if ($_POST['Opt_id']!=0)
        {
                        $where=$where." Optimization_methods.Opt_id=".$_POST['Opt_id']." and ";
        }


$where=$where." BP_name=\"".$_POST['select_3']."\" and BP_type=\"".$_POST['select_1']."\" and glyc_bond=\"".$_POST['select_2']."\" and Base_pair.BP_id=Parameters.BP_id and Optimization_methods.Opt_id=Parameters.Opt_id and Frequency.freq_id=Base_pair.freq_id and Parameters.E_value".$_POST['sign']."Frequency.E_value_crystal";

$query=$select." ".$from." ".$where;



//echo $_POST['sign'];
//echo $query;

// Print table
$result = mysqli_query($con, $query) or die("Query failed!</br>Please try again!");

$i=0;
echo "<table border='2'>";
echo "<tr>";
echo "<th>Base Pair</th>";
echo "<th>Protonation</th>";
echo "<th>Optimization method";
echo "<th>E_value";
echo "<th>E_value_crystal";
echo "<th>residue numbers";
echo "<th>PDB_name";
echo "</tr>";

$i=0;
while($row = mysqli_fetch_array($result))
{
        $i=0;
        echo "<tr>";
        echo "<td>" . $row['BP_name'] . " ". $row['BP_type'] . " ". $row['glyc_bond'] . "</td>";
        echo "<td>" . $row['protonation']. "</td>";
        echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " ". $row['basis_set'] . " ".$row['phase']. "</td>";
        echo "<td>" . $row['E_value']. "</td>";
        echo "<td>" . $row['E_value_crystal']. "</td>";
        echo "<td>" . $row['residue1_no']." ".$row['residue1_name']."(".$row['chain_name_1'].")-". $row['residue2_no']." ".$row['residue2_name']."(".$row['chain_name_2'].") ". "</td>";
		$k=0;
                $pdbname="";
                while ($k<(strlen($row['PDB_name'])-4))
                {
                        $pdbname=$pdbname.$row['PDB_name'][$k];
                        $k=$k+1;
                }
//                $pdbnewname=$pdbname."_out.txt";
                echo "<td>" . $pdbname . "</td>";

}

// Close connection
mysqli_close($con);

?>
