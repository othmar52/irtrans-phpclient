<?php


class remotecontrol {
	private $client = 'udp-packet-sender.py';
	
	private $devices;	// devices to control
	private $irtrans;	// ir sender
	private $ezcontrol;	// 433 MHz sender
	
	private $dryrun = FALSE;	// do not really send command to network devices - just fake it
	
	
	/** 
	 * Load config in constructor because every method is useless without conf
	 * 
	 * @return Instance of remotecontrol  
	 **/
	public function __construct()
	{
		require_once('Spyc.php');
		$this->devices = Spyc::YAMLLoad('config/default.yaml');
		
		$this->irtrans = $this->devices['connections']['irtrans'];
		$this->ezcontrol = $this->devices['connections']['ezcontrol'];
		
		unset($this->devices['connections']); 
		
		
		#echo "<pre>" . print_r($this->irtrans, 1) . "</pre>";
		#echo "<pre>" . print_r($this->ezcontrol, 1) . "</pre>";
		#echo "<pre>" . print_r($this->devices, 1) . "</pre>";
		
		// TODO: validate config
	}
	
	public function fire($remotename, $command)
	{
			
		if($this->dryrun === TRUE) {
			echo "FAKE: device: " . $remotename . ", cmd: " . $command;
			exit;
		}
		// TODO: make senderdevice configurable for each device
		// TODO: validate command(!!!) and 
		// TODO: remove hardcoded sender evice
		
		
		$ip = $this->irtrans['it1']['ip'];
		$port = $this->irtrans['it1']['port'];
		
		//foreach($this->irtrans as $transconfig) {
		
		// TODO: send udp packets with php instead of exec(pythonscript)	
		
		$cmd = dirname(__FILE__) . DIRECTORY_SEPARATOR . "{$this->client} --host={$ip} --port={$port} \"Asnd {$remotename},{$command}\"";
		#echo $cmd;
		exec($cmd, $response);
		echo $response[0];
		exit;
		echo "<pre>$cmd\n" . print_r($response, 1) . "</pre>";
		
	}
	
	public function funky($actor, $ommand)
	{
		if($this->dryrun === TRUE) {
			echo "FAKE: device: " . $remotename . ", cmd: " . $cmd;
			exit;
		}
		
		// TODO: remove dummyhandling of ezcontrol 
		$ezcontrol_ip = '10.0.0.118'; 
		$url = "http://{$ezcontrol_ip}/control?cmd=set_state_actuator&number={$actor}&function={$ommand}";
		
		file_get_contents($url);
		exit;
		
	}
	public function renderNavigation()
	{
		// TODO: move markup to tempalte
		// TODO: render only powerbutton with buttonconfig "powernav: 1"
		$markup ="";
	    foreach($this->devices as $device => $dConf) {
			$button = '<button class="fire navpower" ' .
						 'data-type="' . $dConf['type'] .'" ' .
						 'data-remote="' . $device . '" ' .
						 'data-cmd="' . $dConf['powernav'] .'" ' .
						 '>' . "<i class=\"fa fa-power-off fa-lg\"></i></button>\n";
        	$markup .= '
        		<li>
        			<a class="scrollto" href="#s'.$device .'">' . $dConf['label'] . '</a>
        			'.$button.'
        		</li>';
        }
			
		return $markup;
		
	}
        
	
	public function renderDeviceButtons()
	{
		// TODO: move markup to tempalte
		$markup = "";
		foreach($this->devices as $device => $dConf) {
			$dConf['label'] = (array_key_exists( 'label',$dConf)) ? $dConf['label'] : FALSE;
        	$markup .= '<div class="section" id="s'. $device .'"><h3>' . $dConf['label'] . '</h3>' . "\n";
			foreach($dConf['rows'] as $dRow) {
				$markup .= '<div class="brow clearfix brow' . count($dRow) . '">';
				foreach($dRow as $cmd => $rowConfig) {
					
					if($rowConfig === NULL) {
						$class = 'hideme';
						$text = '';
					} else {
						$class = 'cmd';
						$rowConfig['icon'] = (array_key_exists( 'icon',$rowConfig)) ? $rowConfig['icon'] : FALSE;
						$rowConfig['label'] = (array_key_exists( 'label',$rowConfig)) ? $rowConfig['label'] : FALSE;
						
						$text = (($rowConfig['icon'] !== FALSE) ? '<i class="fa '.$rowConfig['icon'].' fa-lg"></i>' : '') .
							(($rowConfig['label'] !== FALSE) ? ' ' . $rowConfig['label'] : ''); 
					
					}
					$markup .= '<button class="fire ' . $class . '" ' .
						 'data-type="' . $dConf['type'] .'" ' .
						 'data-remote="' . $device . '" ' .
						 'data-cmd="' . $cmd .'" ' .
						 '>' . $text . "</button>\n";
					
					 
				}
				$markup .= '</div>';
			}
			$markup .= "</div>\n";
        }
        
		return $markup;
	}
}
?>
