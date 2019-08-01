<?php

/**
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class Push {

    // push message title
    private $title;
    private $message;
    private $image;
    private $data;
	private $date;
	private $from;
	
    // flag indicating whether to show the push
    // notification or not
    // this flag will be useful when perform some opertation
    // in background when push is recevied
    private $is_background;

    function __construct() {
        
    }
	public function setExtra($data){
		$this->data = $data;
	}
	
	public function setFrom($from){
		$this->from = $from;
	}
	
	public function setDate($timestamp){
		$this->date = $timestamp;
	}
	
    public function setTitle($title) {
        $this->title = $title;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function setImage($imageUrl) {
        $this->image = $imageUrl;
    }

    public function setIsBackground($is_background) {
        $this->is_background = $is_background;
    }

    public function getPush() {
        $res = array();
        $res['data']['title'] = $this->title;
		$res['data']['from'] = $this->from;
        $res['data']['message'] = $this->message;
        $res['data']['image'] = $this->image;
        $res['data']['is_background'] = $this->is_background;
        $res['data']['timestamp'] = $this->date;
		$res['data']['extra'] = $this->data;
        return $res;
    }

}
