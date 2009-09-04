{strip}
<ul>
	{if $gBitUser->hasPermission( 'p_feed_master' )}
		<li><a class="item" href="{$smarty.const.FEED_PKG_URL}index.php">{biticon ipath="pixelmixerbasic" iname="bubble_16" iexplain="`$smarty.const.FEED_PKG_NAME` Activity" ilocation=menu}</a></li>
	{/if}
</ul>
{/strip}
