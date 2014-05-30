<?php namespace GlobalTechnology\GlobalRegistry\Http\Plugin {
	use Guzzle\Common\Event;
	use Guzzle\Http\QueryAggregator\QueryAggregatorInterface;
	use Symfony\Component\EventDispatcher\EventSubscriberInterface;

	class QueryAggregatorPlugin implements EventSubscriberInterface {
		private $aggregator;

		public function __construct( QueryAggregatorInterface $aggregator ) {
			$this->aggregator = $aggregator;
		}

		public static function getSubscribedEvents() {
			return array( 'command.after_prepare' => array( 'onCommandAfterPrepare', - 255 ) );
		}

		public function onCommandAfterPrepare( Event $event ) {
			$event[ 'command' ]->getRequest()->getQuery()->setAggregator( $this->aggregator );
		}
	}
}
