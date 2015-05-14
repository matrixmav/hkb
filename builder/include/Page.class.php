<?php
class Page{
	
	function Page()
	{
		
	}
	
	var $autoTransform=true;
	var $isBlank=false;
	var $templateFile="template.html";
	var $templateHTML="";
	var $pageHTML="";
	var $printMode = false;
	var $arrElements=array("title","menu","content","keywords","description");
	var $arrElementsHTML=array();
	var $templateID=0;
	var $arrPage;
	
	function Load(){
		if($this->templateHTML==""){
			$this->templateHTML=join("",file($this->templateFile));
		}
	}
	
	function LoadPageData(){
		$this->arrElementsHTML["title"]="my title";
		$this->arrElementsHTML["menu"]="<img src=flimages/menu.gif width=540 height=20 border=0>";
		$this->arrElementsHTML["content"]="my data";
	}
	
	function LoadPageDataMySQL($id,$lang){
	
		$this->arrPage=DataArray("pages","id=$id");
		

			
		$this->arrElementsHTML["title"]=stripslashes($this->arrPage["name_".$lang]);
		
		$this->arrElementsHTML["content"]=stripslashes($this->arrPage["html_".$lang]);
		$this->arrElementsHTML["keywords"]=stripslashes($this->arrPage["keywords_".$lang]);
		$this->arrElementsHTML["description"]=stripslashes($this->arrPage["description_".$lang]);
		
	}
	
	
	function LoadPageDataMySQLByPageParam($page)
	{
		global $lang;
		$pos = strpos($page, "_");
		
		if($pos === false) 
		{
			$link=$page;
		}
		else
		{
			list($lang,$link)=explode("_",urldecode($page),2);
		}
		if(trim($lang)=="") {$lang="en";$LANG="EN";}
		$this->arrPage=DataArray("pages","link_".$lang."='".$link."'");
	
			
		$this->arrElementsHTML["title"]=stripslashes($this->arrPage["name_".$lang]);
		$this->arrElementsHTML["keywords"]=stripslashes($this->arrPage["keywords_".$lang]);
		$this->arrElementsHTML["description"]=stripslashes($this->arrPage["description_".$lang]);
		
		$this->arrElementsHTML["content"]=stripslashes($this->arrPage["html_".$lang]);
		$this->templateID = $this->arrPage["template_id"];

	}
	
	function Transform()
	{
		global $mod,$news_id,$cat;
	
		if($this->printMode)
		{
				$this->pageHTML=$this->arrElementsHTML["content"];
		}
		else
		{
			
			$this->pageHTML=$this->templateHTML;
			foreach($this->arrElements as $element)
			{
				if( isset($news_id)&& ($element == "content"||$element=="title"||$element=="description"))
				{
					continue;
				}
				
								
				if( (isset($mod)|| isset($news_id) ) && $element == "content")
				{
					continue;
				}
				
				if( (isset($mod)|| isset($cat) ) && $element == "title")
				{
					continue;
				}
				
							
				global $LANG;
				if($element == "title" && strtolower($LANG) == "bg")
				{
							$this->pageHTML=str_replace
								(
									"<wsa ".$element."/>",
									string2utf8($this->arrElementsHTML[$element]),
									$this->pageHTML
								);
				}
				else
				{
								$this->pageHTML=str_replace
								(
									"<wsa ".$element."/>",
									$this->arrElementsHTML[$element],
									$this->pageHTML
								);
				}
			}		
			
			
			$this->pageHTML=str_replace("../image.php?id=","image.php?id=",$this->pageHTML);
				$this->pageHTML=str_replace(
												"<wsa languages_menu/>",
												GenerateUILanguagesMenu($this->arrPage["id"]),
												$this->pageHTML
											);
			if(aParameter(60) == "NO")
			{
			
			$this->pageHTML=str_replace(
												"</head>",
"<style>
body{font-family:".aParameter(61).";font-size:".aParameter(62).";color:".aParameter(63)."}
a:link{color:".aParameter(64)."}
a:visited{color:".aParameter(65)."}
a:hover{color:".aParameter(66)."}
h1,h2,h3,h4,h5,h6{color:".aParameter(67)."}
</style></head>",
												$this->pageHTML
											);
			}
			
			global $lang;
		
			if(strtolower($lang)=="sa")
			{
				$this->pageHTML=
				str_replace("<html","<html dir=\"rtl\"",$this->pageHTML);
				$this->pageHTML=
				str_replace("_left","_leftZZZ",$this->pageHTML);
				$this->pageHTML=
				str_replace("_right","_left",$this->pageHTML);
				$this->pageHTML=
				str_replace("_leftZZZ","_right",$this->pageHTML);
			}
			
		}
			
	}
	
	function TransformEditable(){
		
		if($this->printMode)
		{
				$this->pageHTML=$this->arrElementsHTML["content"];
		}
		else
		{
				$this->pageHTML=$this->templateHTML;
				
				
				
				foreach($this->arrElements as $element){
				
					if($element=="title"||$element=="menu")
					{
						$this->pageHTML=str_replace(
														"<wsa ".$element."/>",
														"[".strtoupper($element)."]",
														$this->pageHTML
													);
					}
					else{
						$this->pageHTML=str_replace(
														"<wsa ".$element."/>",
														"<div id=\"DIV".$element."\" contenteditable class=\"editableDIV\">".
														$this->arrElementsHTML[$element]
														."</div>",
														$this->pageHTML
													);
					}
				}
		}		
	}
	
	function Refresh(){
		$this->Load();
		$this->LoadPageData();
		$this->Transform();
	}
	
	function HTML(){
		echo $this->pageHTML;
	}
	
	function Render(){
		if($this->autoTransform){
			$this->Load();
			$this->LoadPageData();
			$this->Transform();
		}
		echo $this->pageHTML;
	}
	
	function MakeEditable(){
			$this->Load();
			$this->LoadPageData();
			$this->TransformEditable();
			echo $this->pageHTML;
	}
	
}
?>
