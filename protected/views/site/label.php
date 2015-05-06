<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<!--  <h1>Welcome to <i><?php //echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php //echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php //echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>-->

		<div class="page-content">
			<!-- <div class="row" style="background-color:#f5f5f5;padding:20px 0 20px 0;margin:-20px -15px 20px -15px;height:80px;">
				<div class="col-md-12">
					<form class="form-inline" role="form">
						<div class="form-group">
							<select class="form-control select2me" data-placeholder="Catégories d'article">
								<option></option>								
								<option value="">News (32)</option>
								<option value="">Articles populaires (28)</option>
								<option value="">Ambiance (110)</option>
								<option value="">Cuisine (90)</option>
								<option value="">Les tops (220)</option>
								<option value="">Les flops (10)</option>
								<option value="">Interviews (0)</option>
							</select>
						</div>
						<div class="form-group">
							<select class="form-control select2me" data-placeholder="Toute la France">
								<option></option>								
								<option>Alsace (32)</option>
								<option>Aquitaine (8)</option>
								<option>Auvergne (5)</option>
								<option>Basse-Normandie</option>
								<option>Bourgogne</option>
								<option>Bretagne</option>
								<option>Centre</option>
								<option>Champagne-Ardenne</option>
								<option>Corse</option>
								<option>Franche-Comté</option>
								<option>Haute-Normandie</option>
								<option>Île-de-France</option>
								<option>Languedoc-Roussillon</option>
								<option>Limousin</option>
								<option>Lorraine</option>
								<option>Midi-Pyrénées</option>
								<option>Nord-Pas-de-Calais</option>
								<option>Pays de la Loire</option>
								<option>Picardie</option>
								<option>Poitou-Charentes</option>
								<option>Provence-Alpes-Côte d'Azur</option>
								<option>Rhône-Alpes</option>
							</select>
						</div>
						<div class="form-group">
							<select class="form-control select2me input-small" data-placeholder="Auteur">
								<option></option>								
								<option value="">Arnaud (220)</option>
								<option value="">Sébastien (110)</option>
								<option value="">Léa (45)</option>
							</select>
						</div>
						<div class="form-group">
							<select class="form-control select2me" data-placeholder="Date publication">
								<option></option>								
								<option value="">Mars 2013 (65)</option>
								<option value="">Février 2013 (56)</option>
								<option value="">Janvier 2013 (0)</option>
								<option value="">Décembre 2012 (4)</option>
							</select>
						</div>
						<div class="form-group">
							<a href="#" class="btn btn green"><i class="fa fa-filter"></i> Filtrer</a>
							<a href="#" class="btn btn default"><i class="fa fa-undo"></i></a>
						</div>
						<div class="form-group" style="width:200px;margin-left:20px">
							<select class="bs-select form-control">
								<option>Actions groupées</option>								
								<option value="">Publier</option>
								<option value="">Passer en brouillon</option>
								<option value="">Passer en "attente relecture"</option>
								<option value="">Déplacer vers la corbeille</option>
								<option value="">Supprimer définitivement</option>
							</select>
						</div>
						<div class="form-group">
							<a href="#" class="btn green"><i class="fa fa-check"></i></a>
						</div>
					</form>
				</div>
			</div> -->
			<div class="row">
				<form action="" name="labels_form">
					Label: &nbsp;<input type="text" name="text1"><br><br>
					Lien:&nbsp;  <input type="text" name="text2"><br><br>
					<input type="button" name="button1" value="ok"><br><br>
				</form>
			</div>
			<div class="row">
				<div class="col-md-12">

					<table class="table table-striped table-bordered table-hover table-full-width" id="sample_2">
						<thead>
							<tr>
								<th><input type="checkbox"></th>
								<th class="hidden-xs">Titre</th>
								<th class="hidden-xs">Catégories</th>
								<th class="hidden-xs">Région</th>
								<th>Date</th>
								<th class="hidden-xs"></th>
							</tr>	
						</thead>
						<tbody>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Les meilleurs restaurants romantiques de Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">12</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Ambiances</span> <span class="badge badge-info badge-roundless">Top</span>  <span class="badge badge-info badge-roundless">Atmosphère</span> <a href="#" class="tooltips" data-placement="right" data-original-title="Populaire" style="margin-left:5px;"><span class="badge badge-primary"><i class="fa fa-bullhorn" style="margin-top:-1px"></i></span></a> <span class="badge badge-primary">News</span>	</td>
								<td>Pays-de-la-Loire
								</td>
								<td>02/03/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>-
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
							<tr>
								<td><input type="checkbox"></td>
								<td><a href="#" class="tooltips" data-placement="bottom" data-original-title="Editer l'article">Où manger les meilleurs et moins chers burgers à Paris</a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="12 restaurants cités dans l'article"><span class="badge badge-default" style="margin:0px 0 3px 5px;">8</span></a> <a href="#" class="tooltips" data-placement="bottom" data-original-title="Afficher l'article"><span style="margin:4px 0 0px 5px;"><i class="fa fa-external-link"></i></span></a></td>
								<td><span class="badge badge-info badge-roundless">Tendance</span> <span class="badge badge-info badge-roundless">Top</span></td>
								<td>Ile-de-France
								</td>
								<td>13/01/2014</td>
								<td><a href="#" class="tooltips" data-placement="left" data-original-title="5 commentaires" style="margin-left:5px;"><span class="badge badge-default">5 <i class="fa fa-comment" style="margin-top:-1px"></i></span></a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>