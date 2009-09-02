<ul class="data feed">
	{foreach from=$actions item='action'}
		<li class="item">
			{if $action.feed_icon_url}<img src="{$action.feed_icon_url}" alt="{$action.conjugation_phrase|escape}" />{/if} {$action.real_log} on {$action.last_modified|date_format}
		</li>
	{/foreach}
</ul>
