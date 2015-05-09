<?php
/* @var $this GenealogyController */
/* @var $model Genealogy */

$this->breadcrumbs=array(
	'Genealogies'=>array('index'),
        "Tree"
);
echo '<link rel="stylesheet" href="http://hkbase.dev/css/main.css">';
    echo '<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tree">
                        <ul>'; 
                              if(count($genealogyListObject) > 0 ){  
                                /* if they have chind with 1st layer */   
                                echo  '<li>';
                                echo  $currentUserId ? '<a href="#">'. $currentUserId."</a>" : '';
                                echo '<ul>';
                                foreach($genealogyListObject as $genealogyObject){ 
                                    if($genealogyObject->position == 'left'){ 
                                        $chiId = $genealogyObject->user_id;                        
                                        $rightGenealogyListObject = BaseClass::getGenoalogyTree($chiId);
                                        if(count($rightGenealogyListObject) > 0 ){ 
                                            echo  '<li>';
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="#">'. $genealogyObject->user_id."</a>" : '';
                                            echo '<ul>';

                                            foreach($rightGenealogyListObject as $rightGenealogyObject){ 
                                                $rightUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $rightGenealogyObject->user_id)); 
                                                if($rightGenealogyObject->position == 'left'){                                   
                                                    echo $rightGenealogyObject->user_id ? '<li><a href='.$rightUrl.'>'.$rightGenealogyObject->user_id."</a></li>" : ''; 
                                                }
                                                if($rightGenealogyObject->position == 'right'){              
                                                    echo $rightGenealogyObject->user_id ? '<li><a href='.$rightUrl.'>'.$rightGenealogyObject->user_id."</a></li>" : '';
                                                 }                                
                                            }
                                        echo'</ul>
                                        </li>';
                                        echo '
                                        </ul>
                                            </li>
                                       </li>'; 

                                        }else{
                                            echo  '<li>';
                                            echo  $chiId = $genealogyObject->user_id ? '<a href="#">'. $genealogyObject->user_id."</a>" : '';
                                            echo '<ul>'; 
                                        echo '
                                        </ul>
                                        </li>
                                   </li>'; 
                                         }                                                
                                     } else{ //echo "right";exit;
                                         $chiId = $genealogyObject->user_id; 
                                         $rightGenealogyListObject = BaseClass::getGenoalogyTree($chiId);
                                         if(count($rightGenealogyListObject) > 0 ){ 
                                            echo  '<li>';
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="#">'. $genealogyObject->user_id."</a>" : '';
                                            echo '<ul>'; 
                                            foreach($rightGenealogyListObject as $rightGenealogyObject){ 
                                                $rightUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $rightGenealogyObject->user_id)); 
                                                 if($rightGenealogyObject->position == 'left'){
                                                     
                                                     echo $rightGenealogyObject->user_id ? '<li><a href='.$rightUrl.'>'. $rightGenealogyObject->user_id. "--".$rightGenealogyObject->position  ."</a></li>" : '';
                                                 }
                                                 if($rightGenealogyObject->position == 'right'){                                    
                                                     echo $rightGenealogyObject->user_id ? '<li><a href='.$rightUrl.'>'. $rightGenealogyObject->user_id."</a></li>" : '';
                                                 }                                
                                             }                            
                                         }else{
                                            echo  '<li>';
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="#">'. $genealogyObject->user_id."</a>" : '';
                                            echo '<ul>'; 
                                         }  
                                      echo '
                                        </ul>
                                            </li>
                                       </li>';    

                                    }                    
                                 }                
                             }
                        echo '</ul>
                    </div>
                </div>
            </div>
        </div>';          

