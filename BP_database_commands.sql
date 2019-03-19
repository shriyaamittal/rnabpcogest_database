mysql -uroot -p --local-infile

create database BP_database;

use BP_database;

create table Base_pair(
BP_id int not null, 
BP_name varchar(20) not null, 
description varchar(20),
BP_type varchar(10) not null, 
glyc_bond varchar(10) not null, 
position_type varchar(20), 
BP_mode varchar(20), 
frequency int, 
isostericity_subclass varchar(10), 
grp_sugar_rep varchar(100), 
ex_PDB varchar(10), 
ex_PDB_reso float, 
ex_BP_PDB varchar(20), 
constrained_atoms varchar(50), 
SINPlink_BP_page varchar(100), 
SINPlink_param_page varchar(100),
protonation varchar(30),
triples varchar(100),
water_med varchar(10),
freq_id varchar(15),
Remarks varchar(500),
primary key (BP_id)
);

create table Optimization_methods(
Opt_id int not null, 
Opt_type varchar(20), 
level_of_theory varchar(20), 
basis_set varchar(20), 
phase varchar(20), 
primary key (Opt_id)
);

create table RMSD(
S_no int auto_increment, 
BP_id int not null, 
superposed_reg varchar(10),
RMSD_bet_reg varchar(10),
Opt_id_1 int not null, 
Opt_id_2 int not null, 
name varchar(10),
RMSD_value float, 
primary key(S_no), 
foreign key (BP_id) references Base_pair(BP_id), 
foreign key (Opt_id_1) references Optimization_methods(Opt_id), 
foreign key (Opt_id_2) references Optimization_methods(Opt_id)
);

create table Parameters(
S_no int auto_increment, 
BP_id int not null, 
Opt_id int not null, 
buckle float, 
open float, 
propeller float, 
stagger float, 
shear float, 
strech float, 
E_value float, 
primary key (S_no), 
foreign key (BP_id) references Base_pair(BP_id), 
foreign key (Opt_id) references Optimization_methods(Opt_id)
);

create table BP_geometry(
S_no int auto_increment, 
BP_id int not null, 
Opt_id int not null, 
isostericity_atom varchar(10), 
isostericity_dist float, 
primary key(S_no), 
foreign key (BP_id) references Base_pair(BP_id), 
foreign key(Opt_id) references Optimization_methods(Opt_id)
);

create table H_bond(
S_no int auto_increment, 
BP_id int not null, 
Opt_id int not null, 
Donor varchar(20), 
Acceptor varchar(20), 
DA_dist float, 
HA_dist float, 
DHA_angle float, 
primary key(S_no), 
foreign key (BP_id) references Base_pair(BP_id), 
foreign key(Opt_id) references Optimization_methods(Opt_id)
);

create table Energy(
S_no int auto_increment, 
BP_id int not null, 
Opt_id int not null, 
energy_calc_method varchar(50), 
E_interaction float, 
E_HF float, 
E_corr float, 
E_def float, 
E_tot float,
decompose_scheme varchar(50), 
decompose_method varchar(50), 
E_int float, 
E_elec float,
E_ex float,
E_pol float,
E_ct float,
E_hoc float,
BSSE float,
E_ind_sapt float,
E_disp_sapt float,
primary key(S_no), 
foreign key (BP_id) references Base_pair(BP_id), 
foreign key(Opt_id) references Optimization_methods(Opt_id)
);

create table Frequency(
S_no int auto_increment,
bpfind_resno_1 varchar(10),
residue1_no int not null,
residue1_name varchar(5) not null,
chain_name_1 varchar(5),
bpfind_resno_2 varchar(10),
residue2_no int not null,
residue2_name varchar(5) not null,
chain_name_2 varchar(5),
bp_geom varchar(10),
E_value_crystal float,
freq_id varchar(15),
pdb_name varchar(15),
buckle_crys float,
open_crys float,
propeller_crys float,
stagger_crys float,
shear_crys float,
strech_crys float,
primary key(S_no)
);

load data local infile '/home/shriyaa/Desktop/Base_pair.csv' into table Base_pair fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/Optimization_methods.csv' into table Optimization_methods fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/RMSD.csv' into table RMSD fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/Parameters.csv' into table Parameters fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/BP_geometry.csv' into table BP_geometry fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/Energy.csv' into table Energy fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/H_bond.csv' into table H_bond fields terminated by ',' enclosed by '"' lines terminated by '\n';

load data local infile '/home/shriyaa/Desktop/Frequency.csv' into table Frequency fields terminated by ',' enclosed by '"' lines terminated by '\n';

mysqldump -uroot -p BP_database > BP_database.sql
create database BP_database;
mysql -uroot -p BP_database < BP_database.sql

create table freq_interim select freq_id as freq_interim_id, count(*) as freq_interim_count from Frequency where freq_id in (select distinct(freq_id) from Base_pair) group by freq_id;

create table hbond_interim as
(
select 
 A.BP_id
,A.BondType
,count(*) as BondTypeCount
from 
(
select distinct
 BP_id
,concat_ws(':',donor,acceptor) as TotalBond
,CASE
        WHEN concat_ws(':',donor,acceptor) LIKE 'N%:N%' THEN 'NN'
        WHEN concat_ws(':',donor,acceptor) LIKE 'N%:O%' THEN 'NO'
        WHEN concat_ws(':',donor,acceptor) LIKE 'O%:N%' THEN 'ON'
        WHEN concat_ws(':',donor,acceptor) LIKE 'O%:O%' THEN 'OO'
        WHEN concat_ws(':',donor,acceptor) LIKE 'C%:N%' THEN 'CN'
        WHEN concat_ws(':',donor,acceptor) LIKE 'C%:O%' THEN 'CO'
        END as BondType
from H_bond
) A
group by
 A.BP_id
,A.BondType
);
