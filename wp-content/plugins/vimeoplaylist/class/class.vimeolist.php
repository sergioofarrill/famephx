<?php
/*
  * @copyright 2012 Ceasar Feijen www.cfconsultancy.nl
  * @Vimeolist generator
  * @This is not free software
  */
// Live enviroment:
//error_reporting(0);
//ini_set('display_errors', 0);
//error_reporting(E_ALL);

class vimeolist
{
	protected $type = 'username';
	protected $cachexml = false;
	protected $cachelife = 86400; //24*60*60;
	protected $urldata = array();
	protected $user;
	protected $feedtype = 'videos';
	protected $xmlpath = './cache/';
	protected $curlinit;
	protected $descriptionlength = 300;
	protected $titlelength = 75;

	public function __construct($type)
	{
		$this->curlinit = function_exists('curl_init');
		$this->type = $type;
	}

	protected function truncate($string, $length = '', $replacement = '', $start = 75) //alternative substr
	{
		if (strlen($string) <= $start)
			return $string;
		if ($length)
		{
			return substr_replace($string, $replacement, $start, $length);
		}
		else
		{
			return substr_replace($string, $replacement, $start);
		}
	}

    protected function mbencoding($string)
    {
        if (function_exists('mb_convert_encoding'))
        {
            return mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8');
        }
        else
        {
            return htmlentities(utf8_encode($string));
        }
	}

	public function set_titlelength($titlelength) // Set title lenght
	{
		$this->titlelength = $titlelength;
	}

	public function set_descriptionlength($descriptionlength) // Set title lenght
	{
		$this->descriptionlength = $descriptionlength;
	}

	public function set_username($username) // Set username
	{
		$this->user = $username;
	}

	public function set_feedtype($feedtype) // Set feed type
	{
		$this->feed = $feedtype;
	}

	public function set_cachexml ($cache) // Bool, 1 use cache, 0 don't use cache
	{
		if($cache === false || $cache === true)
		{
			$this->cachexml = $cache;
		}
		else
		{
			throw new InvalidArgumentException('set_cachexml can only be boolean');
		}
	}

	public function set_cachelife ($cachelife) // Lifetime of cache NOTE: USE SECONDS!
	{
		$this->cachelife = $cachelife; // No check
	}

	public function set_xmlpath ($path) // Set where to store xml files
	{
		$this->xmlpath = $path;
	}

	protected function build_url($type) // Generate url
	{
		switch ($this->feed)
		{
			case 'album':
                return 'http://vimeo.com/api/v2/album/' . $this->user . '/videos.xml';
				break;
			case 'channel':
				return 'http://vimeo.com/api/v2/channel/' . $this->user . '/videos.xml';
				break;
			case 'group':
				return 'http://vimeo.com/api/v2/group/' . $this->user . '/videos.xml';
				break;
			case 'videos':
			case 'likes':
			case 'appears_in':
			case 'all_videos':
			case 'subscriptions':
				return 'http://vimeo.com/api/v2/' . $this->user . '/' . $this->feed . '.xml';
				break;
			default:
				throw new InvalidArgumentException('Build_url needs right type');
		}
	}

	public static function closetags($html)
    {
        // strip fraction of open or close tag from end (e.g. if we take first x characters, we might cut off a tag at the end!)
         $html = preg_replace('/<[^>]*$/','',$html); // ending with fraction of open tag

        // put open tags into an array
        preg_match_all('#<([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
        $opentags = $result[1];

        // put all closed tags into an array
        preg_match_all('#</([a-z]+)>#iU', $html, $result);
        $closetags = $result[1];

        $len_opened = count($opentags);

        // if all tags are closed, we can return
        if (count($closetags) == $len_opened) {
            return $html;
        }

        // close tags in reverse order that they were opened
        $opentags = array_reverse($opentags);

        // self closing tags
        $sc = array('br','input','img','hr','meta','link');
        // ,'frame','iframe','param','area','base','basefont','col'
        // should not skip tags that can have content inside!

        for ($i=0; $i < $len_opened; $i++)
        {
            $ot = strtolower($opentags[$i]);
            if (!in_array($opentags[$i], $closetags) && !in_array($ot,$sc))
            {
                $html .= '</'.$opentags[$i].'>';
            }
            else
            {
                unset($closetags[array_search($opentags[$i], $closetags)]);
            }
        }
        return $html;
    }

	public function get_videos() // Use this function. You have to use the right type
	{
		$xmldoc = new DOMDocument();

		$url = $this->build_url('username');

		$file = realpath($this->xmlpath) . DIRECTORY_SEPARATOR . md5($url) . '.xml';

		if($this->cachexml && $this->cache_file($file))
		{
			if(@!$xmldoc->load($file))
			{
				throw new Exception('Error loading feed');

			}
		}
		else
		{
        try {
			if($this->curlinit)
			{
				if(@!$xmldoc->loadXML($this->curl_request($url)))
				{
					throw new Exception('Error loading feed');
				}
			}
			else
			{
				if(@!$xmldoc->load($url))
				{
					throw new Exception('Error loading feed' . $url);
				}
			}
	    } catch(Exception $e){
	        echo 'Wrong url ' . $url;
	        return;
	    }

			if($this->cachexml)
			{
			@file_put_contents($file, $xmldoc->saveXML()); // Suppres error. User can't help this error... Should log
			}
		}
		$xpath = new DOMXPath($xmldoc);
		$query = '//video';
		$data = $xpath->query($query);
		$videodata = array();
		foreach($data as $dat)
		{
			$temparray = array();
			$query = 'description';


$temparray['description'] = $this->mbencoding(ucfirst(strtolower($this->truncate($xpath->query($query, $dat)->item(0)->nodeValue,'','',$this->descriptionlength))));

            $temparray['description'] = preg_replace('#<br[^>]*>#ism',' ',$temparray['description']);
            $temparray['description'] = $this->closetags($temparray['description']);

			$query = 'title';
			$temparray['title'] = $this->mbencoding($this->truncate($xpath->query($query, $dat)->item(0)->nodeValue,'',' ..',$this->titlelength));

			$query = 'id';
			$temparray['videoid'] = $xpath->query($query, $dat)->item(0)->nodeValue;

			$query = 'thumbnail_small';
			$temparray['thumbnail_small'] = $xpath->query($query, $dat)->item(0)->nodeValue;

			$query = 'duration';
			$temparray['time'] = $this->time($xpath->query($query, $dat)->item(0)->nodeValue);
			$videodata[] = $temparray;
		}
		return $videodata;
	}

	protected function curl_request($url) // Make a cURL request
	{
		$chf = curl_init();
		$timeout = 15; // set to zero for no timeout
		curl_setopt ($chf, CURLOPT_URL, $url);
		curl_setopt ($chf, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($chf, CURLOPT_CONNECTTIMEOUT, $timeout);
		$feedcontents = curl_exec($chf);
		curl_close($chf);
		return $feedcontents;
	}

	protected function time($sec, $padHours = false)
	{
	$hms = '';

	$hours = intval(intval($sec) / 3600);
	if ($hours != '0') {
	    $hms .= ($padHours)
	          ? str_pad($hours, 2, '0', STR_PAD_LEFT). ':'
	          : $hours. ':';
	}
	$minutes = intval(($sec / 60) % 60);
	$hms .= str_pad($minutes, 2, '0', STR_PAD_LEFT). ':';

	$seconds = intval($sec % 60);
	$hms .= str_pad($seconds, 2, '0', STR_PAD_LEFT);

	return $hms;
	}

	protected function cache_file($file) // check for cache life time
	{
		return file_exists($file) && filemtime($file) > time() - $this->cachelife;
	}
}