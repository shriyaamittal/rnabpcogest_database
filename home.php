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



//if ($_POST[protonation]!="NA" and $_POST[protonation][11]!=$_POST[BP_name][0] and $_POST[protonation][11]!=$_POST[BP_name][2])
//	echo die("Incorrect input! Check if you have chosen the correct protonated atom.");

$BP_type=$_POST['select_1'];
//echo $BP_type;
//echo "</br>";
$glyc_bond=$_POST['select_2'];
//echo $glyc_bond;
//echo "</br>";
$BP_name=$_POST['select_3'];
//echo $BP_name;
//echo "</br>";
$protonation=$_POST['select_4'];
//$protonation="NA";
//echo $protonation;
//echo "</br>";

//echo $_POST['BP_type'];
//echo $_POST['glyc_bond'];
//echo $_POST['BP_name'];
//echo $_POST['protonation'];

$result = mysqli_query($con,"select BP_name, description, BP_type, glyc_bond, frequency, ex_PDB, ex_BP_PDB, SINPlink_BP_page, protonation, triples, water_med, freq_id from Base_pair where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation'");

$count=0;
$i=0;
$folder="";
$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$freq_query = mysqli_query($con,"select count(freq_id) from Frequency where Frequency.freq_id='$row[freq_id]'");
	while ($row1= mysqli_fetch_array($freq_query))
	{
	 $freq=$row1['count(freq_id)'];
	}
	$count=$count+1;
	if ($flag==0)
	{
		// Base_pair
		echo "<table border='2'>
		<tr>
		<th>description</th>
		<th>frequency</th>
		<th>ex_PDB</th>
		<th>ex_BP_PDB</th>
		<th>protonation</th>
		<th>water mediated</th>
		<th>SINP_link</th>
		<th>triples</th>
		</tr>";
		$flag=1;
	}
	echo "Base pair chosen: <b>" . $row['BP_name'] . " " . $row['BP_type'] . " " . $row['glyc_bond'];
	if ($row[protonation]=="NA") 
		echo " [protonation ". $row['protonation']. "]</b></br></br>";
	else
		echo " [".$row['protonation']. "]</b></br></br>";	
	$name=$row['BP_name'].$row['BP_type'].$row['glyc_bond'][0];
	while ($i<strlen($name))
	{
		if ($name[$i]!=':' and $name[$i]!='(' and $name[$i]!=')')
		{
			$folder=$folder.$name[$i];
		}
		$i=$i+1;
	}
	if ($row['protonation']!="NA")
		$folder=$folder.$row['protonation'][11];
	$imgname=$folder.".txt";
	echo "<b>Base Pair information</b></br></br>";
	$link1=$row['SINPlink_BP_page'];
	$link2=$row['triples'];
	echo "<tr>";		
	if (!isset ($row['description']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['description'] . "</td>";
	if (!isset ($row['freq_id']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
	{
		if ($freq==0)
			echo "<td>".$freq."</td>";
		else
			echo "<td align=\"center\"><form action=\"./home3.php\" method=\"post\">
 			<input type=\"hidden\" name=\"value_freq_id\" value='$row[freq_id]'>
 			<input type=\"hidden\" name=\"value_bp_name\" value='$row[BP_name]'>
 			<input type=\"hidden\" name=\"value_bp_type\" value='$row[BP_type]'>
 			<input type=\"hidden\" name=\"value_glyc_bond\" value='$row[glyc_bond]'>
 			<input type=\"hidden\" name=\"value_protonation\" value='$row[protonation]'>
			<input type=\"submit\" value=\"$freq\" style=\"height:20px; width:60px;\"></form></td>";

	}
	if (!isset ($row['ex_PDB']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['ex_PDB'] . "</td>";
	if (!isset ($row['ex_BP_PDB']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['ex_BP_PDB'] . "</td>";
	if (!isset ($row['protonation']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['protonation'] . "</td>";
	if (!isset ($row['water_med']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['water_med'] . "</td>";
	if ($link1=="" or $link1=="NA")
		echo "<td align=\"center\">" . "-" . "</td>";
	else	
		echo "<td><a href=\"$link1\">" . "SINP database link" . "</a></td>";
	if ($link2=="" or $link2=="NA")
		echo "<td align=\"center\">" . "-" . "</td>";
	else	
		echo "<td><a href=\"$link2\">" . "SINP database link" . "</a></td>";

	echo "</tr>";
}
echo "</table>";

$result = mysqli_query($con,"select SINPlink_param_page, Opt_type, level_of_theory, basis_set, phase, buckle, open, propeller, stagger, shear, strech, E_value, Parameters.Opt_id from Base_pair, Optimization_methods, Parameters where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=Parameters.BP_id and Optimization_methods.Opt_id=Parameters.Opt_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$count=$count+1;
	if ($flag==0)
	{
		// Parameters
		echo "</br></br><b>Parameters information</b></br></br>";
		echo "<a href=\"legend.html#section3\" target=\"_blank\">". "Click here". "</a>"." for description on Base pair parameters.";

		echo "<table border='2'>
		<tr>
		<th>Optimization method</th>
		<th>buckle</th>
		<th>open</th>
		<th>propeller</th>
		<th>stagger</th>
		<th>shear</th>
		<th>strech</th>
		<th>E_value</th>
		<th>PDB file</th>
		<th>image file</th>
		</tr>";
		$flag=1;
	}
	$link1=$row['SINPlink_param_page'];
	echo "<tr>";		
	echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " " . $row['basis_set'] . " " . $row['phase'] . "</td>";
	if (!isset ($row['buckle']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['buckle'] . "</td>";
	if (!isset ($row['open']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['open'] . "</td>";
	if (!isset ($row['propeller']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['propeller'] . "</td>";
	if (!isset ($row['stagger']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['stagger'] . "</td>";
	if (!isset ($row['shear']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['shear'] . "</td>";
	if (!isset ($row['strech']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['strech'] . "</td>";
	if (!isset ($row['E_value']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_value'] . "</td>";

	$file=$folder."opt".$row['Opt_id'].".pdb";
	echo "<td><a href=\"$folder/$file\">download</a></td>";
	$file=$folder."opt".$row['Opt_id'].".png";
	echo "<td><a href=\"$folder/$file\" target=\"_blank\"><object data=\"$folder/$file\" width=\"60px\" onmouseover=\"this.width=200;\" onmouseout=\"this.width=60;\"><img alt=\"NA\"></td>";
	echo "</tr></a>";
}
echo "</table>";

// SINP link
if ($link1!="" and $link1!="NA")
	echo "</br><a href=\"$link1\">". "Click here". "</a>"." for parameter distribution from SINP database.";


$result = mysqli_query($con,"select name, RMSD_value from Base_pair, RMSD where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=RMSD.BP_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{
	$count=$count+1;
	if ($flag==0)
	{	
		echo "</br></br><b>RMSD values information</b></br></br>";
		echo "<a href=\"legend.html#section4\" target=\"_blank\">". "Click here". "</a>"." for legend on RMSD name.";
		// RMSD
		echo "<table border='2'>
		<tr>
		<th>name</th>
		<th>RMSD_value</th>
		<th>PDB file</th>
		<th>superposition image</th>
		</tr>";
		$flag=1;
	}
	echo "<tr>";		
	if (!isset ($row['name']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['name'] . "</td>";
	if (!isset ($row['RMSD_value']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['RMSD_value'] . "</td>";

	$file=$folder.$row['name'].".pdb";
	echo "<td><a href=\"$folder/$file\">download</a></td>";
	$file=$folder.$row['name'].".png";
	echo "<td><center><a href=\"$folder/$file\" target=\"_blank\"><object data=\"$folder/$file\" width=\"60px\" onmouseover=\"this.width=200;\" onmouseout=\"this.width=60;\"><img alt=\"NA\"></td>";
	echo "</tr></a>";
}
echo "</table>";

$result = mysqli_query($con,"select Opt_type, level_of_theory, basis_set, phase, isostericity_atom, isostericity_dist from Base_pair, Optimization_methods, BP_geometry where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=BP_geometry.BP_id and Optimization_methods.Opt_id=BP_geometry.Opt_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$count=$count+1;
	if ($flag==0)
	{
		// BP_geometry
		echo "</br></br><b>Base pair geometry information</b></br></br>";
		echo "Generally  C1'-C1' distance is considered as an isostericity measure, but for ground state optimization, in most of the cases (except sugar edge geometries) sugar moieties are replaced by H atoms. </br>So here we are considering distance between two glycosidic nitrogen for similar isostericty measure.</br></br><a href=\"legend.html#section2\" target=\"_blank\">". "Click here". "</a>"." to view original isostericity matrices.";
		echo "<table border='2'>
		<tr>
		<th>Optimization method</th>
		<th>isostericity_atom</th>
		<th>isostericity_dist</th>
		</tr>";
		$flag=1;
	}
	echo "<tr>";		
	echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " " . $row['basis_set'] . " " . $row['phase'] . "</td>";
	if (!isset ($row['isostericity_atom']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['isostericity_atom'] . "</td>";
	if (!isset ($row['isostericity_dist']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['isostericity_dist'] . "</td>";
	echo "</tr>";
}
echo "</table>";

$result = mysqli_query($con,"select Opt_type, level_of_theory, basis_set, phase, energy_calc_method, E_interaction, E_HF, E_corr, E_def, E_tot, decompose_scheme, decompose_method, E_int, E_elec, E_ex, E_pol, E_ct, E_hoc, E_ind_sapt, E_disp_sapt from Base_pair, Optimization_methods, Energy where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$count=$count+1;
	if ($flag==0)
	{
		// Energy
		echo "</br></br><b>Base pair Energy information</b></br></br>";
		echo "<a href=\"legend.html#section5\">". "Click here". "</a>"." for legend on Energy values.";
		echo "<table border='2'>
		<tr>
		<th>Optimization method</th>
		<th>energy_calc_method</th>
		<th>E_interaction</th>
		<th>E_HF</th>
		<th>E_corr</th>
		<th>E_def</th>
		<th>E_tot</th>
		</tr>";
		$flag=1;
	}
	echo "<tr>";		
	echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " " . $row['basis_set'] . " " . $row['phase'] . "</td>";
	if (!isset ($row['energy_calc_method']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['energy_calc_method'] . "</td>";
	if (!isset ($row['E_interaction']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_interaction'] . "</td>";
	if (!isset ($row['E_HF']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_HF'] . "</td>";
	if (!isset ($row['E_corr']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_corr'] . "</td>";
	if (!isset ($row['E_def']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_def'] . "</td>";
	if (!isset ($row['E_tot']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_tot'] . "</td>";
	echo "</tr>";
}
echo "</table></br>";

$result = mysqli_query($con,"select Opt_type, level_of_theory, basis_set, phase, decompose_scheme, decompose_method, E_int, E_elec, E_ex, E_pol, E_ct, E_hoc, E_ind_sapt, E_disp_sapt from Base_pair, Optimization_methods, Energy where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$count=$count+1;
	if ($flag==0)
	{
		echo "<table border='2'>
		<tr>	
		<th>Optimization method</th>
		<th>decompose_method</th>
		<th>E_int</th>
		<th>E_elec</th>
		<th>E_ex</th>
		<th>E_pol</th>
		<th>E_ct</th>
		<th>E_hoc</th>
		<th>E_ind</th>
		<th>E_disp</th>
		</tr>";
		$flag=1;
	}
	echo "<tr>";		
	echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " " . $row['basis_set'] . " " . $row['phase'] . "</td>";
	if (!isset ($row['decompose_scheme']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['decompose_scheme'] . " " . $row['decompose_method'] . "</td>";
	if (!isset ($row['E_int']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_int'] . "</td>";
	if (!isset ($row['E_elec']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_elec'] . "</td>";
	if (!isset ($row['E_ex']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_ex'] . "</td>";
	if (!isset ($row['E_pol']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_pol'] . "</td>";
	if (!isset ($row['E_ct']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_ct'] . "</td>";
	if (!isset ($row['E_hoc']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_hoc'] . "</td>";
	if (!isset ($row['E_ind_sapt']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_ind_sapt'] . "</td>";
	if (!isset ($row['E_disp_sapt']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['E_disp_sapt'] . "</td>";
	echo "</tr>";
}
echo "</table>";


$result = mysqli_query($con,"select Opt_type, level_of_theory, basis_set, phase, Donor, Acceptor, DA_dist, HA_dist, DHA_angle from Base_pair, Optimization_methods, H_bond where BP_type='$BP_type' and BP_name='$BP_name' and glyc_bond='$glyc_bond' and protonation='$protonation' and Base_pair.BP_id=H_bond.BP_id and Optimization_methods.Opt_id=H_bond.Opt_id");

$flag=0;
while($row = mysqli_fetch_array($result))
{	
	$count=$count+1;
	if ($flag==0)
	{
		// H_bond
		echo "</br></br><b>Base pair H-bond information</b></br></br>";
		echo "<a href=\"legend.html#section7\">". "Click here". "</a>"." for H-bond legend.";
		echo "<table border='2'>
		<tr>
		<th>Optimization method</th>
		<th>Donor</th>
		<th>Acceptor</th>
		<th>DA_dist</th>
		<th>HA_dist</th>
		<th>DHA_angle</th>
		</tr>";
		$flag=1;
	}
	echo "<tr>";		
	echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " " . $row['basis_set'] . " " . $row['phase'] . "</td>";
	if (!isset ($row['Donor']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['Donor'] . "</td>";
	if (!isset ($row['Acceptor']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['Acceptor'] . "</td>";
	if (!isset ($row['DA_dist']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['DA_dist'] . "</td>";
	if (!isset ($row['HA_dist']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['HA_dist'] . "</td>";
	if (!isset ($row['DHA_angle']))
	{
		echo "<td align=\"center\">-</td>";
	}
	else
		echo "<td>" . $row['DHA_angle'] . "</td>";
	echo "</tr>";
}
echo "</table>";
if ($flag==1)
{echo "</br><a href='#top'><img src='./images/icon_up.jpg' alt='Go to top' border='0' width='15px'></a>";}
if ($count==0)
{echo "No data available for chosen base pair. Please try again!";}

mysqli_close($con);
?>
