<?php
require_once "bootstrap.php";

class Grill {
	
	public $id_grill = 0;
	public $unique_id = '';
	public $name = 'New Grill';
	public $description = '';
	public $secret = '';
	public $published = true;
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
			$query = $Db->query("SELECT * FROM grill where unique_id='{$unique_id}' LIMIT 1");
			if (!$Grill = $query->fetch(PDO::FETCH_OBJ)) {
				throw new InvalidArgumentException("These are not the droid's you are looking for.");
			}
			$this->id_grill = $Grill->id_grill;
			$this->name = $Grill->name;
			$this->description = $Grill->description;
			$this->unique_id = $Grill->unique_id;
			$this->secret = $Grill->secret;
			$this->published = ($Grill->published=='1');
			$this->load_tweets();
		}
	}
	
	private function load_tweets() {
		global $Db;
		$query = $Db->query("SELECT * FROM tweet where id_grill='{$this->id_grill}'");	
		while($tweet = $query->fetch(PDO::FETCH_OBJ)) {
			$this->tweets[] = $tweet;
		}
	}

	/** @todo add error detection **/
	public function update_tweet($id_tweet, $text) {
		global $Db;
		$query = $Db->prepare("UPDATE tweet SET text=:text WHERE id_tweet=:id_tweet AND id_grill=:id_grill");
		$query->execute(array(
			':id_tweet' => $id_tweet,
			':text' 	=> $text,
			':id_grill'	=> $this->id_grill,
		));
		return true;
	}

	/** @todo add error detection **/
	public function update_value($field, $value) {
		global $Db;
		$query = $Db->prepare("UPDATE grill SET $field=:$field WHERE id_grill=:id_grill");
		$query->execute(array(
			":$field" 	=> $value,
			':id_grill'		=> $this->id_grill,
		));
		return true;
	}

	/** @todo add error detection **/
	public function add_tweet($text) {
		global $Db;
		$query = $Db->prepare("INSERT INTO tweet(text, id_grill) VALUES(:text, :id_grill)");
		$query->execute(array(
			':text' 	=> $text,
			':id_grill'	=> $this->id_grill,
		));
		$Tweet = (object) array(
			'id_tweet' => $Db->lastInsertId(),
			'text' => $text,
			'unique_id' => $this->unique_id,
			'secret' => $this->secret,
		);
		return $Tweet;
	}
	
	/** @todo add error detection **/
	public function delete_tweet($id_tweet) {
		global $Db;
		$query = $Db->prepare("DELETE FROM tweet WHERE id_tweet=:id_tweet AND id_grill=:id_grill");
		$query->execute(array(
			':id_tweet' => $id_tweet,
			':id_grill'	=> $this->id_grill
		));
		return true;
	}

	/** @todo add error detection **/
	public function delete() {
		global $Db;
		foreach($this->tweets as $tweet){
			$this->delete_tweet($tweet->id_tweet);
		}
		$query = $Db->prepare("DELETE FROM grill WHERE id_grill=:id_grill");
		$query->execute(array(
			':id_grill'	=> $this->id_grill
		));
		return true;
	}
	
	public function validate_secret($secret) {
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

