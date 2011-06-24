<form action='#' method='post'>
	<?php if($_['htaccessWorking']):?>
		<?php echo $l->t( 'Maximum upload size' ); ?> <input name='maxUploadSize' value='<?php echo $_['uploadMaxFilesize'] ?>'/><br/>
	<?php endif;?>
	<input type="checkbox" name="publicFolders"<?php echo ($_['publicFolders']=='on'?' checked':'');?> onclick="
		if(this.checked){
			document.getElementById('publicFolderOptions').style.display='block';
		} else {
			document.getElementById('publicFolderOptions').style.display='none';
		}
		"/> <?php echo $l->t( 'Allow public folders' ); ?><br>

	<div id="publicFolderOptions" style="display:<?php echo ($_['publicFolders']=='on'?'block':'none');?>;margin-left:50px">
		<input type="radio" name="sharingaim" value="1"<?php echo($_['sharingaim']==1?' checked':'');?> />
		<?php echo $l->t( 'separated from webdav storage' ); ?><br>
		<input type="radio" name="sharingaim" value="2"<?php echo($_['sharingaim']==2?' checked':'');?> />
		<?php echo $l->t( 'let the user decide' ); ?><br>
		<input type="radio" name="sharingaim" value="3"<?php echo($_['sharingaim']==3?' checked':'');?> />
		<?php echo $l->t( 'folder "/public" in webdav storage' ); ?><br>
	</div>

	<input type="checkbox" name="allowDl"<?php echo ($_['allowDl']=='on'?' checked':'');?>/>
	<?php echo $l->t( 'Allow downloading shared files' ); ?><br>
	<input type="checkbox" name="sharedUl"<?php echo ($_['sharedUl']=='on'?' checked':'');?>/>
	<?php echo $l->t( 'Allow uploading in shared directory' ); ?><br>
	<input type='submit' value='Save'/>
</form>
