<?php
	
	use \Samtt\src\Config ;
	class MyJob extends Resque_Job {


		/**
		 * Find the next available job from the specified queue and return an
		 * instance of Resque_Job for it.
		 *
		 * @param string $queue The name of the queue to check for a job in.
		 * @return null|object Null when there aren't any waiting jobs, instance of Resque_Job when a job was found.
		 */
		public static function reserve($queue)
		{
			if(Resque::size($queue) < Config::$minQueueSize) {

				echo 'size is : ' . Resque::size($queue) . ' and still very small' . PHP_EOL; 
				return false;
			}
			
			$payload = Resque::pop($queue);
			if(!is_array($payload)) {
				return false;
			}

			return new Resque_Job($queue, $payload);
		}
	}