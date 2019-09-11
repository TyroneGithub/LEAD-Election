<?php
require 'fpdf/fpdf.php';
include 'connection.php';
session_start();
if (empty($_SESSION['username'])){
    header('location:index.php'); 
}
else if ($_SESSION['type']=='student'){
    header('location:main.php?type=student');
}
date_default_timezone_set("Asia/Manila");

class PDF extends FPDF
{
function Header(){
    $this->Image('images/vectorlsqc.png',45,2,25);
  
    $this->SetFont("Helvetica","B","14");
    $this->Cell(0,2,"Lourdes School Quezon City",0,1,"C");
    $this->SetFont("Helvetica","B","14");
    $this->Cell(0,10,"High School Department",0,0,"C");
    $this->Ln(20);
    
    }
function Footer(){
        $date = date('F d, Y');
        $this->Cell(0,10,"Date Printed: $date",0,1,"R");  
    }
function electionResult($connection){
    $this->SetFont("Helvetica","B","14");
    $this->Cell(0,10, "Election Results ", 0,1,"C");
    $this->Cell(0,10, "as of ", 0,1,"C");
    $date = date('F d, Y | g:i a' );
    $this->Cell(0,10, "$date", 0,1,"C");
    $get_students = "SELECT * FROM users WHERE role='student' AND active=1 ";
    $result_student = mysqli_query($connection,$get_students);
    $count_student = mysqli_num_rows($result_student);

    $get_voted = "SELECT * FROM users INNER JOIN response
    ON users.username = response.voter_id
    WHERE role='student' AND users.active=1 AND response.active=1 ";
    $result_voted = mysqli_query($connection,$get_voted);
    $count_voted = mysqli_num_rows($result_voted);
    $this->Cell(0,10,"Number of voters: $count_voted/$count_student ",0,1,"R");  
    $this->Ln(6);
   
    $get_pos = "SELECT * FROM position INNER JOIN candidate
    ON position.position_id = candidate.position
    WHERE position.active =1 GROUP BY position_id  ";
    $res_pos = mysqli_query($connection,$get_pos);
    while ($row_pos = mysqli_fetch_assoc($res_pos)){
    $pos_no = $row_pos['position_id'];
    $pos_name = $row_pos['pos_name'];
    
        $this->SetFont("Helvetica","B","11");
        $this->Cell(0,9,"$pos_name","B",1,"L");
       

        $get_cand = "SELECT * FROM candidate
        INNER JOIN party_list
        ON candidate.party_list = party_list.party_id
        WHERE candidate.active=1 AND party_list.active=1  AND position = '$pos_no' AND name!='abstain'
        ORDER BY vote DESC  ";
        $res_cand=mysqli_query($connection,$get_cand);
        while ($row_cand = mysqli_fetch_assoc($res_cand)){
        $name = $row_cand['name'];
        //$cand_id = $row_cand['candidate_id'];
        $votes = $row_cand['vote'];
        $party = $row_cand['party_name'];
        $this->SetFont("Helvetica","","11");
        $this->Cell(0,10,"$name ($party)",0,0,"L");  
        $this->Cell(0,10,"$votes",0,1,"R");
        }
        $get_abstain = "SELECT * FROM candidate
        INNER JOIN party_list ON candidate.party_list = party_list.party_id
        WHERE candidate.position ='$pos_no'
        AND candidate.active =1 AND name='abstain' ORDER BY vote DESC ";
        $res_abstain = mysqli_query($connection,$get_abstain);
        while($row_abstain = mysqli_fetch_assoc($res_abstain)){
        $abstain_name = $row_abstain['name'];
        $abstain_party = $row_abstain['party_name'];
        $abstain_votes = $row_abstain['vote'];
        $this->SetFont("Helvetica","","11");
        $this->Cell(0,10,"$abstain_name",0,0,"L");  
        $this->Cell(0,10,"$abstain_votes",0,1,"R");
        }
        
    }

}

}  

$pdf=new PDF();
$pdf->AddPage();
$pdf->electionResult($connection);
$pdf->AliasNbPages();
//$pdf->Footer();
$pdf->Output('Election Results.pdf','I');