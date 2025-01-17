<?php
	
	namespace Tests\TestEvents;
	
	use BetterWpHooks\Traits\DispatchesConditionally;
	
	class ConditionalEvent {
		
		use DispatchesConditionally;
		
		public function shouldDispatch(): bool {
			
			return $_SERVER['dispatch'] ?? FALSE;
			
		}
		
	}