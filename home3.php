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

echo "
A non-redundant dataset of RNA crystal structures having resolution better than 3.5 Angstrom and chain length atleast greater than 30 nucleotides, has been considered here to find out the occurrences and frequencies. Examples of the selected base pair geometry listed here, may or may not be exactly similar to the corresponding optimized geometry. To understand the exact geometry of each of the occurrences one need to investigate those individually by other softwares.
</br></br>";

$result = mysqli_query($con,"select residue1_no, residue1_name, chain_name_1, residue2_no, residue2_name, chain_name_2, bp_geom, E_value_crystal, pdb_name  from Frequency where Frequency.freq_id='$_POST[value_freq_id]'");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	if ($flag==0)
	{
echo "Base pair chosen: <b>" . $_POST['value_bp_name'] . " " . $_POST['value_bp_type'] . " " . $_POST['value_glyc_bond'];

	if ($_POST['value_protonation']=="NA")
                echo " [protonation ". $_POST['value_protonation']. "]</b></br></br>";
        else
                echo " [".$_POST['value_protonation']. "]</b></br></br>";


//	echo "<b>Table of Occurrences in chosen Non-Redundant Dataset</b></br></br>";
		echo "<table border='2'>
		<tr>
		<th>residue1</th>
		<th>residue2</th>
		<th>BP geometry</th>
		<th>E_value_crystal</th>
		<th>PDB name</th>
		</tr>";
		$flag=1;
	}
	if (!isset ($row['residue1_no']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['residue1_no']." ".$row['residue1_name']." (".$row['chain_name_1'] . ")</td>";
	if (!isset ($row['residue2_no']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['residue2_no']." ".$row['residue2_name']." (".$row['chain_name_2'] . ")</td>";
	if (!isset ($row['bp_geom']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['bp_geom'] ."</td>";
	if (!isset ($row['E_value_crystal']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_value_crystal'] . "</td>";
	if (!isset ($row['pdb_name']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
	{ // to remove the .out thing
		$i=0;
		$pdbname="";
		while ($i<(strlen($row['pdb_name'])-4))
		{
			$pdbname=$pdbname.$row['pdb_name'][$i];
			$i=$i+1;
		}
		$pdbnewname=$pdbname."_out.txt";
		echo "<td><a href=\"PDB/$pdbnewname\" target=\"_blank\">" . $pdbname . "</td>";
	}
	echo "</tr>";
}
echo "</table>";

mysqli_close($con);
?>
