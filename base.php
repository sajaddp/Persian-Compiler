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
		/*$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "persian_compiler";
		$this->db = new mysqli($servername, $username, $password, $dbname);
		mysqli_query($this->db,"SET NAMES utf8");*/
		$this->c = 0;
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
		$this->Gg($txt);
		$this->Ga($txt);
		if($this->Gf($txt)){
			if ($this->c == $this->b)
				return true;
			else
				return false;
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
		if($this->Ha($txt))
			return true;
		else if($this->R($txt))
			return true;
		else if($this->Ga($txt))
			return true;
		$this->c = $x;
		
		if($this->R($txt))
			return true;
		else if($this->Ha($txt))
			return true;
		else if($this->Ga($txt))
			return true;
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
			if ($this->Z($txt))
				$flag = true;
			if ($this->Ek($txt))
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

	public function Gf ($txt){//تمام
		$x = $this->c;
		if ($this->Ga($txt)){
			if ($this->Gf($txt))
				return true;
			else
				return $this->rback($x);
		}
		if ($this->FM($txt)){//افعال متعدی
			return true;
		}
		if ($this->a[$this->c] == 'را'){//را لازم
			if ($this->FL($txt))
				return true;
			else
				return $this->rback($x);
		}
		if ($this->M($txt)){//mFr
			if ($this->Fr($txt))
				return true;
			else
				return $this->rback($x);
		}
		if ($this->Gha($txt)){//GhaFr
			if ($this->Fr($txt))
				return true;
			else
				return $this->rback($x);
		}
		//$this->rback($x);
		//وحشتناک!!
	}

	public function Hr ($txt){//تمام!
		$check = array('و','یا','پس','اگر','نه','چون','چه','تا','اما','باری','پس','خواه','زیرا','که','لیکن','نیز','ولی','هم');
		 if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		 }else
			 return false;
	}

	public function Fr ($txt){//تمام!
		$check = array('است', 'بود', 'شد', 'گشت', 'گردید', 'به-نظر-رسید', 'به-نظر-می-رسد', 'به-نظر-می-آید', 'به-نظر-بیاید');
		 if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		 }else
			 return false;
	}

	public function FM ($txt){//تمام!
		$check = array('چسبیدم', 'چسبیدی', 'چسبید', 'چسبیدیم', 'چسبیدید', 'چسبیدند', 'می-چسبیدم', 'می-چسبیدی', 'می-چسبید', 'می-چسبیدیم', 'می-چسبیدید', 'می-چسبیدند', 'چسبیده-ام', 'چسبیده-ای', 'چسبیده-است', 'چسبیده-ایم', 'چسبیده-اید', 'چسبیده-اند', 'چسبیده-بودم', 'چسبیده-بودی', 'چسبیده-بود', 'چسبیده-بودیم', 'چسبیده-بودید', 'چسبیده-بودند', 'چسبیده-باشم', 'چسبیده-باشی', 'چسبیده-باشد', 'چسبیده-باشیم', 'چسبیده-باشید', 'چسبیده-باشند', 'می-چسبم', 'می-چسبی', 'می-چسبد', 'می-چسبیم', 'می-چسبیم', 'می-چسبند', 'بچسبم', 'بچسبی', 'بچسبد', 'بچسبیم', 'بچسبید', 'بچسبند', 'بچسب', 'خواهم-چسبید', 'خواهی-چسبید', 'خواهد-چسبید', 'خواهیم-چسبید', 'خواهید-چسبید', 'خواهند-چسبید', 'رفتم', 'رفتی', 'رفت', 'رفتیم', 'رفتید', 'رفتند', 'می-رفتم', 'می-رفتی', 'می-رفت', 'می-رفتیم', 'می-رفتید', 'می-رفتند', 'رفته-ام', 'رفته-ای', 'رفته-است', 'رفته-ایم', 'رفته-اید', 'رفته-اند', 'رفته-بودم', 'رفته-بودی', 'رفته-بود', 'رفته-بودیم', 'رفته-بودید', 'رفته-بودند', 'رفته-باشم', 'رفته-باشی', 'رفته-باشد', 'رفته-باشیم', 'رفته-باشید', 'رفته-باشند', 'می-روم', 'می-روی', 'می-رود', 'می-رویم', 'می-روید', 'می-روند', 'بروم', 'بروی', 'برود', 'برویم', 'بروید', 'بروند', 'خواهم-رفت', 'خواهی-رفت', 'خواهد-رفت', 'خواهیم-رفت', 'خواهید-رفت', 'خواهند-رفت', 'آمدم', 'آمدی', 'آمد', 'آمدیم', 'آمدید', 'آمدند', 'می-آمدم', 'می-آمدی', 'می-آمد', 'می-آمدیم', 'می-آمدید', 'می-آمدند', 'آمده-ام', 'آمده-ای', 'آمده-است', 'آمده-ایم', 'آمده-اید', 'آمده-اند', 'آمده-بودم', 'آمده-بودی', 'آمده-بود', 'آمده-بودیم', 'آمده-بودید', 'آمده-بودند', 'آمده-باشم', 'آمده-باشی', 'آمده-باشد', 'آمده-باشیم', 'آمده-باشید', 'آمده-باشند', 'می-آیم', 'می-آیی', 'می-آید', 'می-آییم', 'می-آیید', 'می-آیند', 'بیایم', 'بیایی', 'بیاید', 'بیاییم', 'بیایید', 'بیایند', 'خواهم-آمد', 'خواهی-آمد', 'خواهد-آمد', 'خواهیم-آمد', 'خواهید-آمد', 'خواهند-آمد', 'گفتم', 'گفتی', 'گفت', 'گفتیم', 'گفتید', 'گفتند', 'می-گفتم', 'می-گفتی', 'می-گفت', 'می-گفتیم', 'می-گفتید', 'می-گفتند', 'گفته-ام', 'گفته-ای', 'گفته-است', 'گفته-ایم', 'گفته-اید', 'گفته-اند', 'گفته-بودم', 'گفته-بودی', 'گفته-بود', 'گفته-بودیم', 'گفته-بودید', 'گفته-بودند', 'گفته-باشم', 'گفته-باشی', 'گفته-باشد', 'گفته-باشیم', 'گفته-باشید', 'گفته-باشند', 'می-گویم', 'می-گویی', 'می-گوید', 'می-گوییم', 'می-گویید', 'می-گویند', 'بگویم', 'بگویی', 'بگوید', 'بگوییم', 'بگویید', 'بگویند', 'خواهم-گفت', 'خواهی-گفت', 'خواهد-گفت', 'خواهیم-گفت', 'خواهید-گفت', 'خواهند-گفت');
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else{
			return false;
		}
	}

	public function FL ($txt){//تمام!
		$check = array('خوردم', 'خوردی', 'خورد', 'خوردیم', 'خوردید', 'خوردند', 'می-خوردم', 'می-خوردی', 'می-خورد', 'می-خوردیم', 'می-خوردید', 'می-خوردند', 'خورده-ام', 'خورده-ای', 'خورده-است', 'خورده-ایم', 'خورده-اید', 'خورده-اند', 'خورده-بودم', 'خورده-بودی', 'خورده-بود', 'خورده-بودیم', 'خورده-بودید', 'خورده-بودند', 'خورده-باشم', 'خورده-باشی', 'خورده-باشد', 'خورده-باشیم', 'خورده-باشید', 'خورده-باشند', 'بخورم', 'بخوری', 'بخورد', 'بخوریم', 'بخورید', 'بخورند', 'می-خورم', 'می-خوری', 'می-خورد', 'می-خوریم', 'می-خورید', 'می-خورند', 'خواهم-خورد', 'خواهی-خورد', 'خواهد-خورد', 'خواهیم-خورد', 'خواهید-خورد', 'خواهند-خورد', 'خواستم', 'خواستی', 'خواست', 'خواستیم', 'خواستید', 'خواستند', 'می-خواستم', 'می-خواستی', 'می-خواست', 'می-خواستیم', 'می-خواستید', 'می-خواستند', 'خواسته-ام', 'خواسته-ای', 'خواسته-است', 'خواسته-ایم', 'خواسته-اید', 'خواسته-اند', 'خواسته-بودم', 'خواسته-بودی', 'خواسته-بود', 'خواسته-بودیم', 'خواسته-بودید', 'خواسته-بودند', 'خواسته-باشم', 'خواسته-باشی', 'خواسته-باشد', 'خواسته-باشیم', 'خواسته-باشید', 'خواسته-باشند', 'می-خواهم', 'می-خواهی', 'می-خواهد', 'می-خواهیم', 'می-خواهید', 'می-خواهند', 'بخواهم', 'بخواهی', 'بخواهد', 'بخواهیم', 'بخواهید', 'بخواهند', 'خواهم-خواست', 'خواهی-خواست', 'خواهد-خواست', 'خواهیم-خواست', 'خواهید-خواست', 'خواهند-خواست');
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else{
			return false;
		}
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

	public function Ek ($txt){//کلمات نمونه اضافه شد، تمام!
		$check = array("زهرا", "محمد", "احمد", "علی", "سجاد", "مهدی", "فاطمه", "مهری", "بابک", "حسن", "حسین", "اسماعیل", "امین", "امیر", "رخش", "مریخ", "فرانسه", "ایران", "رفسنجان", "قرآن", "مفاتیح", "ثین", "جمشید", "دما", "برند", "تبریز", "علی", "هوا", "خطا", "جمله");
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else
			return false;
	}

	public function Ea ($txt){//کلمات نمونه اضافه شد، تمام!
		$check = array("دریا", "آب", "غار", "فاز", "فاصله", "غاز", "زندگی", "شنا", "ورزش", "سابقه", "شهر", "روستا", "استان", "لپتاپ", "کامپیوتر", "حیوان", "فرش", "دیوار", "کار", "بازی", "انگشتر", "شعر", "داستان", "رمان", "یرج", "بلندگو", "پتک", "پلیس", "بیمه", "بانک", "باغ", "جمله");
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else
			return false;
	}

	public function Z ($txt){//تمام!
		$check = array('من', 'تو', 'او', 'ما شما', 'نها', 'ایشان', 'آنان', 'ماش', 'مان', 'تان', 'برخی', 'بعضی', 'یکدیگر', 'همدیگر', 'این', 'آنانخیلی', 'اینها', 'که', 'چه', 'کدام', 'چند', 'کی', 'یکی', 'فلانی', 'آدم', 'همه', 'تمام', 'بسیار', 'دیگری', 'هیچ', 'کمی', 'مقداری', 'همه', 'چندتا');
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else
			return false;
	}

	public function Gha ($txt){//تمام!
		if ($this->Ha($txt) && $this->Ga($txt))
			return true;
		else
			return false;
	}

	public function S ($txt){//تمام!
		$check = array('صحیح','خوب', 'بد', 'زشت', 'زیبا', 'قشنگ', 'تمیز', 'کثیف', 'باهوش', 'نرم', 'زیر', 'تلخ', 'ترش', 'شیرین', 'آرام', 'عصبانی', 'خونسرد', 'خونگرم', 'خوشحال', 'ناراحت', 'شاد', 'غمگین', 'زنده', 'مرده', 'پرحرف', 'کم-حرف', 'بیحال', 'پویا', 'فعال', 'متفکر', 'سخت', 'آسان', 'خرسند', 'گرم', 'سرد');
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else
			return false;
	}

	public function At ($txt){//تمام!
		$check = array("اولین", "دومین", "سومین", "چهارمین", "پنجمین", "ششمین", "هفتمین", "هشتمین", "نهمین", "دهمین", "یازدهمین", "دوازدهمین", "سیزدهمین", "چهاردهمین", "پانزدهمین", "شانزدهمین", "هفدهمین", "هجدهمین", "بیستمین");
		if (in_array($this->a[$this->c], $check)){
			 $this->c++;
			 return true;
		}else
			return false;
	}

	public function Gs ($txt){//وخیم ولی تمام!
			$x = $this->c;
			if ($this->D($txt)){
				if(!$this->L($txt))
					return $this->rback($x);
			}
			if($this->L($txt))
				return true;
			if($this->At($txt)){
				if($this->a[$this->c] == 'و')
					if(!$this->At($txt))
						return $this->rback($x);
				return true;
			}
			if($this->S($txt)){
				$this->Ga($txt);
				return true;
			}

	}

	public function D ($txt){//تمام!
		$check = array('نسبتا','بسیار','خیلی');
	 if (in_array($this->a[$this->c], $check)){
		 $this->c++;
		 return true;
	 }else
		 return false;
	}
	
	public function L ($txt){//ظاهرا تمام!
		$x = $this->c;
		$z=0;
		if($this->S($txt)){
			$z=1;
			$this->S($txt);
		}
		$this->At($txt);
		if($z=1)
			return true;
		else
			return $this->rback($x);
	}
	
	public function rback ($x){//تمام!
		$this->c = $x;
		return false;
	}

}