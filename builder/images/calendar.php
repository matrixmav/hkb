<?php
include("../blog_config.php");

function get_param($param_name)
{
  global $_POST;
  global $_GET;

  $param_value = "";
  if(isset($_POST[$param_name]))
    $param_value = $_POST[$param_name];
  else if(isset($_GET[$param_name]))
    $param_value = $_GET[$param_name];

  return $param_value;
}
?>


<?php
if(get_param("lang") == "fr")
{
?>
var day_of_week = new Array('Lun','Mar','Mer','Jeu','Ven','Sam','Dim');
var month_of_year = new Array('Janvier','Fevrier','Mars','Avril','Mai','Juin','Juillet','Aout','Septembre','Octobre','Novembre','Decembre');
<?php
}
else
{
?>
var day_of_week = new Array('Mon','Tue','Wed','Thu','Fri','Sat','Sun');
var month_of_year = new Array('January','February','March','April','May','Junu','July','August','September','October','November','December');
<?php
}
?>


function IsNoteDay(x)
{
	for(var i=0;i<note_days.length;i++)
	{
		if(note_days[i] == x)
		{
			return true;
		}
	}
	
	return false;
}

var Calendar = new Date();

<?php
if(get_param("year2") != "")
{

?>  
var year = <?php echo get_param("year2");?>;   
<?php
}
else
{
?>
var year = <?php echo date("Y");?>;   
<?php
}
?>


<?php
if(get_param("month") != "")
{
?>   
var month = <?php echo get_param("month");?>;   
<?php
}
else
if(get_param("month2") != "")
{
?>   
var month = <?php echo get_param("month2");?>;   
<?php
}
else
{
?>
var month = Calendar.getMonth();   
<?php
}
?>

var today = Calendar.getDate();    
var weekday = Calendar.getDay()-1;    

var DAYS_OF_WEEK = 7;    
var DAYS_OF_MONTH = 31;    
var cal;   

Calendar.setDate(1);   
Calendar.setMonth(month);    


var TR_start = '<TR>';

var TR_end = '</TR>';

var highlight_start = '<TD WIDTH="30"><TABLE <?php if(get_param("month2") == (date("n")-1)) echo 'style="border-style:solid;border-color:red;border-width:1px 1px 1px 1px"';?> ><TR><TD WIDTH=20 style="font-size:9px"><B><CENTER>';

var highlight_end   = '</CENTER></TD></TR></TABLE></B>';


var TD_start = '<TD WIDTH="30" style="font-size:9px"><CENTER>';

var TD_end = '</CENTER></TD>';



cal =  '<TABLE ><TR><TD style="font-size:9px">';
cal += '<TABLE width=140 style="border-style:solid;border-color:black;border-width:1px 1px 1px 1px" CELLSPACING=0 CELLPADDING=2>' + TR_start;

cal += '<TD COLSPAN="' + DAYS_OF_WEEK + '" BGCOLOR="#EFEFEF" style="font-size:9px"><CENTER>';

if(month == 0)
{
	cal += '<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user='+user+'&month2=11&year2='+(year-1)+'><<</a>';
}
else
{
	cal += '<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user='+user+'&month2='+(month-1)+'&year2='+(year)+'><<</a>';
}


cal += '&nbsp;<B>' + month_of_year[month] +'&nbsp;'+ year;

if(month == 11)
{
	cal += '  </B> &nbsp;<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user='+user+'&month2=0&year2='+(year+1)+'>>></a>' + TD_end + TR_end;
}
else
{
	cal += '  </B> &nbsp;<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user='+user+'&month2='+(month+1)+'&year2='+(year)+'>>></a>' + TD_end + TR_end;
}




cal += TR_start ;

for(index=0; index < DAYS_OF_WEEK; index++)
{
		if(weekday == index)
		cal += TD_start + '<B>' + day_of_week[index] + '</B>' + TD_end;
		else
		cal += TD_start + day_of_week[index] + TD_end;
}

cal += TR_end;
cal += TR_start;


<?php
$iWeek = date("w", mktime(0, 0, 0, (get_param("month2")!=""?(get_param("month2")+1):date("n") )  , 1, date("Y")));
if($iWeek == 0) $iWeek = 7;
$iWeek--;
?>
for(index=0; index < <?php echo $iWeek;?>; index++)
{
	cal += TD_start + '  ' + TD_end;
}


for(index=0; index < DAYS_OF_MONTH; index++)
{
if( Calendar.getDate() > index )
{

  week_day =Calendar.getDay()
  -1;

 
  if(week_day == 0)
  cal += TR_start;

  if(week_day != DAYS_OF_WEEK)
  {


  var day  = Calendar.getDate();


  if( today==Calendar.getDate() )
  {
  
  
	 
	  
	  if(IsNoteDay(day))
		{
	  		
			 cal += highlight_start + "<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user="+user+"&month2="+month+"&note_day="+day+"&year2="+year+"><b>" + day + "</b></a>"  + highlight_end + TD_end;
		}
		else
		{
			 cal += highlight_start + day + highlight_end + TD_end;
		}
	  
	  
	}
	
	  else
	  {
	  	if(IsNoteDay(day))
		{
	  		cal += TD_start + "<a href=<?php echo "http://www.".$BLOG_DOMAIN."/";?>blog.php?user="+user+"&month2="+month+"&note_day="+day+"&year2="+year+"><b>" + day + "</b></a>" + TD_end;
		}
		else
		{
			cal += TD_start + day + TD_end;
		}
	  }
  }


 if(week_day == DAYS_OF_WEEK)
  cal += TR_end;
  }


  Calendar.setDate(Calendar.getDate()+1);

}

cal += '</TD></TR></TABLE></TABLE>';


document.write(cal);

