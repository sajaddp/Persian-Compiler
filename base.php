<?php 
/*
	In The Name of GOD
	Persian Compiler
*/
class base {
	
	private $db;
	private $q;
	private $a;
	private $b;
	private $c;

	// آماده سازی اولیه:
	public function __construct(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "persian_compiler";
		$this->c = 0;
		$this->db = new mysqli($servername, $username, $password, $dbname);
		 mysqli_query($this->db,"SET NAMES utf8");
	}

	public function multiexplode ($delimiters,$string) { 
		$ready = str_replace($delimiters, $delimiters[0], $string); 
		$launch = explode($delimiters[0], $ready); 
		return $launch; 
	} 

	public function SetText ($txt) { 
		$txt = preg_replace('/\n/', ' ', $txt);
		$txt = preg_replace('/؟!/', '!', $txt);
		return $txt;
	}

	public function SetSentence ($txt) {
		$tmp = $this->multiexplode(array(".","؟","؟!","!",":","؛"),$txt);
		$z=0;
		$this->q = array();
		foreach($tmp as $tp){
			if (strlen($tp)==0)
				unset($tmp[$z]);
			else{
				$this->q []=trim($tmp[$z]);
			}
			$z++;
		}
		if (!$this->ValidSentence($this->q )) $this->q =array('☻');
		return $this->q ;
	}

	public function ValidSentence ($arr) {
		$z=0;
		foreach($arr as $tp){
			if( preg_match_all('/\(([^)]+)\)/', $tp, $matches, PREG_PATTERN_ORDER) ) {
				foreach($matches[1] as $tg=>$v) {
					$arr[$z] = trim(str_replace('('.$v.')', "", $tp));
				}
			}
			$z++;
		}
		foreach($arr as $tp){
			if( preg_match_all('/(\(|\))/', $tp, $matches, PREG_PATTERN_ORDER) ) {
				return false;
			}
		}
		$this->q = $arr;
		return true;
	}

	// گرامر:
	public function J ($txt){//تمام!
		$this->a = explode(' ', $txt); 
		$this->b = count($this->a);
		//array(array("Gg","N","Gf"),array("J1"))
		$x = $this->c;
		while ( $this->c <= $this->b ) {
			$this->Gg($txt);
			$this->Ga($txt);
			if($this->Gf($txt))/// !!
				return true;
			else
				break;
		}
		$this->c = $x;
		return $this->J1($txt);
	}

	public function J1 ($txt){//تمام!
		//array(array("Hr","J","J1"))
		if (!$this->Hr($txt))
			return false;
		if (!$this->J($txt))
			return false;
		if (!$this->J1($txt))
			return false;
		return true;
	}

	public function Gg ($txt){//تمام!
		//array(array("Ha","R","Ga"),array("R","Ha","Ga"))
		$x = $this->c;
		while ($this->c <= $this->b) {
			if($this->Ha($txt))
				return true;
			else if($this->R($txt))
				return true;
			else if($this->Ga($txt))
				return true;
			else
				break;
		}
		$this->c = $x;

		while ($this->c <= $this->b) {
			if($this->R($txt))
				return true;
			else if($this->Ha($txt))
				return true;
			else if($this->Ga($txt))
				return true;
			else
				break;
		}

		return false;
	}

	public function Ga ($txt){///فکر کنم تمام!
		$check = array('خودم','خودت','خودش','خودمان','خودتان','خودشان');
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}
		$x = $this->c;
		if($this->a[$this->c]=='خود')
			$this->c++;
		if($this->Ek($txt)){
			$this->Ea($txt);
			if(!$this->Z($txt))
				$this->Ek($txt);
			if($this->a[$this->c]=='که'){
				$this->c++;
				if($this->J($txt))
					return true;
				else{
					$this->c = $x;
					return false;
				}
			}else
				return true;
		}
		if($this->Ea($txt)){
			$flag = false;
			if ($this->Z)
				$flag = true;
			if ($this->Ek)
				$flag = true;
			if(!$flag)
				if (in_array($this->a[$this->c], $check)){
				 $this->c++;
				}
			if($this->a[$this->c]=='که'){
				$this->c++;
				if($this->J($txt))
						return true;
				else{
					$this->c = $x;
					return false;
				}
			}else
				return true;
		}else{
			if (in_array($this->a[$this->c], $check)){
			 $this->c++;
				if($this->a[$this->c]=='که'){
					$this->c++;
					if($this->J($txt))
						return true;
					else{
						$this->c = $x;
						return false;
					}
				}else
					return true;
			}
		}
	}

	public function Gf ($txt){//!!
		return true;
	}

	public function Hr ($txt){//تمام!
		$check = array('و','یا','پس','اگر','نه','چون','چه','تا','اما','باری','پس','خواه','زیرا','که','لیکن','نیز','ولی','هم');
		 if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		 }else
			 return false;
	}

	public function Ha ($txt){//تمام!
		$check = array('به','از','برای','با');
		if (in_array($this->a[$this->c], $check)){
			$this->c++;
			return true;
		}else
			return false;
	}

	public function R ($txt){//تمام!
		$check = array('زیر','علت','ادامه','میان','نتیجه','دنبال','طرف');
		if (in_array($this->a[$this->c], $check)){
			$this->c++;
			return true;
		}else
			return false;
	}

	public function Ek ($txt){//!!
		return true;
	}

	public function Ea ($txt){//!!
		return true;
	}

	public function Z ($txt){//!!
		return true;
	}

	public function Gha ($txt){//تمام!
		if ($this->Ha($txt) && $this->Ga($txt))
			return true;
		else
			return false;
	}

	public function S ($txt){//!!
		return true;
	}

	public function At ($txt){//!!
		return true;
	}

	public function Gha ($txt){//!!
		return true;
	}

	public function Gs ($txt){//داغون!
		$check = array('نسبتا','بسیار','خیلی');
	 if (in_array($this->a[$this->c], $check)){
		 $this->c++;
		 return true;
	 }else
		 return false;
	}

}