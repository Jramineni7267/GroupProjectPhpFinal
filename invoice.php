

<?php 

  $con = mysqli_connect('localhost', 'root', '','zipper');

  //import the fpdf lib
  include_once ('fpdf184/fpdf.php');
  if(isset($con))
  {
$sql_product = "SELECT MAX(id) id FROM products";
$sql_user = "SELECT MAX(id) id FROM users";

$result = mysqli_query($con, $sql_product);
if (mysqli_num_rows($result) == 1) {
	$row = mysqli_fetch_assoc($result);
	  $id_product=$row["id"];
  } else if (mysqli_num_rows($result) >= 2){
	echo "Returned multiple values";
  }

  $result1 = mysqli_query($con, $sql_user);
if (mysqli_num_rows($result1) == 1) {
	$row1 = mysqli_fetch_assoc($result1);
	  $id_user=$row1["id"];
  } else if (mysqli_num_rows($result1) >= 2){
	echo "Returned multiple values";
  }


  class PDF extends FPDF 
  {
      function Header()
      {
         $this->Image('image/logo.jpg',10,5,50); //print image x, y, width 
         $this->SetFont('Arial','B',15); //Select your font
         $this->Cell(180,0,'ZipperLens',0, 0, 'R');
         $this->SetFont('Arial','',13); //Select your font
         $this->Cell(4,15,'123 Camrbrige Road',0, 0, 'R');
         $this->Cell(-17,25,'Camrbidge',0, 0, 'R');
         $this->Cell(-5,35,'Ontario, Canada',0, 0, 'C');
         $this->Ln(40);
         $this->SetFont('Arial','B',18); //Select your font
         $this->Cell(180,0,'INVOICE',0, 0, 'C');
         $this->Ln(20);

      }

      function Footer()
      {
          $this->SetY(-30); 
          $this->SetFont('Arial','B',13); //Select your font
         
          $this->Rect(10, 265, 190, 30, 'F');
          $this->SetTextColor(255,255,255);
          $this->Cell(65,30,'Jeshwanth Ramineni',0,0,'C');
          $this->Cell(65,30,'Parhtvi Shah',0,0,'C');
          $this->Cell(65,30,'Shreyansh',0,0,'C');
          $this->Ln(5);

          $this->Cell(65,30,'8727267',0,0,'C');
          $this->Cell(65,30,'8770788',0,0,'C');
          $this->Cell(65,30,'9999999',0,0,'C');



      }
  }

 
$query = mysqli_query($con, "Select * from users where id=$id_user")or die("database error:".mysqli_errror($con));
$user = mysqli_fetch_array($query);
$pdf = new PDF();
$pdf->AddPage();

//SetFonts 
$pdf->SetFont('Arial','B',13); //Set font 
$pdf->Cell(50,0,'Customer Details:',0, 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial','',10); 

$pdf->Cell(130,7,'First Name',1,0);
$pdf->Cell(59,7,$user['name'],1,1);
$pdf->Cell(130,7,'Last Name',1,0);
$pdf->Cell(59,7,$user['lastname'],1,1);
$pdf->Cell(130,7,'Email',1,0);
$pdf->Cell(59,7,$user['email'],1,1);




$pdf->Ln(10);

$query1 = mysqli_query($con, "Select * from products where id= $id_product")or die("database error:".mysqli_errror($con));
$booking = mysqli_fetch_array($query1);

// $query2 = mysqli_query($con, "select room_type.type,room_type.fare from room_type INNER JOIN room ON room_type.id_type = room.room_type_id_type INNER JOIN booking ON booking.room_id_room = room.id_room where booking.customer_id=$id_customer")or die("database error:".mysqli_errror($con));
// $room = mysqli_fetch_array($query2);

// $query3 = mysqli_query($con, "Select DATEDIFF(checkout,checkin) AS dif from booking where customer_id=$id_customer")or die("database error:".mysqli_errror($con));
// $diff = mysqli_fetch_array($query3);

$pdf->SetFont('Arial','B',13); //Set font 
$pdf->Cell(50,0,'Spects Details:',0, 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial','',10); 

$pdf->Cell(130,7,'Brand ',1,0);
$pdf->Cell(59,7,$booking['model'],1,1);
$pdf->Cell(130,7,'Name',1,0);
$pdf->Cell(59,7,$booking['title'],1,1);
$pdf->Cell(130,7,'Resolution',1,0);
$pdf->Cell(59,7,$booking['display'],1,1);
$pdf->Cell(130,7,'Camera Type',1,0);
$pdf->Cell(59,7,$booking['camera'],1,1);

$pdf->Ln(10);
$pdf->SetFont('Arial','B',12); 

$pdf->Cell(110,7,'To Pay in dollars ',0,0,'R');
// $pdf->Cell(20,7,$room['type'],0,0);
$pdf->Cell(59,7,$booking['price'],0,1,'C');





  $pdf->Output();
  }
?>