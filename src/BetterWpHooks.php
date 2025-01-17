<?php
	
	namespace BetterWpHooks;
	
	use BetterWpHooks\Contracts\EventMapper;
	use BetterWpHooks\Contracts\Dispatcher;
	use BetterWpHooks\Exceptions\ConfigurationException;
	use BetterWpHooks\Mappers\WordpressEventMapper;
	use Contracts\SniccoContainerAdapter;
	use Illuminate\Support\Arr;
	
	class BetterWpHooks {
		
		
		/**
		 * @var SniccoContainerAdapter
		 */
		private $container_adapter;
		
		/**
		 * @var Dispatcher
		 */
		private $dispatcher;
		
		/**
		 * @var WordpressEventMapper
		 */
		private $event_mapper;
		
		private $listen = [];
		private $mapped_events = [];
		
		public function __construct(  SniccoContainerAdapter $container_adapter,  Dispatcher $dispatcher,
			EventMapper $event_mapper ) {
			
			$this->container_adapter = $container_adapter;
			$this->dispatcher        = $dispatcher;
			$this->event_mapper      = $event_mapper;
			
		}
		
		public function listeners( array $listeners = [] ): BetterWpHooks {
			
			$this->listen = $listeners ?? [];
			
			return $this;
			
		}
		
		public function map( array $mapped_events = [] ): BetterWpHooks {
			
			$this->mapped_events = $mapped_events ?? [];
			
			return $this;
			
		}
		
		public function boot() {
			
			
			$this->mapEvents();
			$this->registerListeners();
			
			
		}
		
		public function container(): SniccoContainerAdapter {
			
			return $this->container_adapter;
			
		}
		
		public function dispatcher(): Dispatcher {
			
			return $this->dispatcher;
			
		}
		
		public function swapDispatcher( Dispatcher $new_dispatcher ) {
			
			$this->dispatcher = $new_dispatcher;
			
		}
		
		private function mapEvents() {
			
			try {
				
				foreach ( $this->mapped_events as $hook_name => $mapped_events ) {
					
					foreach ( $mapped_events as $mapped_event ) {
						
						$this->event_mapper->listen( $hook_name, Arr::wrap( $mapped_event ) );
						
					}
					
				}
				
			} catch ( \Throwable $e ) {
				
				throw new ConfigurationException('Invalid Data was provided for event-mapping: ' . $e->getMessage() );
				
			}
			
			
			
			
			
			
		}
		
		private function registerListeners() {
			
			try {
				
				foreach ( $this->listen as $event => $listeners ) {
					
					foreach ( $listeners as $alias => $listener ) {
						
						$this->dispatcher->listen( $event, [ $alias => $listener ] );
						
					}
					
					
				}
				
			}
			
			catch ( \Throwable $e ) {
				
				throw new ConfigurationException('Invalid Data was provided for a listener: ' . $e->getMessage() );
				
			}
			
			
			
		}
		
		
	}