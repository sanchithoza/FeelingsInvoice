<?php
require('fpdf/fpdf.php');
/*$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'feelingsdb';
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM salesregister WHERE billNo = '4' ORDER BY billdate";
$res = $conn->query($sql);
 while($result=$res->fetch_object()){
    $billNo = $result->billNo;
 }
$conn->close();
*/
//Select the Products you want to show in your PDF file
class PDF extends FPDF
{

// Page header
function Header()
{
    $billNo = $_GET['bill'];
$servername = 'localhost';
$username = 'root';
$password = '';
$db = 'feelingsdb';
$conn = new mysqli($servername, $username, $password, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT * FROM salesregister WHERE billNo = $billNo ORDER BY billdate";
$res = $conn->query($sql);
 while($result=$res->fetch_object()){
    $name = $result->customerName;
    $billNo = $result->billNo;
    $address = $result->address;
    $date = new DateTime($result->billdate);
    $gstno = $result->gstNo;
    $netTotal = $result->netTotal;
    $cgstPer = $result->cgstPercent;
    $cgstAmt = $result->cgstRate;
    $sgstPer = $result->sgstPercent;
    $sgstAmt = $result->sgstRate;
    $igstPer = $result->igstPercent;
    $igstAmt = $result->igstRate;
    $grossTotal = $result->grossTotal;
 }
 $sqlitem = "SELECT * FROM salesitemregister WHERE billNo = $billNo";
 $res1 = $conn->query($sqlitem);
$conn->close();
$count = 0;
    // Logo
    //$this->Image('logo.png',10,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    // Title
    $this->Cell(0,10,'TAX INVOICE',0,0,'R');
    $this->Ln(10);
    $this->SetFont('Arial','B',25);
    $this->Cell(0,10,'FEELINGS',0,0,'C');
    $this->Ln(10);
    $this->SetFont('Arial','',10);
    $this->Multicell(0,5,"EXCLUSIVE SHOPPING BAG & CORPORATE GIFTS\n2nd FLOOR,OPP RANCHHODJI STREET SAYAJIROAD,NAVSARI 396445.(M. 9898264788) ",0,'C');
    $this->SetFont('Arial','B',10);
    $this->Cell(0,5,'GST NO : 24AQGPM9029B1Z1',0,0,'C');
	$this->Ln(10);
    $this->SetFont('Arial','B',10);
    $this->Cell(15,8,"TO : ",0,'L');
    $this->Cell(135,8,strtoupper($name),0,'L');
    $this->Cell(20,8,"BILL NO : ",0,'L');
    $this->Cell(30,8,$billNo,0,'L');
  	$this->Ln(8);
    $this->Cell(15,8,"ADD : ",0,'L');
    $this->Cell(135,8,strtoupper($address),0,'L');
    $this->Cell(20,8,"DATE : ",0,'L');
    $this->Cell(30,8,date_format($date, 'd-m-Y'),0,'L');
    $this->Ln(8);
    $this->Cell(15,8,"GST NO: ",0,'L');
    $this->Cell(75,8,$gstno,0,'L');
    
    $this->Ln(10);
    $this->Cell(10,10,"NO",1,'C');
    $this->Cell(80,10,"ITEM NAME",1,'C');
    $this->Cell(20,10,"HSNCODE",1,'C');
    $this->Cell(20,10,"QUANTITY",1,'C');	
    $this->Cell(20,10,"RATE",1,'C');
    $this->Cell(40,10,"AMOUNT",1,'C');		
    $this->Ln(10);
    while($result1=$res1->fetch_object()){
        $count = $count + 1;
    $this->Cell(10,10,$count,0,'C');
    $this->Cell(80,10,strtoupper($result1->itemName),0,'C');
    $this->Cell(20,10,$result1->hsnCode,0,'C');
    $this->Cell(20,10,$result1->quantity,0,'C');    
    $this->Cell(20,10,$result1->rate,0,'C');
    $this->Cell(40,10,$result1->totalAmount,0,'C');      
    $this->Ln(10);
    }
    // Position at 1.5 cm from bottom
    $this->SetY(-90);
    // Arial italic 8
     $this->SetFont('Arial','B',10);
    //$this->Ln(10); 
    $this->Cell(90,10,"",0,'L');
    $this->Cell(60,10,"Total",1,'L');
    $this->Cell(40,10,$netTotal,1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"",0,'L');
    $this->Cell(30,10,"ADD CGST",1,'L');
    $this->Cell(30,10,$cgstPer."%",1,'R');
    $this->Cell(40,10,$cgstAmt,1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"",0,'L');
    $this->Cell(30,10,"ADD SGST",1,'L');
    $this->Cell(30,10,$sgstPer."%",1,'R');
    $this->Cell(40,10,$sgstAmt,1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"",0,'L');
    $this->Cell(30,10,"ADD IGST",1,'L');
    $this->Cell(30,10,$igstPer."%",1,'R');
    $this->Cell(40,10,$igstAmt,1,'L');
    
    $this->Ln(10); 
    $this->Cell(90,10,"",0,'L');
    $this->Cell(60,10,"GRAND TOTAL(Round Off)",1,'L');
    $this->Cell(40,10,round($grossTotal).".00",1,'L');
    $this->Ln(10); 
    $this->SetFont('Arial','B',9);
    $this->Cell(0,10,"BANK DETAILS:PUNJAB NATIONAL BANK A/C NO: 05851131003485 , CENTER POINT BRANCH, IFSC : PUNB0058510",1,'L');
    $this->Ln(10);
    $this->SetFont('Arial','',9);
    // Page number
    $this->Multicell(0,4,"NOTE : \n1. INTEREST @ 24% P/A WILL BE CHARGERD IF INVOICE IS NOT PAID WITHIN DUE DATE.\n2. GOODS ONCE SOLD WILL NOT BE TAKEN BACK.\n3. ALL DISPUTES TO BE SETTELED AT NAVSARI.                                                                                              FOR FEELINGS",1,"L");
   
}

/*// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-90);
    // Arial italic 8
     $this->SetFont('Arial','B',10);
    $this->Ln(10); 
    $this->Cell(90,10,"BANK DETAILS:",0,'L');
    $this->Cell(60,10,"Total",1,'L');
    $this->Cell(40,10,"",1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"ORIANTAL BANK A/C NO: 05851131003485",0,'L');
    $this->Cell(30,10,"ADD CGST",1,'L');
    $this->Cell(30,10,"%",1,'R');
    $this->Cell(40,10,"",1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"CENTER POINT BRANCH",0,'L');
    $this->Cell(30,10,"ADD SGST",1,'L');
    $this->Cell(30,10,"%",1,'R');
    $this->Cell(40,10,"",1,'L');
    $this->Ln(10); 
    $this->Cell(90,10,"IFSC : ORBC0100585",0,'L');
    $this->Cell(60,10,"GRAND TOTAL",1,'L');
    $this->Cell(40,10,"",1,'L');
    $this->Ln(10); 
    
    $this->Cell(0,10,"BANK DETAILS:ORIANTAL BANK A/C NO: 05851131003485 , CENTER POINT BRANCH, IFSC : ORBC0100585",1,'L');
    $this->Ln(10);
    $this->SetFont('Arial','',10);
    // Page number
    $this->Multicell(0,4,"NOTE : \n1. INTEREST @ 24% WILL BE CHARGERD IF INVOICE IS NOT PAID WITHIN DUE DATE.\n2. GOODS ONCE SOLD WILL NOT BE TAKEN BACK.\n3. ALL DISPUTES TO BE SETTELED AT NAVSARI",1,"L");
}*/
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->SetFont('Times','',12);
$pdf->SetDrawColor(0,0,0);

//$pdf->Line(10,10,10,50);//title first vertical line
//$pdf->Line(200,10,200,50);//title last vertical line
$pdf->Line(10,10,10,257);//vertical border left
$pdf->Line(200,10,200,257);//vertical border right
$pdf->Line(20,85,20,207);//vertical line srno col
$pdf->Line(100,85,100,207);//vertical line item name
$pdf->Line(120,85,120,207);//vertical line hsn code
$pdf->Line(140,85,140,207);//vertical line qty
$pdf->Line(160,85,160,207);//vertical line rate
$pdf->Line(160,50,160,80);//vertical line addressbox middle

$pdf->Line(10,10,200,10);//horizontal border top
$pdf->Line(10,50,200,50);//horizontal line address top
$pdf->Line(10,207,200,207);//horizontal line item box bottom


$pdf->Line(160,267,160,283);//vertical line signature box

/*for($i=1;$i<=20;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,1,1);*/
$pdf->Output('I');

?>