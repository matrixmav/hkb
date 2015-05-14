<?php
   class SecurityImage {
      var $oImage;
      var $iWidth;
      var $iHeight;
      var $iNumChars;
      var $iNumLines;
      var $iSpacing;
      var $sCode;
      
      function SecurityImage($iWidth = 200, $iHeight = 50, $iNumChars = 5, $iNumLines = 30) {
      
         $this->iWidth = $iWidth;
         $this->iHeight = $iHeight;
         $this->iNumChars = $iNumChars;
         $this->iNumLines = $iNumLines;
     
		$this->oImage=imagecreatefrompng('captcha_back.png');
         
        
         imagecolorallocate($this->oImage, 255, 255, 255);
         
       
         $this->iSpacing = (int)($this->iWidth / $this->iNumChars);
      }
      
      function DrawLines() {
         for ($i = 0; $i < $this->iNumLines; $i++) {
            $iRandColour = rand(100, 255);
            $iLineColour = imagecolorallocate($this->oImage, $iRandColour, $iRandColour, $iRandColour);
            imageline($this->oImage, rand(0, $this->iWidth), rand(0, $this->iHeight), rand(0, $this->iWidth), rand(0, $this->iHeight), $iLineColour);
         }
      }
      
      function GenerateCode() {
       
         $this->sCode = '';
         
          $str='';
		for($i=1; $i<=5; $i++) 
		{
			$ord=rand(48, 90);
			if((($ord >= 48) && ($ord <= 57)) || (($ord >= 65) && ($ord<= 90)))
			{
				$str.=chr($ord);
			}
			else
			{
				$str.=chr(rand(48, 57));
			}
		}
		
		$this->sCode = $str;

      }
      
      function DrawCharacters() 
	{
	  
		$rgb[0]=array(204,0,0);
		$rgb[1]=array(34,136,0);
		$rgb[2]=array(51,102,204);
		$rgb[3]=array(141,214,210);
		$rgb[4]=array(214,141,205);
		$rgb[5]=array(100,138,204);
	
		$fontsize=24;
		$g=6;
		for($i=0; $i<6; $i++)
		{
			$L[]=substr($this->sCode,$i,1); 
			$A[]=rand(-20, 20);  
			$F[]=rand(1, 10).".ttf"; 
			$C[]=rand(0, 5); 
			
			$T[]=imagecolorallocate($this->oImage,$rgb[$C[$i]][0],$rgb[$C[$i]][1],$rgb[$C[$i]][2]);  // allocate colors for chars
			imagettftext($this->oImage, $fontsize, $A[$i], $g, $fontsize+15, $T[$i], $F[$i], $L[$i]);  // write chars to image
			$g+=$fontsize+6;
		
		}
		
      }
      
      function Create($sFilename = '') {
      
         if (!function_exists('imagegif')) {
            return false;
         }
         
         $this->DrawLines();
         $this->GenerateCode();
         $this->DrawCharacters();
         
      
         if ($sFilename != '') {

            imagegif($this->oImage, $sFilename);
         } else {

            header('Content-type: image/gif');
            
           
            imagegif($this->oImage);
         }
         
    
         imagedestroy($this->oImage);
         
         return true;
      }
      
      function GetCode() {
         return $this->sCode;
      }
   }
?>
