<table class="tb_list">
	<tr>
		<?php //icith?>
		<th></th>
	</tr>
	<?php if($this->tExamplemodel):?>
	<?php foreach($this->tExamplemodel as $oExamplemodel):?>
	<tr <?php echo plugin_tpl::alternate(array('','class="alt"'))?>>
		<?php //ici?>
		<td>
			
			<?php //links?>
			
			
		</td>
	</tr>	
	<?php endforeach;?>
	<?php endif;?>
</table>
<?php //linknew?>

<?php/*variables
#lignetd
		<td>exampletd</td>
#fin_lignetd

#ligneth
		<th>exampleth</th>
#fin_ligneth

#input<?php echo $oExamplemodel->examplecolumn ?>#fin_input
#textarea<?php echo $oExamplemodel->examplecolumn ?>#fin_textarea
#select<?php if(isset($this->tJoinexamplemodel[$oExamplemodel->examplecolumn])){ echo $this->tJoinexamplemodel[$oExamplemodel->examplecolumn];}else{ echo $oExamplemodel->examplecolumn ;}?>#fin_select
#upload<?php echo $oExamplemodel->examplecolumn ?>#fin_upload

#linkEdit
<a href="<?php echo $this->getLink('examplemodule::edit',array(
										'id'=>$oExamplemodel->getId()
									) 
							)?>">Edit</a>
linkEdit#

#linkShow
<a href="<?php echo $this->getLink('examplemodule::show',array(
										'id'=>$oExamplemodel->getId()
									) 
							)?>">Show</a>
linkShow#

#linkDelete
<a href="<?php echo $this->getLink('examplemodule::delete',array(
										'id'=>$oExamplemodel->getId()
									) 
							)?>">Delete</a>
linkDelete#

#linkNew
<p><a href="<?php echo $this->getLink('examplemodule::new') ?>">New</a></p>
linkNew#





variables*/?>
