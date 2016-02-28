<?php

class User {
	
	public $id_user = 0;
	public $email = '';
	public $password_hash = '';
	public $confirmed = false;
	public $confirmation_secret = '';
	

	public function __construct($id_user){
		global $Db;
		
		$query = $Db->query("SELECT * FROM user where id_user='{$id_user}' LIMIT 1");
		if (!$User = $query->fetch(PDO::FETCH_OBJ)) {
			throw new InvalidArgumentException("The User doesn't exists.");
		}
		
		$this->id_user = $User->id_user;
		$this->email = $User->email;
		$this->password_hash = $User->password_hash;
		$this->confirmed = $User->confirmed;
		$this->confirmation_secret = $User->confirmation_secret;
	}
	
	public static function create($email, $password) {
		global $Db;
		
		$query = $Db->prepare("SELECT * FROM user where email=:email LIMIT 1");
		$query->execute(array(':email'=>$email));
		
		if ( $query->fetchColumn() > 0) {
			throw new InvalidArgumentException("Email already exists.");
		}
		
		$query = $Db->prepare("INSERT INTO user(email, password_hash) VALUES(:email, :password_hash);");
		$query->execute(array(
			':email' 	 => $email,
			':password_hash' => password_hash($password, PASSWORD_BCRYPT)
		));
		$id_user = $Db->lastInsertId();
		
		return new User($id_user);
	}

	public function getData(){
		return  (array)$this;
	}

	public function validate_password($password) {
		return password_verify($password, $this->password_hash);
	}

	/*private function load_contents() {
		global $Db;
		$query = $Db->query("SELECT * FROM content where id_bocety='{$this->id_bocety}'");	
		while($content = $query->fetch(PDO::FETCH_OBJ)) {
			$this->contents[] = $content;
		}
	}

	/** @todo add error detection *
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

	/** @todo add error detection *
	public function update_value($field, $value) {
		global $Db;
		$query = $Db->prepare("UPDATE bocety SET $field=:$field WHERE id_bocety=:id_bocety");
		$query->execute(array(
			":$field" 	=> $value,
			':id_bocety'		=> $this->id_bocety,
		));
		return true;
	}

	/** @todo add error detection *
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
	
	/** @todo add error detection *
	public function delete_content($id_content) {
		global $Db;
		$query = $Db->prepare("DELETE FROM content WHERE id_content=:id_content AND id_bocety=:id_bocety");
		$query->execute(array(
			':id_content' => $id_content,
			':id_bocety'	=> $this->id_bocety
		));
		return true;
	}

	/** @todo add error detection *
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
	}*/

}

