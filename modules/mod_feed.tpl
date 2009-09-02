<div class="span-8" style="margin-top:10px;">
	{foreach from=$actions item='action'}
		<div>
			{if $action.feed_icon_url}<img src="{$action.feed_icon_url}" alt="{$action.conjugation_phrase|escape}" />{/if} {$action.real_log} on {$action.last_modified|date_format}
		</div>
	{/foreach}
</div>
