<?php

class BocetyModel {
	
	public $id_bocety = 0;
	public $unique_id = '';
	public $name = 'New Bocety';
	public $description = '';
	public $secret = '';
	public $published = true;
	public $contents = array();

	public function __construct($unique_id=''){
		global $Db;
		if (empty($unique_id)) {
			do {
				$this->unique_id = $this->create_unique_id();
				$Result = $Db->query("SELECT * FROM bocety where unique_id='{$this->unique_id}' LIMIT 1");
			} while($Result->fetchColumn() > 0);
			$this->secret = $this->create_secret();
			$query = $Db->prepare("INSERT INTO bocety(name, unique_id, secret) VALUES(:name, :unique_id, :secret);");
			$query->execute(array(
				':name' 	 => $this->name,
				':unique_id' => $this->unique_id,
				':secret' 	 => $this->secret
			));
			$this->id_bocety = $Db->lastInsertId();
		} else { 
			$query = $Db->query("SELECT * FROM bocety where unique_id='{$unique_id}' LIMIT 1");
			if (!$Bocety = $query->fetch(PDO::FETCH_OBJ)) {
				throw new InvalidArgumentException("These are not the droid's you are looking for.");
			}
			$this->id_bocety = $Bocety->id_bocety;
			$this->name = $Bocety->name;
			$this->description = $Bocety->description;
			$this->unique_id = $Bocety->unique_id;
			$this->secret = $Bocety->secret;
			$this->published = ($Bocety->published=='1');
			$this->load_contents();
		}
	}
	
	private function load_contents() {
		global $Db;
		$query = $Db->query("SELECT * FROM content where id_bocety='{$this->id_bocety}'");	
		while($content = $query->fetch(PDO::FETCH_OBJ)) {
			$this->contents[] = $content;
		}
	}

	/** @todo add error detection **/
	public function update_content($id_content, $text) {
		global $Db;
		$query = $Db->prepare("UPDATE content SET text=:text WHERE id_content=:id_content AND id_bocety=:id_bocety");
		$query->execute(array(
			':id_content' => $id_content,
			':text' 	=> $text,
			':id_bocety'	=> $this->id_bocety,
		));
		return true;
	}

	/** @todo add error detection **/
	public function update_value($field, $value) {
		global $Db;
		$query = $Db->prepare("UPDATE bocety SET $field=:$field WHERE id_bocety=:id_bocety");
		$query->execute(array(
			":$field" 	=> $value,
			':id_bocety'		=> $this->id_bocety,
		));
		return true;
	}

	/** @todo add error detection **/
	public function add_content($text) {
		global $Db;
		$query = $Db->prepare("INSERT INTO content(text, id_bocety) VALUES(:text, :id_bocety)");
		$query->execute(array(
			':text' 	=> $text,
			':id_bocety'	=> $this->id_bocety,
		));
		$Content = (object) array(
			'id_content' => $Db->lastInsertId(),
			'text' => $text,
			'unique_id' => $this->unique_id,
			'secret' => $this->secret,
		);
		return $Content;
	}
	
	/** @todo add error detection **/
	public function delete_content($id_content) {
		global $Db;
		$query = $Db->prepare("DELETE FROM content WHERE id_content=:id_content AND id_bocety=:id_bocety");
		$query->execute(array(
			':id_content' => $id_content,
			':id_bocety'	=> $this->id_bocety
		));
		return true;
	}

	/** @todo add error detection **/
	public function delete() {
		global $Db;
		foreach($this->contents as $content){
			$this->delete_content($content->id_content);
		}
		$query = $Db->prepare("DELETE FROM bocety WHERE id_bocety=:id_bocety");
		$query->execute(array(
			':id_bocety'	=> $this->id_bocety
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

