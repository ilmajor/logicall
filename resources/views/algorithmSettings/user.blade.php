<li class="list-group-item">
	<a href="/lk/users/{{ $user->id }}">
		<?php
		echo $user->UserName;
		echo ' | ';
		echo $user->lg;
		echo ' | ';
		echo $user->id;
		if ($user->Operator != '0') {
			echo ' | ';
			echo $user->Operator;
		}
		if ($user->manager != '0') {
			echo ' | ';
			echo $user->manager;
		}
		if ($user->admin != '0') {
			echo ' | ';
			echo $user->admin;
		}
		echo ' | ';
		echo $user->operatorStatus;
		echo ' | ';
		echo $user->number;

		?>
		
	</a>
</li>

