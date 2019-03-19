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


$select= "SELECT BP_name, BP_type, glyc_bond, protonation, Opt_type, level_of_theory, basis_set, phase, E_value";
$where="WHERE ";
$from= "FROM Base_pair, Optimization_methods, Parameters";

$cols=array();
$num=0;

// Constructing WHERE

$flag=0;

//if(!empty($_POST['energy']))
//{
  //      foreach($_POST['energy'] as $check)
 //       {
 //               if ($flag==0)
 //               {
                        $i=0;
                        $j=0;
                        while ($i<strlen($_POST["E_valuetext"]))
                        {
                                if ($_POST["E_valuetext"][$i]!=";")
                                {
                                        $temp=$temp.$_POST["E_valuetext"][$i];
                                }
                                else if ($_POST["E_valuetext"][$i]==";")
                                {
                                        $where=$where . "E_value" . $temp . " and ";
                          //              echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                if ($j==strlen($_POST["E_valuetext"]))
                                {
                                        $where=$where . "E_value" . $temp;
 //                                       echo $check." ".$temp."</br>";
                                        $temp="";
                                }
                                $i=$i+1;
                                $j=$i+1;
                        }
   //                     $flag=1;
   //             }
   /*             else
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
}*/

if ($_POST['Opt_id']!=0)
        {
                        $where=$where." and Optimization_methods.Opt_id=".$_POST['Opt_id'];
        }

$where=$where." and Base_pair.BP_id=Parameters.BP_id and Optimization_methods.Opt_id=Parameters.Opt_id";

$query=$select." ".$from." ".$where;

echo $query;

// Print table
$result = mysqli_query($con, $query) or die("Query failed!</br>Please try again!");

$i=0;
echo "<table border='2'>";
echo "<tr>";
echo "<th>Base Pair</th>";
echo "<th>Protonation</th>";
echo "<th>Optimization method";
echo "<th>E_value";
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
}

// Close connection
mysqli_close($con);

?>
