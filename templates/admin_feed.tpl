	<form action="{$smarty.const.KERNEL_PKG_URI}admin/index.php?page=feed" method="POST">
		
	<input type="hidden" name="page" value="{$smarty.request.page}" />
	<div class="control-group">
		<div class="col-md-4"> <h2>Content Description</h2> </div>
		<div class="col-md-4"> <h2>Feed Verb</h2> </div>
		<div class="col-md-4"> <h2>Remove Target Link</h2> </div>
	</div>
{foreach from=$contentTypes item='type' key=contentTypeGuid}
	<div class="row clear">
		<div class="col-md-4">
			{$contentTypeGuid}
		</div>
		<div class="col-md-4">
			<input type="text" name="{$contentTypeGuid|lower}[conjugation_phrase]" value="{$type.conjugation_phrase}"/>{*replace and lower to comply with BW url param standards*}
		</div>
		<div class="col-md-4">
			<input type="checkbox" name="{$contentTypeGuid|lower}[is_target_linked]" {if $type.is_target_linked == 'f'}checked='true'{/if} />
		</div>
	</div>
{/foreach}
	<div class="control-group submit clear">
		 <input type="submit" class="btn" name="store_feed" value="Submit" />
	</div>
	</form>
