<html>
<head>
	<title>Barcode Generator - MIK Services</title>
	<link href="style.css" type="text/css" rel="stylesheet"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=0.7"/>
	<meta name="theme-color" content="#BF2200">
	<meta name="mobile-web-app-capable" content="yes">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="icon" type="image/png" href="barcode_logo.png">
	<meta property="og:title" content="Barcode Generator By MIK Services">
	<meta property="og:description" content="Create Barcodes for Your Products.">
	<meta property="og:type" content="website">
	<meta property="og:url" content="">
	<meta property="og:image" content="barcode_logo.png">
	<meta property="og:image:width" content="256">
	<meta property="og:image:height" content="256">
	<meta property="og:site_name" content="Bar Code Generator By MIK Services">
	<style>
	.bc_container{
		font-family: Arial;
		display: inline-block;
		border-radius: 10px;
		border: 1px solid;
		padding: 5px;
	}
	@media print {
		.bc_container{
			border-radius: 0px;
			//border: none;
			padding: 0px;
		}
		.no-print{display:none}
	}
	</style>
</head>
<body>
	<div style="width:100%;">
	<table style="width:100%;">
	<?php
		$flag = false;
		if(isset($_POST['generate_barcode']))
		{
		 $code=$_POST['code'];
		 $ename=$_POST['ename'];
		 $price=$_POST['price'];
		 $quantity=round($_POST['quantity']/2);
		 $mfg=$_POST['mfg'];
		$exp=$_POST['exp'];
		$flag = true;
		}
		if($flag)
		{
			$mfg = date("d-m-y", strtotime($mfg) );
			$exp = date("d-m-y", strtotime($exp) );
			for($j=0;$j<$quantity;$j++){
				echo "<tr>";
				for($i=0;$i<2;$i++){
					echo "<td align='center'>";
						echo "<div class='bc_container' style='width:151px;height:94px;overflow:hidden'>";
							echo "<span style='font-size:18px;line-height:20px'>H & F Fabrics</span><br>
									<div style='font-size:12px;height:30px;margin-top:3px'>$ename  </div>";
							echo "<img alt='testing' style='width:100%' src='barcode.php?codetype=Code128&size=20&text=".$code."&print=true'/>";
							echo "<p style=';margin-top:2px;font-size:10px'>$code &nbsp;&nbsp;&nbsp;<b>Price: $price/- </b></p>";
							if($price != "")
								//echo "<p style='font-size:10px;margin-top:-10px;'>Rs: $price/- </p>"; 
							echo "<p style='font-size:10px;margin-top:-10px;'>";
							if($mfg != "" && $mfg != "01-01-70")
								echo "Mfg: $mfg &nbsp;&nbsp;";
							if($exp != "" && $exp != "01-01-70")
								echo "Exp: $exp";
							echo "</p>";
						echo "</div>";	
					echo "</td>";
				}
				echo "</tr>";
			}
		}
	?>
	</table>
	</div>
	<div class="no-print" style="margin-top:20px">
		<button onclick="history.back();">Back</button>&nbsp;&nbsp;&nbsp;<button onclick="window.print();">Print</button>
	<div>
</body>
</html>