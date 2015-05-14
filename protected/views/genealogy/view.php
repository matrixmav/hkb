<?php
/* @var $this GenealogyController */
/* @var $model Genealogy */

$regVar  = '';
$treeVar = '/genealogy/';


$this->breadcrumbs=array(
	'Genealogies'=>array('index'),
        "Tree"
);
echo '<link rel="stylesheet" href="'.Yii::app()->getBaseUrl(true).'/css/main.css">';
    echo '<div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tree">
                        <ul>'; 
                            if(count($genealogyListObject) > 0 ){  
                                /* if they have chind with 1st layer */   
                                echo  '<li>';
                                echo  $currentUserId ? '<a href="#" data-hint="This is a success hint that fades in" class="hint-top-s-small-t-notice">'. $currentUserId."</a>" : '';
                                echo '<ul>';
                                foreach($genealogyListObject as $genealogyObject){ 
                                    if($genealogyObject->position == 'left'){ 
                                        $chiId = $genealogyObject->user_id;                        
                                        $leftGenealogyListObject = BaseClass::getGenoalogyTree($chiId);
                                        if(count($leftGenealogyListObject) > 0 ){ 
                                            echo  '<li>';
                                            
                                             $leftCurrnetIdCount = BaseClass::getGenoalogyTree($chiId);  
                                            /* Check for the link */ 
                                            $rightIdCount = count($leftCurrnetIdCount) >= 1 ? $treeVar.'?id='.$genealogyObject->user_id : $regVar ;                                                                                       
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="'.$rightIdCount.'">'. $genealogyObject->user->name."</a>" : '';                                                                                       
                                            echo '<ul>';

                                            foreach($leftGenealogyListObject as $leftGenealogyObject){ 
                                                $leftCurrnetIdCount = BaseClass::getGenoalogyTree($leftGenealogyObject->user_id);      
                                                /* Check for the link */ 
                                                $leftUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $leftGenealogyObject->user->sponsor_id)); 
                                                $rightIdCount = count($leftCurrnetIdCount) >= 1 ? $treeVar.'?id='.$leftGenealogyObject->user->name : $leftUrl ;                                                                                               
                                                                                              
                                                if($leftGenealogyObject->position == 'left'){                                   
                                                    echo $leftGenealogyObject->user_id ? '<li><a href='.$rightIdCount.'>'.$leftGenealogyObject->user->name."</a></li>" : ''; 
                                                }
                                                if($leftGenealogyObject->position == 'right'){              
                                                    echo $leftGenealogyObject->user_id ? '<li><a href='.$rightIdCount.'>'.$leftGenealogyObject->user->name."</a></li>" : '';
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
                                            $leftUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $genealogyObject->user->sponsor_id));
                                            echo  $chiId = $genealogyObject->user_id ? '<a href="'.$leftUrl.'">'. $genealogyObject->user->name."</a>" : '';
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
                                            $rightCurrnetIdCount = BaseClass::getGenoalogyTree($genealogyObject->user_id);  
                                            /* Check for the link */ 
                                            $rightIdCount = count($rightCurrnetIdCount) >= 1 ? $treeVar.'?id='.$genealogyObject->user_id : $regVar ;
                                                                                       
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="'.$rightIdCount.'">'. $genealogyObject->user->name."</a>" : '';
                                            echo '<ul>'; 
                                            foreach($rightGenealogyListObject as $rightGenealogyObject){ 
                                                $rightCurrnetIdCount = BaseClass::getGenoalogyTree($rightGenealogyObject->user_id);      
                                                /* Check for the link */ 
                                                
                                                $rightUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $rightGenealogyObject->user->sponsor_id)); 
                                                $rightIdCount = count($rightCurrnetIdCount) >= 1 ? $treeVar.'?id='.$rightGenealogyObject->user_id : $rightUrl ;                                                                                               
                                                
                                                if($rightGenealogyObject->position == 'left'){                                                     
                                                    echo $rightGenealogyObject->user_id ? '<li><a href='.$rightIdCount.'>'. $rightGenealogyObject->user->name."</a></li>" : '';
                                                }
                                                if($rightGenealogyObject->position == 'right'){                                    
                                                    echo $rightGenealogyObject->user_id ? '<li><a href='.$rightIdCount.'>'. $rightGenealogyObject->user->name."</a></li>" : '';
                                                }                                
                                             }                            
                                         }else{
                                            echo  '<li>';
                                            $rightUrl =  Yii::app()->createUrl('/user/registration', array('spid' => $genealogyObject->user->sponsor_id));
                                            echo  $chiId =  $genealogyObject->user_id ? '<a href="'.$rightUrl.'">'. $genealogyObject->user->name."</a>" : '';
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
?>

<link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true); ?>/css/hint.css">    