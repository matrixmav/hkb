 <script>
 
	function showColor(oColor) 
	{

		document.getElementById("color").innerHTML = oColor.style.backgroundColor.toUpperCase();
		document.getElementById("color").style.backgroundColor = oColor.style.backgroundColor;

	}

	var strField="";
	var strDIV="";
	
function ShowColorMenu(y){
	if(document.getElementById("ColorsMenu").style.visibility=="hidden"){
		
		strField=y;
		strDIV=y;
		
		document.getElementById("ColorsMenu").style.visibility="visible";
	}
	else{
				
		strField="";
		strDIV="";
		
	}
}

	function doColor(x) {
		
		
		
		//var textBox=eval("document.all."+strField);
		//var oDiv=eval("document.all."+strDIV);
		
		document.getElementById(strDIV).style.color=x;
		document.getElementById(strField).value=x;
				
		document.getElementById("ColorsMenu").style.visibility="hidden";
	}
 </script>
 
  <TABLE
      style="BORDER-RIGHT: buttonshadow 2px solid; BORDER-TOP: buttonhighlight 1px solid; FONT-SIZE: 7px; BORDER-LEFT: buttonhighlight 1px solid; CURSOR: hand; BORDER-BOTTOM: buttonshadow 1px solid; FONT-FAMILY: Verdana"
      borderColor=#666666 cellSpacing=5 cellPadding=1 bgColor=#e7dfe7
      border=1>
        <TBODY>
        <TR>
          <TD id=color
          style="FONT-SIZE: 12px; FONT-FAMILY: verdana; HEIGHT: 20px"
            colSpan=10>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ff0000"
          onmousedown=doColor("#ff0000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ffff00"
          onmousedown=doColor("#ffff00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #00ff00"
          onmousedown=doColor("#00ff00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #00ffff"
          onmousedown=doColor("#00ffff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #0000ff"
          onmousedown=doColor("#0000ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ff00ff"
          onmousedown=doColor("#ff00ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #ffffff"
          onmousedown=doColor("#ffffff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #f5f5f5"
          onmousedown=doColor("#f5f5f5")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #dcdcdc"
          onmousedown=doColor("#dcdcdc")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="WIDTH: 12px; BACKGROUND-COLOR: #fffafa"
          onmousedown=doColor("#fffafa")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #d3d3d3"
          onmousedown=doColor("#d3d3d3")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #c0c0c0"
          onmousedown=doColor("c0c0c0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #a9a9a9"
          onmousedown=doColor("#a9a9a9")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #808080"
          onmousedown=doColor("#808080")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #696969"
          onmousedown=doColor("#696969")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #000000"
          onmousedown=doColor("#000000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #2f4f4f"
          onmousedown=doColor("#2f4f4f")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #708090"
          onmousedown=doColor("#708090")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #778899"
          onmousedown=doColor("#778899")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #4682b4"
          onmousedown=doColor("#4682b4")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #4169e1"
          onmousedown=doColor("#4169e1")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #6495ed"
          onmousedown=doColor("#6495ed")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #b0c4de"
          onmousedown=doColor("#b0c4de")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #7b68ee"
          onmousedown=doColor("#7b68ee")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #6a5acd"
          onmousedown=doColor("#6a5acd")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #483d8b"
          onmousedown=doColor("#483d8b")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #191970"
          onmousedown=doColor("#191970")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #000080"
          onmousedown=doColor("#000080")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00008b"
          onmousedown=doColor("#00008b")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #0000cd"
          onmousedown=doColor("#0000cd")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #1e90ff"
          onmousedown=doColor("#1e90ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00bfff"
          onmousedown=doColor("#00bfff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #87cefa"
          onmousedown=doColor("#87cefa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #87ceeb"
          onmousedown=doColor("#87ceeb")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #add8e6"
          onmousedown=doColor("#add8e6")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #b0e0e6"
          onmousedown=doColor("#b0e0e6")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f0ffff"
          onmousedown=doColor("#f0ffff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #e0ffff"
          onmousedown=doColor("#e0ffff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #afeeee"
          onmousedown=doColor("#afeeee")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00ced1"
          onmousedown=doColor("#00ced1")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #5f9ea0"
          onmousedown=doColor("#5f9ea0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #48d1cc"
          onmousedown=doColor("#48d1cc")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00ffff"
          onmousedown=doColor("#00ffff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #40e0d0"
          onmousedown=doColor("#40e0d0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #20b2aa"
          onmousedown=doColor("#20b2aa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #008b8b"
          onmousedown=doColor("#008b8b")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #008080"
          onmousedown=doColor("#008080")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #7fffd4"
          onmousedown=doColor("#7fffd4")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #66cdaa"
          onmousedown=doColor("#66cdaa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #8fbc8f"
          onmousedown=doColor("#8fbc8f")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #3cb371"
          onmousedown=doColor("#3cb371")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #2e8b57"
          onmousedown=doColor("#2e8b57")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #006400"
          onmousedown=doColor("#006400")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #008000"
          onmousedown=doColor("#008000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #228b22"
          onmousedown=doColor("#228b22")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #32cd32"
          onmousedown=doColor("#32cd32")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00ff00"
          onmousedown=doColor("#00ff00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #7fff00"
          onmousedown=doColor("#7fff00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #7cfc00"
          onmousedown=doColor("#7cfc00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #adff2f"
          onmousedown=doColor("#adff2f")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #98fb98"
          onmousedown=doColor("#98fb98")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #90ee90"
          onmousedown=doColor("#90ee90")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00ff7f"
          onmousedown=doColor("#00ff7f")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #00fa9a"
          onmousedown=doColor("#00fa9a")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #556b2f"
          onmousedown=doColor("#556b2f")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #6b8e23"
          onmousedown=doColor("#6b8e23")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #808000"
          onmousedown=doColor("#808000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #bdb76b"
          onmousedown=doColor("#bdb76b")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #b8860b"
          onmousedown=doColor("#b8860b")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #daa520"
          onmousedown=doColor("#daa520")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffd700"
          onmousedown=doColor("#ffd700")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f0e68c"
          onmousedown=doColor("#f0e68c")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #eee8aa"
          onmousedown=doColor("#eee8aa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffebcd"
          onmousedown=doColor("#ffebcd")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffe4b5"
          onmousedown=doColor("#ffe4b5")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f5deb3"
          onmousedown=doColor("#f5deb3")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffdead"
          onmousedown=doColor("#ffdead")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #deb887"
          onmousedown=doColor("#deb887")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #d2b48c"
          onmousedown=doColor("#d2b48c")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #bc8f8f"
          onmousedown=doColor("#bc8f8f")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #a0522d"
          onmousedown=doColor("#a0522d")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #8b4513"
          onmousedown=doColor("#8b4513")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #d2691e"
          onmousedown=doColor("#d2691e")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #cd853f"
          onmousedown=doColor("#cd853f")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f4a460"
          onmousedown=doColor("#f4a460")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #8b0000"
          onmousedown=doColor("#8b0000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #800000"
          onmousedown=doColor("#800000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #a52a2a"
          onmousedown=doColor(" #a52a2a")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #b22222"
          onmousedown=doColor("#b22222")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #cd5c5c"
          onmousedown=doColor("#cd5c5c")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f08080"
          onmousedown=doColor("#f08080")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fa8072"
          onmousedown=doColor("#fa8072")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #e9967a"
          onmousedown=doColor("#e9967a")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffa07a"
          onmousedown=doColor("#ffa07a")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff7f50"
          onmousedown=doColor("#ff7f50")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff6347"
          onmousedown=doColor("#ff6347")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff8c00"
          onmousedown=doColor("#ff8c00")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffa500"
          onmousedown=doColor("#ffa500")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff4500"
          onmousedown=doColor("#ff4500")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #dc143c"
          onmousedown=doColor("#dc143c")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff0000"
          onmousedown=doColor("#ff0000")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff1493"
          onmousedown=doColor("#ff1493")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff00ff"
          onmousedown=doColor("#ff00ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ff69b4"
          onmousedown=doColor("#ff69b4")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffb6c1"
          onmousedown=doColor("#ffb6c1")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffc0cb"
          onmousedown=doColor("#ffc0cb")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #db7093"
          onmousedown=doColor("#db7093")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #c71585"
          onmousedown=doColor("#c71585")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #800080"
          onmousedown=doColor("#800080")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #8b008b"
          onmousedown=doColor("#8b008b")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #9370db"
          onmousedown=doColor("#9370db")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #8a2be2"
          onmousedown=doColor("#8a2be2")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #4b0082"
          onmousedown=doColor("#4b0082")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #9400d3"
          onmousedown=doColor("#9400d3")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #9932cc"
          onmousedown=doColor("#9932cc")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ba55d3"
          onmousedown=doColor("#ba55d3")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #da70d6"
          onmousedown=doColor("#da70d6")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ee82ee"
          onmousedown=doColor("#ee82ee")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #dda0dd"
          onmousedown=doColor("#dda0dd")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #d8bfd8"
          onmousedown=doColor("#d8bfd8")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #e6e6fa"
          onmousedown=doColor("#e6e6fa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f8f8ff"
          onmousedown=doColor("#f8f8ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f0f8ff"
          onmousedown=doColor("#f0f8ff")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f5fffa"
          onmousedown=doColor("#f5fffa")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #f0fff0"
          onmousedown=doColor("#f0fff0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fafad2"
          onmousedown=doColor("#fafad2")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fffacd"
          onmousedown=doColor("#fffacd")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fff8dc"
          onmousedown=doColor("#fff8dc")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffffe0"
          onmousedown=doColor("#ffffe0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fffff0"
          onmousedown=doColor("#fffff0")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fffaf0"
          onmousedown=doColor("#fffaf0")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #faf0e6"
          onmousedown=doColor("#faf0e6")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fdf5e6"
          onmousedown=doColor("#fdf5e6")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #faebd7"
          onmousedown=doColor(" #faebd7")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffe4c4"
          onmousedown=doColor("#ffe4c4")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffdab9"
          onmousedown=doColor("#ffdab9")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffefd5"
          onmousedown=doColor("#ffefd5")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fff5ee"
          onmousedown=doColor("#fff5ee")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #fff0f5"
          onmousedown=doColor("#fff0f5")>&nbsp;</TD>
          <TD onmouseover=showColor(this)
          style="BACKGROUND-COLOR: #ffe4e1"
          onmousedown=doColor("#ffe4e1")>&nbsp;</TD></TR>
        <TR>
          <TD onmouseover=showColor(this)
          style="FONT-SIZE: 10px; FONT-FAMILY: verdana; HEIGHT: 15px"
          onmousedown=doColor(")
      colSpan=10>&nbsp;None</TD></TR></TBODY>
	  </TABLE>

