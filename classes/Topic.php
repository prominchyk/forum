<?php
class Topic {
    private $title;
    private $text;
    private $date;

    public function __construct($title, $text, $date) {
        $this->title = $title;
        $this->text = $text;
        $this->date = $date;
    }

    public function __get($property) {
        if($property === 'title' or $property === 'text') {
            return preg_replace('#\'#', '’', $this->$property);
        } else {
            return $this->$property;
        }
    }

}
?>