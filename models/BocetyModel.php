<?php

class BocetyModel {
	
	public $id_bocety 	= 0;
	public $id_user 	= 0;
	public $name 		= 'New Bocety';
	public $description = '';
	public $published 	= false;
	public $published_secret = '';
	public $on_review 	= false;
	public $on_review_secret = '';
	public $contents 	= array();

	public function __construct($id_bocety){
		global $Db;
		$query = $Db->query("SELECT * FROM bocety where id_bocety='{$id_bocety}' LIMIT 1");
		if (!$Bocety = $query->fetch(PDO::FETCH_OBJ)) {
			throw new InvalidArgumentException("These are not the droid's you are looking for.");
		}
		$this->id_bocety = $Bocety->id_bocety;
		$this->id_user = $Bocety->id_user;
		$this->name = $Bocety->name;
		$this->description = $Bocety->description;
		$this->on_review = $Bocety->on_review;
		$this->on_secret= $Bocety->on_review_secret;
		$this->published = $Bocety->published;
		$this->published_secret= $Bocety->published_secret;
		$this->load_contents();
	}
	
	public static function create($id_user){
		global $Db;
		$query = $Db->prepare("INSERT INTO bocety(name, id_user) VALUES(:name, :id_user);");
		$query->execute(array(
			':name' 	 => 'New Bocety',
			':id_user' => $id_user
		));
		
		$id_bocety = $Db->lastInsertId();
		
		return new BocetyModel($id_bocety);
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
		$query = $Db->prepare("INSERT INTO content(text, id_bocety, id_social_account) VALUES(:text, :id_bocety, :id_social_account)");
		$query->execute(array(
			':text' 	=> $text,
			':id_bocety'	=> $this->id_bocety,
			':id_social_account' => 1,
		));
		$Content = (object) array(
			'id_content' => $Db->lastInsertId(),
			'text' => $text,
			'id_bocety' => $this->id_bocety,
			'id_social_account' => 1
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

