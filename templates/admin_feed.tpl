<div class="span-24">
	<div class="row">
		<div class="span-4">
			<h2>Content Description</h2>
		</div>

		<div class="span-4">
			<h2>Feed Verb</h2>
		</div>
		<div class="span-4">
			<h2>Remove Target Link</h2>
		</div>
	</div>
	<form action="{$smarty.const.KERNEL_PKG_URI}admin/index.php?page=feed" method="POST">
		
		<input type="hidden" name="page" value="{$smarty.request.page}" />
		{foreach from=$contentTypes item='type'}
			
			<div class="row">
				<div class="span-4">
				{$type.content_type_guid}
				</div>
				<div class="span-4">
				<input type="text" name="{$type.content_type_guid|lower}" value="{$type.conjugation_phrase}"/>{*replace and lower to comply with BW url param standards*}
				</div>
				<div class="span-4">
				<input type="checkbox" name="{$type.content_type_guid|lower}_target" {if $type.is_target_linked == 'f'}checked='true'{/if} />
				</div>
			</div>
		{/foreach}
		 <input type="submit" value="Submit" />
	</form>
</div>
