<html>
	<head>
		<meta charset="utf-8"> 
	</head>

<?php

if(isset($_POST['file'])&& $_POST['file']!= ''){
	$file=fopen($_POST['file'],"r")or exit("Unable to open file!");
	$du = $_POST['du'];
	if($du == '')
		$du = 0;
	$fp = fopen("output.srt","wb")or exit("Unable to open file!");
	$content = '';
	while(!feof($file))
	{
		$line =  fgets($file);
  		if($line[0] == '0'){
  			$duration = explode("-->",$line);
			$from = trim($duration[0]);
			$to   = trim($duration[1]);
			$pieces1 = explode(':',$from);
			$pieces2 = explode(':',$to);
			
			$hour1 = $pieces1[0]; 
			$minute1 = $pieces1[1]; 
			$rest1 = explode(',', $pieces1[2]) ; 
			$second1 = $rest1[0];
			$second_part1 = $rest1[1];
			
			$hour2 = $pieces2[0]; 
			$minute2 = $pieces2[1]; 
			$rest2 = explode(',', $pieces2[2]) ; 
			$second2 = $rest2[0];
			$second_part2 = $rest2[1];
			
			if(($second1+$du) > 60){
				$new_second1 = ($second1+$du)-60;
				if(strlen($new_second1) < 2){
					$new_second1 = '0'.$new_second1;
				}
				$minute1++;
				if(strlen($minute1) < 2){
					$minute1 = '0'.$minute1;
				}
			}
			else {
				$new_second1 = ($second1+$du);
				if ($new_second1 < 0){
					$new_second1 = 60 + $new_second1;
					$minute1--;
					if(strlen($minute1) < 2){
						$minute1 = '0'.$minute1;
					}
				}
				if(strlen($new_second1) < 2){
					$new_second1 = '0'.$new_second1;
				}
			}
			
			if(($second2+$du) > 60){
				$new_second2 = ($second2+$du)-60;
				if(strlen($new_second2) < 2){
					$new_second2 = '0'.$new_second2;
				}
				$minute2++;
				if(strlen($minute2) < 2){
					$minute2 = '0'.$minute2;
				}
			}
			else {
				$new_second2 = ($second2+$du);
				if ($new_second2 < 0){
					$new_second2 = 60 + $new_second2;
					$minute2--;
					if(strlen($minute2) < 2){
						$minute2 = '0'.$minute2;
					}
				}
				if(strlen($new_second2) < 2){
					$new_second2 = '0'.$new_second2;
				}
			}
			
			$line = $hour1.':'.$minute1.':'.$new_second1.','.$second_part1.' --> '.$hour2.':'.$minute2.':'.$new_second2.','.$second_part2;
			
  		}
		if(is_numeric($line))
			$content .= iconv(mb_detect_encoding($line, mb_detect_order(), true), "UTF-8", $line); 
		
		else
		{
			var_dump($line);
			echo "<hr>";
			if (is_numeric($line[0])){
				$content .= iconv(mb_detect_encoding($line, mb_detect_order(), true), "UTF-8", $line)."\n";
			}
			else
				$content .= iconv(mb_detect_encoding($line, mb_detect_order(), true), "UTF-8", $line);
		}
			 
	}
	
	fclose($file);
	
	 
	 fwrite($fp,$content);
	 fwrite($fp,pack("CCC",0xef,0xbb,0xbf));
	 fclose($fp);
	 echo "success";
}
else if(isset($_POST['edit'])){
	$du = $_POST['du'];
	if($du == '')
		$du = 0;
	$file=fopen("file.txt","r")or exit("Unable to open file!");
	$fp = fopen("output.srt","wb")or exit("Unable to open file!");
	$content = '';
	while(!feof($file))
	{
		$line =  fgets($file);
  		if($line[0] == '0'){
  			$duration = explode("-->",$line);
			$from = trim($duration[0]);
			$to   = trim($duration[1]);
			$pieces1 = explode(':',$from);
			$pieces2 = explode(':',$to);
			
			$hour1 = $pieces1[0]; 
			$minute1 = $pieces1[1]; 
			$rest1 = explode(',', $pieces1[2]) ; 
			$second1 = $rest1[0];
			$second_part1 = $rest1[1];
			
			$hour2 = $pieces2[0]; 
			$minute2 = $pieces2[1]; 
			$rest2 = explode(',', $pieces2[2]) ; 
			$second2 = $rest2[0];
			$second_part2 = $rest2[1];
			
			if(($second1+$du) > 60){
				$new_second1 = ($second1+$du)-60;
				if(strlen($new_second1) < 2){
					$new_second1 = '0'.$new_second1;
				}
				$minute1++;
				if(strlen($minute1) < 2){
					$minute1 = '0'.$minute1;
				}
			}
			else {
				$new_second1 = ($second1+$du);
				if(strlen($new_second1) < 2){
					$new_second1 = '0'.$new_second1;
				}
			}
			
			if(($second2+$du) > 60){
				$new_second2 = ($second2+$du)-60;
				if(strlen($new_second2) < 2){
					$new_second2 = '0'.$new_second2;
				}
				$minute2++;
				if(strlen($minute2) < 2){
					$minute2 = '0'.$minute2;
				}
			}
			else {
				$new_second2 = ($second2+$du);
				if(strlen($new_second2) < 2){
					$new_second2 = '0'.$new_second2;
				}
				
			}
			
			$line = $hour1.':'.$minute1.':'.$new_second1.','.$second_part1.' --> '.$hour2.':'.$minute2.':'.$new_second2.','.$second_part2;
			
  		}
		if(is_numeric($line))
			$content .= iconv(mb_detect_encoding($line, mb_detect_order(), true), "UTF-8", $line); 
		
		else
			$content .= iconv(mb_detect_encoding($line, mb_detect_order(), true), "UTF-8", $line)."\n"; 
	}
	
	fclose($file);
	
	 
	 fwrite($fp,$content);
	 fwrite($fp,pack("CCC",0xef,0xbb,0xbf));
	 fclose($fp);
	 echo "success";
}
else
	echo '<form action="index.php" method="post">
	<label>enter the subtitle path : </label>
	<input type="text" name="file" />
	<lable>enter the duration : </lable>
	<input type="text" name="du" />
	<input type="submit" name="edit" value="send" />
	
</form>';


?>

</html>