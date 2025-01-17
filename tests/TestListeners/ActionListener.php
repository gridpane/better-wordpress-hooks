<?php
	
	namespace Tests\TestListeners;
	
	use Tests\TestDependencies\SimpleMethodDependency;
	use Tests\TestEvents\ConditionalEvent;
	use Tests\TestDependencies\Dependency;
	use Tests\Exceptions\DidAction;
	use Tests\StackInfo;
	
	class ActionListener {
		
		use StackInfo;
		
		public function foobar( $foo ) {
			
			throw new DidAction( $this->getStackInfo(), $foo . 'bar' );
			
		}
		
		public function handleEvent( $foo ) {
			
			throw new DidAction( $this->getStackInfo(), $foo . '_handled' );
			
		}
		
		public function noArgs() {
			
			throw new DidAction( $this->getStackInfo(), 'Executed without arguments.' );
			
		}
		
		public function conditionalEvent( ConditionalEvent $event ) {
			
			throw new DidAction( $this->getStackInfo(), $event->name );
			
		}
		
		public function methodWithDependency( Dependency $dependency ) {
			
			
		}
		
		public function foobarbiz( string $foo, string $bar, string $biz, SimpleMethodDependency $dependency ) {
			
			throw new DidAction( $this->getStackInfo(), $foo . $bar . $biz . $dependency->name );
			
			
		}
		
	}