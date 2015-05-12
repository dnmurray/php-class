		<div class="text-center">
			<h1>Welcome to the Bates Motel</h1>
			<h4>You check in, but you don't checkout.</h4>

			<ul>
				{foreach $options as $option}
					<li><a href="{$option['href']}">{$option['desc']}</a></li>
				{/foreach}
			</ul>
		</div>
