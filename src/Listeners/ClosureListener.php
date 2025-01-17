<?php
	
	namespace BetterWpHooks\Listeners;
	
	use BetterWpHooks\Contracts\AbstractListener;
	use BetterWpHooks\Traits\ReflectsCallable;
	use Contracts\SniccoContainerAdapter;
	
	class ClosureListener extends AbstractListener {
		
		use ReflectsCallable;
		
		/**
		 * @var \Closure
		 */
		private  $closure;
		
		/**
		 * @var \Contracts\SniccoContainerAdapter
		 */
		private  $container;
		
		public function __construct( \Closure $closure, SniccoContainerAdapter $container) {
			
			$this->closure = $closure;
			$this->container = $container;
			
		}
		
		public function toArray(): array {
			
			return [
				
				$this->closure,
				NULL,
			
			];
			
		}
		
		public function execute( $payload ) {
			
			$closure = $this->closure;
			
			return $this->container->call( $closure , $this->buildParameterNames(  $closure , $payload) );
			
			
		}
		
		public function aliases(): array {
			
			return [ spl_object_hash( $this->closure ) ];
			
		}
		
		public function shouldHandle( $payload ): bool {
			
			return TRUE;
			
		}
		
		
		
	}