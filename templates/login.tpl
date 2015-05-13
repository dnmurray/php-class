	<div class="text-center">
	  <h2>Bates Motel</h2>
	  <h4>User Login</h4>
      {$messages}
	  <form method="POST" action="login.php">
		<p class="username">
		  <label for="username">Username:</label>
		  <input type="text" id="username" name="username" />
		</p>
		<p>
		  <label for="password">Password:</label>
		  <input type="password" id="password" name="password" />
		</p>
		<p>
		  <input type="submit" name="login" value="Login" />
		</p>
        {if $redirect}
		  <input type="hidden" name="redirect" value="{$redirect}" />
        {/if}
		<?php endif; ?>
	  </form>
	</div>
