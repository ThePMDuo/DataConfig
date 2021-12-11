<?php
declare(strict_types = 1);

namespace skymin\config;

use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use PrefixedLogger;

final class SaveAsyncTask extends AsyncTask{
	use SaveTrait;
	
	private PrefixedLogger $logger;
	
	public function __construct(
		private string $fileName,
		private array $data,
		private int $type
	){
		$this->logger = new PrefixedLogger(Server::getInstance()->getLogger(), 'DataConfig');
	}
	
	public function onRun() :void{
		$type = $this->type;
		$fileName = $this->fileName;
		$data = (array) $this->data;
		$this->logger->debug('Starting save data at ' .  $fileName);
		if(self::save($type, $fileName, $data)){
			$this->setResult('Completed');
		}else{
			$this->setResult('Failed');
		}
	}
	
	public function onCompletion() :void{
		$this->logger->debug($this->getResult() . ' to save Data at' . $this->fileName);
	}
	
}