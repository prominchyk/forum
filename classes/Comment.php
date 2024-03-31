<?php
class Comment {
    private $text = null;
    private $img = null;
    private $date;

    public function __construct($text, $img, $date) {
        $this->text = $text;
        $this->img = $img;
        $this->date = $date;
    }

    public function __get($property) {
        if($property === 'text') {
            return preg_replace('#\'#', '’', $this->$property);
        } else {
            return $this->$property;
        }
    }

}
?>