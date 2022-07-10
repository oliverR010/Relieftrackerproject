<?php include('db_connect.php');
include('phpqrcode/qrlib.php');
require_once 'vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$types = $conn->query("SELECT *,concat(address,', ',street,', ',baranggay,', ',city,', ',state,', ',zip_code) as caddress FROM records order by caddress asc");
while($row=$types->fetch_assoc()):

    $id = $row['tracking_id'];
    $id_nostring = (int)$id;
    $codeContents = $id_nostring;
    
    $tempDir = "qrcodes/";
    $fileNames = 'qr_code_'.md5($codeContents).'.png';
    $pngAbsoluteFilePath = $tempDir.$fileNames;
    $urlRelativeFilePath = $tempDir.$fileNames;
    
	$image=file_get_contents( $pngAbsoluteFilePath);
	$imagedata=base64_encode($image);
	$imgpath='<center><img style="width:250px" src="data:image/png;base64, '.$imagedata.'"><center>';
	$HTML='<body ><div >'.$imgpath.'</div></body>';
	
	//Setting options
	$options=new Options();

	$options->set('enable_html5_parser',true);

	
	$dompdf=new Dompdf($options);
	$dompdf->loadHTML($HTML);

	
	$dompdf->render();
	$dompdf->stream();


endwhile;
?>

<?php
?>


