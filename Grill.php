<?php
require_once "bootstrap.php";

class Grill{
	public $id_grill = 0;
	public $name= 'New Grill';
	public $unique_id = '';
	public $secret = '';
	public $enabled = true;
	public $tweets = array();

	public function __construct($unique_id=''){
		global $Db;
		if (empty($unique_id)) {
			do {
				$this->unique_id = $this->create_unique_id();
				$Result = $Db->query("SELECT * FROM grill where unique_id='{$this->unique_id}' LIMIT 1");
    		} while($Result->fetchColumn() > 0);
    		$this->secret = $this->create_secret();
    		$query = $Db->prepare("INSERT INTO grill(name, unique_id, secret) VALUES(:name, :unique_id, :secret);");
    		$query->execute(array(
    			':name' 	 => $this->name,
    			':unique_id' => $this->unique_id,
    			':secret' 	 => $this->secret
    		));
			$this->id_grill = $Db->lastInsertId();
		} else { 
			$Result = $Db->query("SELECT * FROM grill where unique_id='{$unique_id}' LIMIT 1");
			if(!$Grill = $Result->fetch(PDO::FETCH_OBJ)){
				throw new InvalidArgumentException("These are not the droid's you are looking for.", 1);
			}
			$this->id_grill = $Grill->id_grill;
			$this->name = $Grill->name;
			$this->unique_id = $Grill->unique_id;
			$this->secret = $Grill->secret;
			$this->enabled = $Grill->enabled;
			$this->load_tweets();
		}
	}
	
	private function load_tweets(){
		$Result = $Db->query("SELECT * FROM tweets where id_grill='{$this->id_grill}'");	
		foreach($Result->fetch(PDO::FETCH_OBJ) AS $tweet){
			$this->tweets[] = $tweet;
		}
	}
	
	public function validate_secret($secret){
		return $secret == $this->secret;
	}

	private function create_unique_id() {
	  	$random = '';
	  	for ($i = 0; $i < 10; $i++) {
	    	$random .= chr(rand(ord('a'), ord('z')));
	  	}
	  	return $random;
	}
	private function create_secret() {
	  	$available = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	  	$max = strlen($available)-1;
	  	$random = '';
	  	for ($i = 0; $i < 25; $i++) {
	    	$random .= $available{rand(0,$max)};
	  	}
	  	return $random;
	}

}

