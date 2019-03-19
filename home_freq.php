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

$result = mysqli_query($con,"select BP_name, BP_type, glyc_bond, protonation, Frequency.freq_id, count(Frequency.freq_id) from Frequency, Base_pair where Frequency.freq_id in (select distinct(freq_id) from Base_pair) and Base_pair.freq_id=Frequency.freq_id group by Frequency.freq_id;
");

//echo $_POST['sign'];
//echo $_POST['number'];

$flag=0;

if (strcmp('<', $_POST['sign'])==0)
{
	while($row = mysqli_fetch_array($result))
	{	
		if ($flag==0){
			echo "<table border='2'>
				<tr>
				<th>Base Pair</th>
				<th>protonation</th>
				<th>frequency</th></tr>"; $flag=1;}
		if ($row['count(Frequency.freq_id)']< $_POST['number'])
		{
			echo "<tr><td>".$row['BP_name']." ".$row['BP_type']." ".$row[glyc_bond]."</td>";
			echo "<td>".$row['protonation']."</td>";
			echo "<td>".$row['count(Frequency.freq_id)']."</td></tr>";
			//		echo "hi";	
		}
	}
}
else if (strcmp('>', $_POST['sign'])==0)
{
	while($row = mysqli_fetch_array($result))
	{	
		if ($flag==0){
			echo "<table border='2'>
				<tr>
				<th>Base Pair</th>
				<th>protonation</th>
				<th>frequency</th></tr>"; $flag=1;}
		if ($row['count(Frequency.freq_id)']> $_POST['number'])
		{
			echo "<tr><td>".$row['BP_name']." ".$row['BP_type']." ".$row[glyc_bond]."</td>";
			echo "<td>".$row['protonation']."</td>";
			echo "<td>".$row['count(Frequency.freq_id)']."</td></tr>";
			//		echo "hi";	
		}
	}
}
	echo "</table>";




//}

mysqli_close($con);
?>
