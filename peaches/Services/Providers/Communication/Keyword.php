<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace Dais\Services\Providers\Communication;

class Keyword {
	public  $contents;
	private $encoding;
	
	private $wordLengthMin             = 5;
	private $wordOccuredMin            = 2;
	private $word2WordPhraseLengthMin  = 3;
	private $word3WordPhraseLengthMin  = 3;
	private $phrase2WordLengthMinOccur = 2;
	private $phrase3WordLengthMinOccur = 2;
	private $phrase3WordLengthMin      = 10;

	public function __construct() {
		$this->encoding = 'UTF-8';
		mb_internal_encoding($this->encoding);
	}

	public function getKeywords($data) {
		$this->contents = $this->replace_chars($data);
		$keywords 		= $this->parse_words() . $this->parse_2words() . $this->parse_3words();
		
		return $this->limitKeywords($keywords);
	}

	
	protected function replace_chars($content) {
		$content = mb_strtolower($content);
		$content = strip_tags($content);

		$punctuations = array(',', ')', '(', '.', "'", '"',
		'<', '>', '!', '?', '/', '-',
		'_', '[', ']', ':', '+', '=', '#',
		'$', '&quot;', '&copy;', '&gt;', '&lt;', 
		'&nbsp;', '&trade;', '&reg;', ';', 
		chr(10), chr(13), chr(9));

		$content = str_replace($punctuations, " ", $content);
		$content = preg_replace('/ {2,}/si', " ", $content);

		return $content;
	}

	protected function parse_words() {
		$common = array(
			"able", "about", "above", "act", "add", "afraid", "after", "again", "against", "age", 
			"ago", "agree", "all", "almost", "alone", "along", "already", "also", "although", "always", 
			"am", "amount", "an", "and", "anger", "angry", "animal", "another", "answer", "any", 
			"appear", "apple", "are", "arrive", "arm", "arms", "around", "arrive", "as", "ask", "at", 
			"attempt", "aunt", "away", "back", "bad", "bag", "bay", "be", "became", "because", "become", 
			"been", "before", "began", "begin", "behind", "being", "bell", "belong", "below", "beside", 
			"best", "better", "between", "beyond", "big", "body", "bone", "born", "borrow", "both", 
			"bottom", "box", "boy", "break", "bring", "brought", "bug", "built", "busy", "but", "buy", 
			"by", "call", "came", "can", "cause", "choose", "close", "close", "consider", "come", "consider", 
			"considerable", "contain", "continue", "could", "cry", "cut", "dare", "dark", "deal", "dear", 
			"decide", "deep", "did", "die", "do", "does", "dog", "done", "doubt", "down", "during", "each", 
			"ear", "early", "eat", "effort", "either", "else", "end", "enjoy", "enough", "enter", "even", "ever", 
			"every", "except", "expect", "explain", "fail", "fall", "far", "fat", "favor", "fear", "feel", 
			"feet", "fell", "felt", "few", "fill", "find", "fit", "fly", "follow", "for", "forever", "forget", 
			"from", "front", "gave", "get", "gives", "goes", "gone", "good", "got", "gray", "great", "green", 
			"grew", "grow", "guess", "had", "half", "hang", "happen", "has", "hat", "have", "he", "hear", "heard", 
			"held", "hello", "help", "her", "here", "hers", "high", "hill", "him", "his", "hit", "hold", "hot", 
			"how", "however", "I", "if", "ill", "in", "indeed", "instead", "into", "iron", "is", "it", "its", 
			"just", "keep", "kept", "knew", "know", "known", "late", "least", "led", "left", "lend", "less", 
			"let", "like", "likely", "likr", "lone", "long", "look", "lot", "make", "many", "may", "me", "mean", 
			"met", "might", "mile", "mine", "moon", "more", "most", "move", "much", "must", "my", "near", "nearly", 
			"necessary", "neither", "never", "next", "no", "none", "nor", "not", "note", "nothing", "now", "number", 
			"of", "off", "often", "oh", "on", "once", "only", "or", "other", "ought", "our", "out", "please", 
			"prepare", "probable", "pull", "pure", "push", "put", "raise", "ran", "rather", "reach", "realize", 
			"reply", "require", "rest", "run", "said", "same", "sat", "saw", "say", "see", "seem", "seen", 
			"self", "sell", "sent", "separate", "set", "shall", "she", "should", "side", "sign", "since", "so", 
			"sold", "some", "soon", "sorry", "stay", "step", "stick", "still", "stood", "such", "sudden", 
			"suppose", "take", "taken", "talk", "tall", "tell", "ten", "than", "thank", "that", "the", "their", 
			"them", "then", "there", "therefore", "these", "they", "this", "those", "though", "through", "till", 
			"to", "today", "told", "tomorrow", "too", "took", "tore", "tought", "toward", "tried", "tries", 
			"trust", "try", "turn", "two", "under", "until", "up", "upon", "us", "use", "usual", "various", 
			"verb", "very", "visit", "want", "was", "we", "well", "went", "were", "what", "when", "where", 
			"whether", "which", "while", "white", "who", "whom", "whose", "why", "will", "with", "within", 
			"without", "would", "yes", "yet", "you", "young", "your", "br", "img", "p","lt", "gt", "quot", "copy");
		
		$s = explode(" ", $this->contents);
		$k = array();
		
		foreach ($s as $key => $val):
			if (mb_strlen (trim ($val)) >= $this->wordLengthMin  && !in_array (trim ($val), $common)  && !is_numeric (trim ($val))):
				$k[] = trim($val);
			endif;
		endforeach;
		
		$k = array_count_values($k);
		
		$occur_filtered = $this->occur_filter($k, $this->wordOccuredMin);
		arsort($occur_filtered);

		$imploded = $this->implode(", ", $occur_filtered);
		
		unset($k);
		unset($s);

		return $imploded;
	}

	protected function parse_2words() {
		$x = explode(" ", $this->contents);
		$y = array();
		
		for ($i = 0; $i < count($x) - 1; $i++):
			if ((mb_strlen (trim ($x[$i])) >= $this->word2WordPhraseLengthMin) && (mb_strlen (trim ($x[$i+1])) >= $this->word2WordPhraseLengthMin)):
				$y[] = trim ($x[$i]) . " " . trim ($x[$i+1]);
			endif;
		endfor;

		$y              = array_count_values ($y);
		$occur_filtered = $this->occur_filter($y, $this->phrase2WordLengthMinOccur);
		arsort ($occur_filtered);
		$imploded       = $this->implode (", ", $occur_filtered);
		
		unset ($y);
		unset ($x);

		return $imploded;
	}

	protected function parse_3words() {
		$a = explode (" ", $this->contents);
		$b = array();

		for ($i = 0; $i < count($a) - 2; $i++):
			if ((mb_strlen (trim ($a[$i])) >= $this->word3WordPhraseLengthMin) && (mb_strlen (trim ($a[$i+1])) > $this->word3WordPhraseLengthMin) && (mb_strlen (trim ($a[$i+2])) > $this->word3WordPhraseLengthMin) && (mb_strlen (trim ($a[$i]) . trim ($a[$i+1]) . trim ($a[$i+2])) > $this->phrase3WordLengthMin)):
				$b[] = trim ($a[$i]) . " " . trim ($a[$i+1]) . " " . trim ($a[$i+2]);
			endif;
		endfor;

		$b              = array_count_values ($b);
		$occur_filtered = $this->occur_filter($b, $this->phrase3WordLengthMinOccur);
		arsort ($occur_filtered);
		$imploded       = $this->implode (", ", $occur_filtered);
		
		unset ($a);
		unset ($b);

		return $imploded;
	}

	protected function occur_filter($array_count_values, $min_occur) {
		$occur_filtered = array();
		foreach ($array_count_values as $word => $occured):
			if ($occured >= $min_occur):
				$occur_filtered[$word] = $occured;
			endif;
		endforeach;

		return $occur_filtered;
	}

	protected function implode($glue, $array) {
		$c = "";
		foreach ($array as $key => $val):
			$c .= $key . $glue;
		endforeach;
		return $c;
	}
	
	public function getDescription($string, $limit = 160, $break = " ", $pad = ".") {
		// first decode the string
		$string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
		$string = htmlspecialchars_decode($string);
		
		$string = Encode::riptags($string);
		
		// return with no change if string is shorter than $limit
		if (strlen ($string) <= $limit) return $string;
		
		// is $break present between $limit and the end of the string?
		
		if (false !== ($breakpoint = strpos($string, $break, $limit))):
			if ($breakpoint < strlen($string) - 1):
				$string = substr($string, 0, $breakpoint) . $pad;
			endif;
		endif;
		
		return $string;
	}
	
	protected function limitKeywords($keywords, $limit = 9) {
		$keys = array();
		$data = explode (',', $keywords);
		$count = 0;
		foreach ($data as $keyword):
			$count++;
			if ($count < $limit):
				$keys[] = trim($keyword);
			endif;
		endforeach;
		
		$new_keywords = implode (', ', $keys);
		
		return rtrim ($new_keywords, ', ');
	}
}
