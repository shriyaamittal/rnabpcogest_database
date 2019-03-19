<?php

echo "
    <link rel='stylesheet' type='text/css' href='./advanced_search.css'>
    <link rel='icon' href='favicon.ico' type='image/x-icon'> 
    <link rel='shortcut icon' href='favicon.ico' type='image/x-icon'> 
    <title>
      Advanced Search
    </title>

<hr size=\"15px\" noshade>
    <hr>

<table>
      <tr>
        <td align=\"left\"><img src=\"./monogram.png\" alt=\"monogram\" width=\"150px\"></td>
        <td align=\"center\" width=\"80%\"><img src=\"./advanced_search.png\" alt=\"logo\" width=\"500px\"></td>
        <td align=\"right\"><a href=\"http://iiit.ac.in/\"><img src=\"./IIIT.jpg\" alt=\"IIIT-H\" width=\"150px\"></a></td>
      </tr>
    </table>
<hr size=\"15px\" noshade><hr>


    <p><a href='./home.html'><img align='right' src='./icon_home.jpg' alt='Go to home page' border='0' width='40px'></a></p>
    <p><a href='javascript:history.go(-1)'><img align='right' src='./icon_back.jpg' alt='Go back' border='0' width='40px'></a></p> ";

// Create connection 
$host=localhost;
$username=root;
$password=trisha95;
$dbname=BP_database;

$con=mysqli_connect($host,$username,$password,$dbname);

if (mysqli_connect_errno())
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

// Variables

$select="SELECT BP_name, BP_type, glyc_bond ";
$from="FROM Base_pair ";
$where="WHERE ";
$tabcount=0;

$w1=0;	// for 'and' in where
$where_flag=0;	// for cheking if there is a where condition
$opt_flag=0;
$rmsd_flag=0;

// Complete the FROM statement using the tablenames chosen and set up initial WHERE conditions

$i=0;
if (!empty($_POST['table']))
{
	foreach ($_POST['table'] as $check) 
	{
		if ($check=="Optimization_methods")
			$opt_flag=1;
		if ($check!="Base_pair")
		{
			if ($check=="Optimization_methods" or $check=="RMSD")
				$from=$from.", ".$check." ";
			else if ($i==0)
				$from=$from.$check;
			else if ($i==count($_POST['table'])-1)
				$from=$from.", ".$check." ";
			else
				$from=$from.", ".$check;
		}
		if ($check!="Base_pair" and $check!="Optimization_methods")
		{
			if ($wi==0)
			{
				if ($check=="RMSD")
				{
					$rmsd_flag=1;
					$where=$where.$check.".BP_id=Base_pair.BP_id";
				}
				else
					$where=$where.$check.".BP_id=Base_pair.BP_id and ".$check.".Opt_id=Optimization_methods.Opt_id";
			}
			else
			{
				if ($check=="RMSD")
				{
					$rmsd_flag=1;
					$where=$where." and ".$check.".BP_id=Base_pair.BP_id";
				}
				else
					$where=$where." and ".$check.".BP_id=Base_pair.BP_id and ".$check.".Opt_id=Optimization_methods.Opt_id ";

			}
			$wi=$wi+1;
			$where_flag=1;
		}
		$i=$i+1;
	}
}

$cols=array();
$num=0;

// Construct SELECT statement from columns chosen in Base_pair table

$i=0;
if (!empty($_POST['Base_pair']) or !empty($_POST['Base_pair_cond']))
{
	$tabcount=$tabcount+1;
	foreach ($_POST['Base_pair'] as $check) 
	{
		$cols[$num]=$check;
		$num=$num+1;
		if ($tabcount==count($_POST['table']))
		{
			if ($i==count($_POST['Base_pair'])-1)
				$select=$select.", ".$check." ";
			else
				$select=$select.", ".$check;
		}
		else
		{
			$select=$select.", ".$check;
		}
		$i=$i+1;
	}
}

// If Optimization_methods table is chosen, all columns are put in the SELECT statement

if ($opt_flag!=0)
{
	$tabcount=$tabcount+1;
	$select=$select.", Opt_type, level_of_theory, basis_set, phase ";
	$cols[$num]="Opt_type";
	$num=$num+1;
	$cols[$num]="level_of_theory";
	$num=$num+1;
	$cols[$num]="basis_set";
	$num=$num+1;
	$cols[$num]="phase";
	$num=$num+1;
}


// Construct SELECT statement from columns chosen in Parameters table

if (!empty($_POST['Parameters']) or !empty($_POST['Parameters_cond']))
{
	$tabcount=$tabcount+1;
	foreach ($_POST['Parameters'] as $check) 
	{
		$cols[$num]=$check;
		$num=$num+1;
			$select=$select.", ".$check." ";
	}
}

// If RMSD table is chosen, constructing the SELECT statement, except RMSD_value all should be present by default

if ($rmsd_flag!=0)
{
	$tabcount=$tabcount+1;
	$select=$select.", name, superposed_reg, RMSD_bet_reg ";
	$cols[$num]="name";
	$num=$num+1;
	$cols[$num]="superposed_reg";
	$num=$num+1;
	$cols[$num]="RMSD_bet_reg";
	$num=$num+1;
	foreach ($_POST['RMSD'] as $check)
	{
		$cols[$num]=$check;
		$num=$num+1;
		$select=$select.", ".$check." ";
	}
}

// Constructing SELECT for BP_geometry table, isostericity_atom should appear by default

if (!empty($_POST['BP_geometry']) or !empty($_POST['BP_geometry_cond']))
{
	$tabcount=$tabcount+1;
	$select=$select.", isostericity_atom";
	$cols[$num]="isostericity_atom";
	$num=$num+1;
	foreach ($_POST['BP_geometry'] as $check)
	{
		$cols[$num]=$check;
		$num=$num+1;
		$select=$select.", ".$check." ";
	}
}

// Constructing SELECT for H_bond table

if (!empty($_POST['H_bond']) or !empty($_POST['H_bond_cond']))
{
        $tabcount=$tabcount+1;
        foreach ($_POST['H_bond'] as $check)
        {
                $cols[$num]=$check;
                $num=$num+1;
                $select=$select.", ".$check." ";
        }
}

// Construct SELECT for Energy table
$flag1=0;
$flag2=0;

if (!empty($_POST['Energy']) or !empty($_POST['Energy_cond']))
{
	$tabcount=$tabcount+1;
        foreach ($_POST['Energy'] as $check)
        {
		if (($check=="E_interaction" or $check=="E_HF" or $check=="E_corr") and $flag1==0)
		{
			$select=$select.", energy_calc_method ";
			$cols[$num]="energy_calc_method";
			$num=$num+1;
			$flag1=1;
		}
		if (($check=="E_tot" or $check=="E_def" or $check=="E_int" or $check=="E_elec" or $check=="E_ex" or $check=="E_pol" or $check=="E_ct" or $check=="E_hoc" or $check=="BSSE" or $check=="E_ind_sapt" or $check=="E_disp_sapt") and $flag2==0)
		{
			$select=$select.", decompose_scheme, decompose_method ";
			$cols[$num]="decompose_scheme";
			$num=$num+1;
			$cols[$num]="decompose_method";
			$num=$num+1;
			$flag2=1;
		}
                $cols[$num]=$check;
                $num=$num+1;
                $select=$select.", ".$check." ";
        }
	
}

// Construct WHERE statement for Base_pair

$temp="";
if (!empty ($_POST['Base_pair_cond']))
{
	foreach ($_POST['Base_pair_cond'] as $check)
	{
		if ($where_flag==0)
		{
			if ($check=="frequency")	// add any other numerical field here
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
						if ($where_flag==0)
						{
							$where=$where.$check." ". $temp;
							$where_flag=1;
						}
						else
						{
							$where=$where." and ".$check." ". $temp;
							
						}
						$temp="";
					}
					if ($j==strlen($_POST[$check."text"]))
					{
						if ($where_flag==0)
						{
							$where=$where.$check." ". $temp;
							$where_flag=1;
						}
						else
						{
							$where=$where." and ".$check." ". $temp;
							
						}
						$temp="";
					}
					$i=$i+1;
					$j=$i+1;
				}
			}
			else
			{
				$where= $where.$check."=\"".$_POST[$check."text"]."\"";
			}
				$where_flag=1;
		}
		else
		{
				if ($check=="frequency")	// add any other numerical field here
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
                                                        $where=$where." and ".$check." ". $temp;

                                                $temp="";
                                        }
                                        if ($j==strlen($_POST[$check."text"]))
                                        {
                                                        $where=$where." and ".$check." ". $temp;
                                                $temp="";
                                        }
                                        $i=$i+1;
                                        $j=$i+1;
                                }

			}
			else
			{
				$where=$where." and ".$check."=\"".$_POST[$check."text"]."\"";	
			}
		}
	}
}

// Construct WHERE statement for Optimization_methods

if ($opt_flag!=0)
{
	if ($_POST['Opt_id']!=0)
	{
		if ($where_flag==0)
		{
			$where=$where."Optimization_methods.Opt_id=".$_POST['Opt_id'];
			$where_flag=1;
		}
		else
		{
			$where=$where." and Optimization_methods.Opt_id=".$_POST['Opt_id'];
		}
	}
}

// Construct WHERE statement for Parameters

if (!empty($_POST['Parameters_cond']))
{
	foreach($_POST['Parameters_cond'] as $check)
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
                                                        $where=$where." and ".$check." ". $temp;

                                                $temp="";
                                        }
                                        if ($j==strlen($_POST[$check."text"]))
                                        {
                                                        $where=$where." and ".$check." ". $temp;
                                                $temp="";
                                        }
                                        $i=$i+1;
                                        $j=$i+1;
				}
	}
}

// Construct WHERE statement for RMSD

if (!empty($_POST['RMSD_cond']))
{
	foreach($_POST['RMSD_cond'] as $check)
	{
		if ($where_flag==0)
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
					if ($where_flag==0)
					{
						$where=$where.$check." ". $temp;
						$where_flag=1;
					}
					else
					{
						$where=$where." and ".$check." ". $temp;

					}
					$temp="";
				}
				if ($j==strlen($_POST[$check."text"]))
				{
					if ($where_flag==0)
					{
						$where=$where.$check." ". $temp;
						$where_flag=1;
					}
					else
					{
						$where=$where." and ".$check." ". $temp;

					}
					$temp="";
				}
				$i=$i+1;
				$j=$i+1;
			}
			$where_flag=1;
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
					$where=$where." and ".$check." ". $temp;

					$temp="";
				}
				if ($j==strlen($_POST[$check."text"]))
				{
					$where=$where." and ".$check." ". $temp;
					$temp="";
				}
				$i=$i+1;
				$j=$i+1;
			}
		}
	}
}

// Construct WHERE statement for BP_geometry

if (!empty($_POST['BP_geometry_cond']))
{
        foreach($_POST['BP_geometry_cond'] as $check)
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
                                        $where=$where." and ".$check." ". $temp;

                                        $temp="";
                                }
                                if ($j==strlen($_POST[$check."text"]))
                                {
                                        $where=$where." and ".$check." ". $temp;
                                        $temp="";
                                }
                                $i=$i+1;
                                $j=$i+1;
                        }
        }
}

// Constructing WHERE for H_bond

if (!empty($_POST['H_bond_cond']))
{
	foreach ($_POST['H_bond_cond'] as $check)
	{
		$where=$where." and ".$check." LIKE \"".$_POST[$check."text"]."%\"";
	}
}

// Construct WHERE statement for Energy

if (!empty($_POST['Energy_cond']))
{
        foreach($_POST['Energy_cond'] as $check)
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
                                        $where=$where." and ".$check." ". $temp;
                                        $temp="";
                                }
                                if ($j==strlen($_POST[$check."text"]))
                                {
                                        $where=$where." and ".$check." ". $temp;
                                        $temp="";
                                }
                                $i=$i+1;
                                $j=$i+1;
                        }
        }
}

// Construct query
if ($where_flag==0)
	$query=$select.$from.";";
else
	$query=$select.$from.$where.";";
/*
echo "</br>";
echo $select;
echo "</br>";
echo $from;
echo "</br>";
echo $where;
echo "</br>";
echo $query;
echo "</br>";
echo "</br>";
*/

// Print table

$result = mysqli_query($con, $query) or die("Query failed!</br>Please try again!");

$i=0;
echo "<table border='2'>";
echo "<tr>";
echo "<th>Base Pair</th>";
while ($i<$num)
{
	if ($cols[$i]=="Opt_type")
	{
		echo "<th>Optimization method</th>";
		$i=$i+4;
	}
	else if ($cols[$i]=="description")
	{
		echo "<th>Description</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="position_type")
	{
		echo "<th>Position type</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="BP_mode")
	{
		echo "<th>Base pair mode</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="frequency")
	{
		echo "<th>Frequency</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="isostericity_subclass")
	{
		echo "<th>Isostericity subclass</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="grp_sugar_rep")
	{
		echo "<th>Group sugar replaced</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="ex_PDB")
	{
		echo "<th>example PDB file</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="ex_PDB_reso")
	{
		echo "<th>resolution</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="ex_BP_PDB")
	{
		echo "<th>Base pair in PDB file</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="constrained_atoms")
	{
		echo "<th>Constrained atoms</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="buckle")
	{
		echo "<th>Buckle</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="propeller")
	{
		echo "<th>Propeller</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="open")
	{
		echo "<th>Open</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="stagger")
	{
		echo "<th>Stagger</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="shear")
	{
		echo "<th>Shear</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="strech")
	{
		echo "<th>Strech</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="isostericity_dist")
	{
		echo "<th>Isostericity distance</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="isostericity_atom")
	{
		echo "<th>Isostericity atom</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="name")
	{
		echo "<th>RMSD name</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="DA_dist")
	{
		echo "<th>DA distance</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="HA_dist")
	{
		echo "<th>HA distance</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="DHA_angle")
	{
		echo "<th>DHA angle<th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="energy_calc_method")
	{
		echo "<th>Energy calculation method</th>";
		$i=$i+1;
	}
	else if ($cols[$i]=="E_corr")
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
	while ($i<$num)
	{
		if ($cols[$i]=="Opt_type")
		{
			echo "<td>".$row[$cols[$i]]." ".$row[$cols[$i+1]]." ".$row[$cols[$i+2]]." ".$row[$cols[$i+3]]."</td>";
			$i=$i+4;
		}
		else if ($cols[$i]=="decompose_scheme")
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
	echo "</tr>";
}

// Close connection
mysqli_close($con);

?>
