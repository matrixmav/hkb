<?php
header("Content-type: text/xml");
include("ADMIN/Utils.php");
include("config.php");

$user = get_param("user");

if($user == "")
{
	die("Error - user not set!");
}





 function utf8_to_unicode( $str ) {
        
        $unicode = array();        
        $values = array();
        $lookingFor = 1;
        
        for ($i = 0; $i < strlen( $str ); $i++ ) {

            $thisValue = ord( $str[ $i ] );
            
            if ( $thisValue < 128 ) $unicode[] = $thisValue;
            else {
            
                if ( count( $values ) == 0 ) $lookingFor = ( $thisValue < 224 ) ? 2 : 3;
                
                $values[] = $thisValue;
                
                if ( count( $values ) == $lookingFor ) {
            
                    $number = ( $lookingFor == 3 ) ?
                        ( ( $values[0] % 16 ) * 4096 ) + ( ( $values[1] % 64 ) * 64 ) + ( $values[2] % 64 ):
                    	( ( $values[0] % 32 ) * 64 ) + ( $values[1] % 64 );
                        
                    $unicode[] = $number;
                    $values = array();
                    $lookingFor = 1;
            
                } // if
            
            } // if
            
        } // for

        return $unicode;
    
    } // utf8_to_unicode



function unicode_to_entities( $unicode ) {
        
        $entities = '';
        foreach( $unicode as $value ) $entities .= '&#' . $value . ';';
        return $entities;
        
    } // unicode_to_entities


function unicode_to_utf8( $str ) {
    
        $utf8 = '';
        
        foreach( $str as $unicode ) {
        
            if ( $unicode < 128 ) {

                $utf8.= chr( $unicode );
            
            } elseif ( $unicode < 2048 ) {
                
                $utf8.= chr( 192 +  ( ( $unicode - ( $unicode % 64 ) ) / 64 ) );
                $utf8.= chr( 128 + ( $unicode % 64 ) );
                        
            } else {
                
                $utf8.= chr( 224 + ( ( $unicode - ( $unicode % 4096 ) ) / 4096 ) );
                $utf8.= chr( 128 + ( ( ( $unicode % 4096 ) - ( $unicode % 64 ) ) / 64 ) );
                $utf8.= chr( 128 + ( $unicode % 64 ) );
                
            } // if
            
        } // foreach
    
        return $utf8;
    
    } // unicode_to_utf8


function to_decimal($string){
 
 $entity_to_decimal = array(
	'&nbsp;' => '&#160;',
	'&iexcl;' => '&#161;',
	'&cent;' => '&#162;',
	'&pound;' => '&#163;',
	'&curren;' => '&#164;',
	'&yen;' => '&#165;',
	'&brvbar;' => '&#166;',
	'&sect;' => '&#167;',
	'&uml;' => '&#168;',
	'&copy;' => '&#169;',
	'&ordf;' => '&#170;',
	'&laquo;' => '&#171;',
	'&not;' => '&#172;',
	'&shy;' => '&#173;',
	'&reg;' => '&#174;',
	'&macr;' => '&#175;',
	'&deg;' => '&#176;',
	'&plusmn;' => '&#177;',
	'&sup2;' => '&#178;',
	'&sup3;' => '&#179;',
	'&acute;' => '&#180;',
	'&micro;' => '&#181;',
	'&para;' => '&#182;',
	'&middot;' => '&#183;',
	'&cedil;' => '&#184;',
	'&sup1;' => '&#185;',
	'&ordm;' => '&#186;',
	'&raquo;' => '&#187;',
	'&frac14;' => '&#188;',
	'&frac12;' => '&#189;',
	'&frac34;' => '&#190;',
	'&iquest;' => '&#191;',
	'&Agrave;' => '&#192;',
	'&Aacute;' => '&#193;',
	'&Acirc;' => '&#194;',
	'&Atilde;' => '&#195;',
	'&Auml;' => '&#196;',
	'&Aring;' => '&#197;',
	'&AElig;' => '&#198;',
	'&Ccedil;' => '&#199;',
	'&Egrave;' => '&#200;',
	'&Eacute;' => '&#201;',
	'&Ecirc;' => '&#202;',
	'&Euml;' => '&#203;',
	'&Igrave;' => '&#204;',
	'&Iacute;' => '&#205;',
	'&Icirc;' => '&#206;',
	'&Iuml;' => '&#207;',	
	'&ETH;' => '&#208;',
	'&Ntilde;' => '&#209;', 	
	'&Ograve;' => '&#210;',	
	'&Oacute;' => '&#211;', 	
	'&Ocirc;' => '&#212;',
	'&Otilde;' => '&#213;',	
	'&Ouml;' => '&#214;',
	'&times;' => '&#215;',	
	'&Oslash;' => '&#216;',	
	'&Ugrave;' => '&#217;',	
	'&Uacute;' => '&#218;',	
	'&Ucirc;' => '&#219;',
	'&Uuml;' => '&#220;',
	'&Yacute;' => '&#221;', 	
	'&THORN;' => '&#222;',
	'&szlig;' => '&#223;',	
	'&agrave;' => '&#224;',	
	'&aacute;' => '&#225;',	
	'&acirc;' => '&#226;',
	'&atilde;' => '&#227;',	
	'&auml;' => '&#228;', 	
	'&aring;' => '&#229;',	
	'&aelig;' => '&#230;',	
	'&ccedil;' => '&#231;',	
	'&egrave;' => '&#232;',	
	'&eacute;' => '&#233;',	
	'&ecirc;' => '&#234;',
	'&euml;' => '&#235;',
	'&igrave;' => '&#236;', 	
	'&iacute;' => '&#237;',	
	'&icirc;' => '&#238;',
	'&iuml;' => '&#239;',
	'&eth;' => '&#240;',
	'&ntilde;' => '&#241;', 	
	'&ograve;' => '&#242;',	
	'&oacute;' => '&#243;',	
	'&ocirc;' => '&#244;',
	'&otilde;' => '&#245;',	
	'&ouml;' => '&#246;',
	'&divide;' => '&#247;', 	
	'&oslash;' => '&#248;',	
	'&ugrave;' => '&#249;',	
	'&uacute;' => '&#250;',	
	'&ucirc;' => '&#251;',
	'&uuml;' => '&#252;',
	'&yacute;' => '&#253;', 	
	'&thorn;' => '&#254;',
	'&yuml;' => '&#255;',
	'&fnof;' => '&#402;',
	'&Alpha;' => '&#913;',	
	'&Beta;' => '&#914;',
	'&Gamma;' => '&#915;',	
	'&Delta;' => '&#916;',	
	'&Epsilon;' => '&#917;', 	
	'&Zeta;' => '&#918;',
	'&Eta;' => '&#919;',
	'&Theta;' => '&#920;', 	
	'&Iota;' => '&#921;',
	'&Kappa;' => '&#922;',	
	'&Lambda;' => '&#923;',	
	'&Mu;' => '&#924;',
	'&Nu;' => '&#925;',	
	'&Xi;' => '&#926;',	
	'&Omicron;' => '&#927;', 	
	'&Pi;' => '&#928;',
	'&Rho;' => '&#929;',	
	'&Sigma;' => '&#931;', 	
	'&Tau;' => '&#932;',
	'&Upsilon;' => '&#933;', 	
	'&Phi;' => '&#934;',
	'&Chi;' => '&#935;',
	'&Psi;' => '&#936;',
	'&Omega;' => '&#937;', 	
	'&alpha;' => '&#945;',	
	'&beta;' => '&#946;',
	'&gamma;' => '&#947;',	
	'&delta;' => '&#948;',	
	'&epsilon;' => '&#949;',	 	
	'&zeta;' => '&#950;',
	'&eta;' => '&#951;',
	'&theta;' => '&#952;', 	
	'&iota;' => '&#953;',	
	'&kappa;' => '&#954;', 	
	'&lambda;' => '&#955;',	
	'&mu;' => '&#956;',
	'&nu;' => '&#957;',	
	'&xi;' => '&#958;',	
	'&omicron;' => '&#959;',	 	
	'&pi;' => '&#960;',
	'&rho;' => '&#961;', 	
	'&sigmaf;' => '&#962;',	 	
	'&sigma;' => '&#963;',	
	'&tau;' => '&#964;',	
	'&upsilon;' => '&#965;',	 	
	'&phi;' => '&#966;',
	'&chi;' => '&#967;', 	
	'&psi;' => '&#968;', 	
	'&omega;' => '&#969;', 	
	'&thetasym;' => '&#977;',	 	
	'&upsih;' => '&#978;',
	'&piv;' => '&#982;',	
	'&bull;' => '&#8226;', 	
	'&hellip;' => '&#8230;',	 	
	'&prime;' => '&#8242;',
	'&Prime;' => '&#8243;',	
	'&oline;' => '&#8254;',	
	'&frasl;' => '&#8260;',	
	'&weierp;' => '&#8472;', 	
	'&image;' => '&#8465;',
	'&real;' => '&#8476;',	
	'&trade;' => '&#8482;',	
	'&alefsym;' => '&#8501;',	 	
	'&larr;' => '&#8592;',
	'&uarr;' => '&#8593;',	
	'&rarr;' => '&#8594;',	
	'&darr;' => '&#8595;',	
	'&harr;' => '&#8596;',	
	'&crarr;' => '&#8629;',	
	'&lArr;' => '&#8656;',	
	'&uArr;' => '&#8657;',	
	'&rArr;' => '&#8658;',	
	'&dArr;' => '&#8659;',	
	'&hArr;' => '&#8660;',	
	'&forall;' => '&#8704;',	 	
	'&part;' => '&#8706;',
	'&exist;' => '&#8707;',	
	'&empty;' => '&#8709;',	
	'&nabla;' => '&#8711;',	
	'&isin;' => '&#8712;',	
	'&notin;' => '&#8713;',	
	'&ni;' => '&#8715;',	
	'&prod;' => '&#8719;', 	
	'&sum;' => '&#8721;',	
	'&minus;' => '&#8722;', 	
	'&lowast;' => '&#8727;', 	
	'&radic;' => '&#8730;',
	'&prop;' => '&#8733;',	
	'&infin;' => '&#8734;',	
	'&ang;' => '&#8736;',	
	'&and;' => '&#8743;', 	
	'&or;' => '&#8744;', 	
	'&cap;' => '&#8745;', 	
	'&cup;' => '&#8746;', 	
	'&int;' => '&#8747;', 	
	'&there4;' => '&#8756;',	 	
	'&sim;' => '&#8764;',
	'&cong;' => '&#8773;', 	
	'&asymp;' => '&#8776;',	
	'&ne;' => '&#8800;',	
	'&equiv;' => '&#8801;',	 	
	'&le;' => '&#8804;',	
	'&ge;' => '&#8805;', 	
	'&sub;' => '&#8834;', 	
	'&sup;' => '&#8835;', 	
	'&nsub;' => '&#8836;', 	
	'&sube;' => '&#8838;',	
	'&supe;' => '&#8839;',	
	'&oplus;' => '&#8853;',	
	'&otimes;' => '&#8855;', 	
	'&perp;' => '&#8869;',
	'&sdot;' => '&#8901;',	
	'&lceil;' => '&#8968;',	
	'&rceil;' => '&#8969;',	
	'&lfloor;' => '&#8970;', 	
	'&rfloor;' => '&#8971;', 	
	'&lang;' => '&#9001;',
	'&rang;' => '&#9002;',	
	'&loz;' => '&#9674;',	
	'&spades;' => '&#9824;',	 	
	'&clubs;' => '&#9827;',
	'&hearts;' => '&#9829;', 	
	'&diams;' => '&#9830;',
	'&quot;' => '&#34;',	
	'&amp;' => '&#38;',
	'&lt;' => '&#60;',	
	'&gt;' => '&#62;',	
	'&OElig;' => '&#338;',
	'&oelig;' => '&#339;',	
	'&Scaron;' => '&#352;',	
	'&scaron;' => '&#353;',	
	'&Yuml;' => '&#376;',	
	'&circ;' => '&#710;', 	
	'&tilde;' => '&#732;', 	
	'&ensp;' => '&#8194;',	
	'&emsp;' => '&#8195;',	
	'&thinsp;' => '&#8201;',	 	
	'&zwnj;' => '&#8204;',
	'&zwj;' => '&#8205;',
	'&lrm;' => '&#8206;',	
	'&rlm;' => '&#8207;',	
	'&ndash;' => '&#8211;', 	
	'&mdash;' => '&#8212;',	 	
	'&lsquo;' => '&#8216;',	
	'&rsquo;' => '&#8217;',	
	'&sbquo;' => '&#8218;',	
	'&ldquo;' => '&#8220;',	
	'&rdquo;' => '&#8221;',	
	'&bdquo;' => '&#8222;',	
	'&dagger;' => '&#8224;', 	
	'&Dagger;' => '&#8225;', 	
	'&permil;' => '&#8240;', 	
	'&lsaquo;' => '&#8249;',
	'&rsaquo;' => '&#8250;',
	'&euro;' => '&#8364;');
	
  return preg_replace( 
  	"/&[A-Za-z]+;/", 
	" ", 
	strtr($string,$entity_to_decimal) );
	
}


if(substr($user, 0, 5) == "notes")
{
				$iNumber = 10;
				
				$strNumber = str_replace("notes","",get_param("user"));
				
				if($strNumber != "")
				{
					$iNumber = $strNumber;
				}
				
				if(!is_int($iNumber))
				{
					die("error");
				}
				
				
				
				echo "<?xml version=\"1.0\" ?>\n";
				echo "<rss version=\"2.0\">\n";
				
				echo "<channel>\n";
							
				echo "<title>Latest notes published on ".$BLOG_DOMAIN."</title>\n";
				echo "<link>http://www.".$BLOG_DOMAIN."</link>\n";
				echo "<description> </description>\n";
				
				$tableNotes = DataTable_Query("
				SELECT author_image,html, date, ".$DBprefix."weblog.user, title, ".$DBprefix."notes.id 
				FROM ".$DBprefix."notes,".$DBprefix."weblog,".$DBprefix."admin_users WHERE ".$DBprefix."notes.user=".$DBprefix."weblog.user 
				AND ".$DBprefix."notes.user=".$DBprefix."admin_users.username
				AND category_id<>-1 
				AND active='YES' ORDER BY date DESC LIMIT 0,".$iNumber);
				
				while($arrNote = mysql_fetch_array($tableNotes))
				{
					if(trim($arrNote["title"]) == "")
					{
						continue;
					}
					
					echo "<item>\n";
					echo "<title>".to_decimal(htmlentities(strip_tags(stripslashes($arrNote["title"]))))."</title>\n";
									
					echo "<description>".to_decimal(htmlentities(strip_tags(stripslashes(substr($arrNote["html"],0,200)))))."".(strlen(strip_tags($arrNote["html"]))>=200?"...":"")."</description>\n";
					echo "<link>".htmlspecialchars(CreateLink3($arrNote["user"],'note/'.$arrNote["id"]))."</link>\n";
					echo "</item>\n";		
				
				}
				
				echo "</channel>\n";	
				
				echo "</rss>\n";
}
else
if(substr($user, 0, 8) == "comments")
{
				$iNumber = 10;
				
				$strNumber = str_replace("comments","",get_param("user"));
				
				
				
				if($strNumber != "")
				{
					$iNumber = $strNumber;
				}
				
				if(!is_int($iNumber))
				{
					die("error");
				}
				
				echo "<?xml version=\"1.0\" ?>\n";
				echo "<rss version=\"2.0\">\n";
				
				echo "<channel>\n";
							
				echo "<title>Latest comments published on ".$BLOG_DOMAIN."</title>\n";
				echo "<link>http://www.".$BLOG_DOMAIN."</link>\n";
				echo "<description> </description>\n";
				
				$tableNotes = DataTable_Query("SELECT * FROM ".$DBprefix."comments,".$DBprefix."weblog WHERE ".$DBprefix."comments.user=".$DBprefix."weblog.user ORDER BY date DESC");
				
				while($arrNote = mysql_fetch_array($tableNotes))
				{
					if(trim($arrNote["title"]) == "")
					{
						continue;
					}
					
					echo "<item>\n";
					echo "<title>".to_decimal(htmlentities(strip_tags(stripslashes($arrNote["title"]))))."</title>\n";
									
					echo "<description>".to_decimal(htmlentities(strip_tags(stripslashes(substr($arrNote["html"],0,200)))))."".(strlen(strip_tags(str_replace("&","",$arrNote["html"])))>=200?"...":"")."</description>\n";
					echo "<link>".htmlspecialchars(CreateLink3($arrNote["user"],'note/'.$arrNote["id"]))."</link>\n";
					echo "</item>\n";		
				
				}
				
				echo "</channel>\n";	
				
				echo "</rss>\n";
}
else
if(substr($user, 0, 10) == "categories")
{
				
				
				
				echo "<?xml version=\"1.0\" ?>\n";
				echo "<rss version=\"2.0\">\n";
				
				echo "<channel>\n";
							
				echo "<title>Blog categories on ".$BLOG_DOMAIN."</title>\n";
				echo "<link>http://www.".$BLOG_DOMAIN."</link>\n";
				echo "<description> </description>\n";
				
				
				$table = DataTable("blog_categories","");
				
				
				
				while($line = mysql_fetch_array($table))
				{
					if(trim($line["name_en"]) == "")
					{
						continue;
					}

					echo "<item>\n";
					echo "<title>".to_decimal(htmlentities(stripslashes($line["name_en"])))."</title>\n";
									
					echo "<description> </description>\n";
					echo "<link>http://www.".$BLOG_DOMAIN."/index.php?mod=home&amp;cat=".urlencode($line["name_en"])."</link>\n";
					echo "</item>\n";	
				}
				
				
				echo "</channel>\n";	
				
				echo "</rss>\n";
}
else
if(substr($user, 0, 15) == "user_categories")
{
			
				echo "<?xml version=\"1.0\"  encoding=\"iso-8859-1\" ?>\n";
				echo "<rss version=\"2.0\">\n";
				
				echo "<channel>\n";
							
				echo "<title>Note categories on ".$BLOG_DOMAIN."</title>\n";
				echo "<link>http://www.".$BLOG_DOMAIN."</link>\n";
				echo "<description> </description>\n";
				
				
				$table = DataTable("note_categories","");
				
				
				
				while($line = mysql_fetch_array($table))
				{
					if(trim($line["name"]) == "")
					{
						continue;
					}
								
					echo "<item>\n";
					echo "<title>".to_decimal(htmlentities(strip_tags(stripslashes($line["name"]))))."</title>\n";
									
					echo "<description> </description>\n";
					echo "<link>".htmlspecialchars(CreateLink3($line["user"],'category/'.$line["id"]))."</link>\n";
					echo "</item>\n";	
				}
				
				
				echo "</channel>\n";	
				
				echo "</rss>\n";
}
else
if(substr($user, 0, 5) == "blogs")
{
				
				$iNumber = 10;
				
				$strNumber = str_replace("blogs","",get_param("user"));
								
				if($strNumber != "")
				{
					$iNumber = $strNumber;
				}
				
				if(!is_int($iNumber))
				{
					die("error");
				}
	
				echo "<?xml version=\"1.0\" ?>\n";
				echo "<rss version=\"2.0\">\n";
				
				echo "<channel>\n";
							
				echo "<title>Recently Updated Blogs</title>\n";
				echo "<link>http://www.".$BLOG_DOMAIN."</link>\n";
				echo "<description> </description>\n";
				
				$tableLastBlogs = DataTable_Query("SELECT * FROM ".$DBprefix."admin_users  WHERE username<>'administrator' AND blog_created<>last_update ORDER BY last_update DESC LIMIT 0,".$iNumber);

				while($arrLastBlog = mysql_fetch_array($tableLastBlogs))
				{
				
					echo "<item>\n";
					echo "<title>".$arrLastBlog['username']."</title>\n";
									
					echo "<description>updated on: ".date("d/m h:iA", $arrLastBlog['last_update'])."</description>\n";
					echo "<link>http://".BlogUrl($arrLastBlog["username"])."</link>\n";
					echo "</item>\n";		
			
				}

				echo "</channel>\n";	
				
				echo "</rss>\n";
				
}
else
{

				$arrNoteCategories = DataTable("note_categories","WHERE user='".$user."'");
				
				echo "<?xml version=\"1.0\"  ?>\n";
				echo "<rss version=\"2.0\">\n";
					
				while($arrNoteCategory = mysql_fetch_array($arrNoteCategories))
				{
				
					if(trim($arrNoteCategory["name"]) == "")
					{
							continue;
					}
						
					$bFirstNote = true;
					
					$arrNotes = DataTable("notes","WHERE category_id=".$arrNoteCategory["id"]);
					
					while($arrNote = mysql_fetch_array($arrNotes))
					{
						if(trim($arrNote["title"]) == "")
						{
							continue;
						}
						
						if($bFirstNote)
						{
							echo "<channel>\n";
							
							echo "<title>".to_decimal(htmlentities(strip_tags(stripslashes($arrNote["title"]))))."</title>\n";
							echo "<link>http://www.".$BLOG_DOMAIN."/blog.php?user=".$user."&amp;category=".$arrNote["category_id"]."</link>\n";
							echo "<description> </description>\n";
							
							$bFirstNote = false;
						}
						
									echo "<item>\n";
								    echo "<title>".to_decimal(htmlentities(stripslashes($arrNote["title"])))."</title>\n";
									
									$arrLines = explode(".",strip_tags($arrNote["html"]));
									
								     echo "<description>".to_decimal(htmlentities(strip_tags(stripslashes($arrLines[0]))))." ...</description>\n";
								     echo "<link>http://www.".$BLOG_DOMAIN."/blog.php?user=".$user."&amp;note=".$arrNote["id"]."</link>\n";
								     echo "</item>\n";
					}
					
					if(!$bFirstNote)
					{
						echo "</channel>\n";
					}
						
				}
				
				echo "</rss>\n";

}
        
?>
