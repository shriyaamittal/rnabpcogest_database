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

$dec_scheme=$_POST['table'][0];

$select= "SELECT BP_name, BP_type, glyc_bond, position_type, BP_mode, protonation, Opt_type, level_of_theory, basis_set, phase";
$where="WHERE energy_calc_method='$_POST[energy_calc_method]' and ";
$from= "FROM Base_pair, Optimization_methods, Energy";

// Constructing SELECT

//echo $_POST['energy_calc_method'];

$flag1=1;
$flag2=0;

$cols=array();
$num=0;

foreach ($_POST['energy'] as $check)
        {
       //         if (($check=="E_interaction" or $check=="E_HF" or $check=="E_corr") and $flag1==0)
           //     {
     //                   $select=$select.", energy_calc_method ";
       //                 $cols[$num]="energy_calc_method";
         //     	        $num=$num+1;
          //              $flag1=1;
             //   }
                if (($check=="E_tot" or $check=="E_def" or $check=="E_int" or $check=="E_elec" or $check=="E_ex" or $check=="E_pol" or $check=="E_ct" or $check=="E_hoc" or $check=="BSSE" or $check=="E_ind_sapt" or $check=="E_disp_sapt") and $flag2==0)
                {
                        $select=$select.", decompose_scheme, decompose_method ";
                        $cols[$num]="decompose_scheme";
			$where=$where."decompose_scheme='$dec_scheme' and ";
                        $num=$num+1;
                        $cols[$num]="decompose_method";
                        $num=$num+1;
                        $flag2=1;
                }
                $cols[$num]=$check;
                $num=$num+1;
                $select=$select.", ".$check." ";
        }

// Constructing WHERE

$flag=0;

if(!empty($_POST['energy']))
{
        foreach($_POST['energy'] as $check)
        {
                if ($flag==0)
                {
                        $i=0;
                        $j=0;
                        while ($i<strlen($_POST[$check."text"]))
                        {
                                if ($_POST[$check."text"][$i]!=";")
                                {
                                        $temp=$temp.$_POST[$check."text"][$i];
                                }
                                else if ($_POST[$check."text"][$i]==";")
                                {
                                        $where=$where . " " . $check . " " . $temp . " and";
                          //              echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                if ($j==strlen($_POST[$check."text"]))
                                {
                                        $where=$where . " " . $check . " " . $temp;
 //                                       echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                $i=$i+1;
                                $j=$i+1;
                        }
                        $flag=1;
                }
                else
                {
                        $i=0;
                        $j=0;
                        while ($i<strlen($_POST[$check."text"]))
                        {
                                if ($_POST[$check."text"][$i]!=";")
                                {
                                        $temp=$temp.$_POST[$check."text"][$i];
                                }
                                else if ($_POST[$check."text"][$i]==";")
                                {
                                        $where=$where . " and  " . $check . " " . $temp;
   //                                     echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                if ($j==strlen($_POST[$check."text"]))
                                {
                                        $where=$where . " and " . $check . " " . $temp;
                            //            echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                $i=$i+1;
                                $j=$i+1;
                        }
                }
        }
}

$where=$where." and Base_pair.BP_id=Energy.BP_id and Optimization_methods.Opt_id=Energy.Opt_id";

$query=$select." ".$from." ".$where;

echo $query;


// Print table
$result = mysqli_query($con, $query) or die("Query failed!</br>Please try again!");

$i=0;
echo "<table border='2'>";
echo "<tr>";
echo "<th>Base Pair</th>";
echo "<th>Protonation</th>";
echo "<th>Position type</th>";
echo "<th>BP mode</th>";
echo "<th>Optimization method";
while ($i<$num)
{
	if ($cols[$i]=="energy_calc_method")
        {
                echo "<th>Energy calculation method</th>";
                $i=$i+1;
        }
        if ($cols[$i]=="E_corr")
        {
                echo "<th>E_correlation</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="decompose_scheme")
        {
                echo "<th>Decomposition method</th>";
                $i=$i+2;
        }
        else if ($cols[$i]=="E_tot")
        {
                echo "<th>E_total</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_def")
        {
                echo "<th>E_deformation</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_int")
        {
                echo "<th>E_interaction</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_elec")
        {
                echo "<th>E_electrostatic</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_ex")
        {
                echo "<th>E_exchange repulsion</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_ct")
        {
                echo "<th>E_charge transfer</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_hoc")
        {
                echo "<th>E_higher order coupling</th>";
                $i=$i+1;
        }
	else if ($cols[$i]=="E_ind_sapt")
        {
                echo "<th>E_induction</th>";
                $i=$i+1;
        }
        else if ($cols[$i]=="E_disp_sapt")
        {
                echo "<th>E_dispersion</th>";
                $i=$i+1;
        }
	else
	{
		echo "<th>$cols[$i]</th>";
		$i=$i+1;
	}
}
echo "</tr>";

$i=0;
while($row = mysqli_fetch_array($result))
{
        $i=0;
        echo "<tr>";
        echo "<td>" . $row['BP_name'] . " ". $row['BP_type'] . " ". $row['glyc_bond'] . "</td>";
        echo "<td>" . $row['protonation']. "</td>";
        echo "<td>" . $row['position_type']. "</td>";
        echo "<td>" . $row['BP_mode']. "</td>";
        echo "<td>" . $row['Opt_type'] . " ". $row['level_of_theory'] . " ". $row['basis_set'] . " ".$row['phase']. "</td>";
	while ($i<$num)
	{	
		if ($cols[$i]=="decompose_scheme")
                {
                        echo "<td>".$row[$cols[$i]]." ".$row[$cols[$i+1]]."</td>";
                        $i=$i+2;
                }
                else
                {
                        echo "<td>".$row[$cols[$i]]."</td>";
                        $i=$i+1;
                }

	}	
}

// Close connection
mysqli_close($con);

?>
