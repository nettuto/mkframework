<?php 
$sFileType=null;
$sModule=null;
if(_root::getParam('type')){
		$sFileType=_root::getParam('type');
		if(preg_match('/module::/',$sFileType)){
			list($sFileType,$sFileModule)=preg_split('/::/',$sFileType);
		}
}


$tDoc=array(
'abstract_model'	=>'classabstract__model',
'abstract_module'	=>'classabstract__module',


'_root'	=>'class__root',
'_cache'	=>'class__cache',
'_request'	=>'class__request',
'_layout'	=>'class__layout',
'_view'		=>'class__view',
'_file'		=>'class__file',
'_dir'		=>'class__dir',

'plugin_auth'	=> 'classplugin__auth',
'plugin_check'	=>'classplugin__check',
'plugin_date'	=>'classplugin__date',
'plugin_datetime'	=>'classplugin__datetime',
'plugin_gestionuser'	=>'classplugin__gestionuser',
'plugin_html'	=>'classplugin__html',
'plugin_i18n'	=>'classplugin__i18n',
'plugin_jquery'	=>'classplugin__jquery',
'plugin_log'	=>'classplugin__log',
'plugin_mail'	=>'classplugin__mail',
'plugin_rss'	=>'classplugin__rss',
'plugin_upload'	=>'classplugin__upload',	
'plugin_valid'	=>'classplugin__valid',
'plugin_xsrf'	=>'classplugin__xsd',

);

$tLine=$this->oFile->getTab();

$sCode=highlight_string($this->oFile->getContent(),true);
$tCode=explode('<br />',$sCode);
?>
<!--<h1><?php if(_root::getParam('type')):?>[<?php echo _root::getParam('type')?>][<?php echo $this->oFile->getName()?>] <?php endif;?><span style="font-weight:regular;font-size:14px;color:#444"><?php echo $this->oFile->getAdresse()?> </span></h1>-->
<script>
window.parent.setTitle('<?php if(_root::getParam('type')):?>[<?php echo _root::getParam('type')?>][<?php echo $this->oFile->getName()?>] <?php endif;?>','<?php echo $this->oFile->getAdresse()?>');
</script>
<?php $tColor=array('#fff','#eee')?>

<?php $sGoTo=null?>

<?php 
$tFunction=null;
foreach($tLine as $i => $line):
	$iLine=sprintf('%06d',($i+1));
	if(preg_match('/function/',$line) ):
		list($sType,$sMethod)=preg_split('/function/',$line);
		$sMethod=preg_replace('/{/','',$sMethod);
		$tFunction[$sMethod]=array(
						'method' => $sMethod,
						'type' => $sType,
						'line' => $iLine,
					);
	endif;
endforeach;
?>


<?php 
if($tFunction):?>
<div class="fonctions">
	<?php 
	ksort($tFunction);
	foreach($tFunction as $tMethod){
			 
		$iLine=$tMethod['line'];
		$sType=$tMethod['type'];
		$sMethod=$tMethod['method'];
		 ?>
		<a href="#num<?php echo $iLine?>"><i>function</i><?php echo $sMethod?><sup style="color:gray;font-size:9px"><?php echo $sType?></sup></a><br />
		<?php 
		if(preg_match('/function '._root::getParam('method').'\(/',$line)){
			$sGoTo='document.location.href="#num'.$iLine.'";';
		}
			
	}?>
</div>
<?php endif;?>



<table>
	</table>
<?php foreach($tCode as $i=>$sCode):?>
	<?php if(!isset($tLine[$i])){ break; }?>
	<?php $sCodeOriginal=$tLine[$i];?>
	<?php $iLine=sprintf('%06d',($i+1));
	
	if($i%2){ $j=1; }else{$j=0;}
	
	foreach($tDoc as $sDoc => $sClassDoc){
		if(preg_match('/'.$sDoc.'/',$sCode)){
				$sCode=preg_replace('/'.$sDoc.'/','<a class="helpDoc" href="#" onclick="help(\''.$sClassDoc.'\');return false;">'.$sDoc.'</a>',$sCode);
				
				if($sDoc=='_view'){
					preg_match('/'.$sDoc.'\(([\w:\'"]*)/',$sCodeOriginal,$tFound);
					if($tFound and isset($tFound[1])){
						$sViewToReplace=$tFound[1];
						$sViewToReplace=preg_replace('/\'/','',$sViewToReplace);
						list($sModule,$sView)=preg_split('/::/',$sViewToReplace);
						$sCode=preg_replace('/'.$sViewToReplace.'/','<a class="goto" href="#" onclick="gotofileandtype(\'module/'.$sModule.'/view/'.$sView.'.php\',\'view\');return false;">'.$sViewToReplace.'</a>',$sCode);
					}
				}
		}
	}
	
	//module
	foreach($this->tModule as $sModule){
		if(!preg_match('/module\/'.$sModule.'\/main/',_root::getParam('file')) and preg_match('/module_'.$sModule.'/',$sCode)){
			$sCode=preg_replace('/module_'.$sModule.'/','<a class="goto" href="#" onclick="gotofileandtype(\'module/'.$sModule.'/main.php\',\'module\');return false;">module_'.$sModule.'</a>',$sCode);
		}
	}
	
	//model
	foreach($this->tModel as $sModel){
		if(!preg_match('/model\/'.$sModel.'/',_root::getParam('file')) and preg_match('/'.$sModel.'[^\w]/',$sCodeOriginal)){
			
			$sCode=preg_replace('/'.$sModel.'/','<a class="goto" href="#" onclick="gotofileandtype(\'model/'.$sModel.'.php\',\'model\');return false;">'.$sModel.'</a>',$sCode);
			
			$sPattern='/'.$sModel.'::getInstance\(\)->([\w\-]*)\(/';
			preg_match($sPattern,$sCodeOriginal,$tFind);
			if(isset($tFind[1])){
				$sMethod=$tFind[1];
				$sCode=preg_replace('/'.$sMethod.'/','<a class="goto" href="#" onclick="gotofileandmethod(\'model/'.$sModel.'.php\',\'model\',\''.$sMethod.'\');return false;">'.$sMethod.'</a>',$sCode);
			}
		}
	}
	?>
	<a id="num<?php echo $iLine?>" name="num<?php echo $iLine?>"  class="btn" href="#" onclick="editLine('<?php echo $iLine?>');return false;">[EDITER]</a>&nbsp;<span style="background:#fff;color:#444"><?php echo $iLine?>&nbsp;&nbsp;</span><?php echo $sCode?><br/>
	<form style="display:none;" id="line<?php echo $iLine?>" method="POST" action="#num<?php echo $iLine?>"><a class="btn" style="color:red" href="#" onclick="closeEditLine()">[FERMER]</a>&nbsp;<span style="background:#fff;color:#eee"><?php echo $iLine?>&nbsp;&nbsp;</span><input type="hidden" name="iLine" value="<?php echo $iLine?>"/><textarea style="border:0px;background:#ddd;width:600px;height:30px" name="content" id="content<?php echo $iLine?>" ><?php echo $tLine[(int)$iLine-1]?></textarea><input type="submit" value="Enregistrer"/>
	<?php if($sFileType=='module'):?>
		<p style="text-align:center">
			<a href="#" onclick="addContent('<?php echo $iLine?>','addAction')">Ajouter une action</a> 
			| 
			<a href="#" onclick="addContent('<?php echo $iLine?>','addView',Array('<?php echo $sFileModule?>','mavue'))">Appel d'une vue</a>
		</p>
	<?php else:?>
		
	<?php endif;?>
	</form>
	<hr/>
	
<?php endforeach;?>
<?php if($sGoTo!=''):?>
<script><?php echo $sGoTo?></script>
<?php endif;?>

