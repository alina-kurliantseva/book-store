<?php  
    class Book {
        private $id;
        private $title;
        private $price;
        function __construct($id, $title, $price) {
            $this->id = $id;
            $this->title = $title;
            $this->price = $price;
        }
        function setId($id) {
            $this->id = $id;
        }
        function setTitle($title) {
            $this->title = $title;
        }
        function setPrice($price) {
            $this->price = $price;
        }
        function getId() {
            return $this->id;
        }
        function getTitle() {
            return $this->title;
        }
        function getPrice() {
            return $this->price;
        }
        public static function cmp_title($a, $b) {
            $t1 = strtolower($a->title);
            $t2 = strtolower($b->title);
            if ($a->title == $b->title) {
                return 0;
            }
            return ($a->title > $b->title) ? +1 : -1;
        }
        public static function cmp_price($a, $b) {
            $p1 = strtolower($a->price);
            $p2 = strtolower($b->price);
            if ($a->title == $b->price) {
                return 0;
            }
            return ($a->price > $b->price) ? +1 : -1;
        }
    }    
    class BookFile extends SplFileObject {
        public function __construct($filePath) {
            parent::__construct($filePath);
        }
        public static function getAllBooks() {
            $booklist = array();
            $bookFile = new BookFile("./Contents/BookList.txt");
            foreach ($bookFile as $book):
                $arrayId = array();
                $idRegex = '/[a-zA-Z]{2}[0-9]{4}/';
                preg_match($idRegex, $book, $arrayId);
                $id = $arrayId[0];
                $arrayTitle = array();
                $titleRegex = '/[a-zA-Z\s]*/';
                preg_match($titleRegex, trim(substr($book, 6)), $arrayTitle);
                $title = $arrayTitle[0];
                $arrayPriceString = array();
                $priceRegex = '/\$[0-9]+(\.[0-9]{1,2})?/';
                preg_match($priceRegex, $book, $arrayPriceString);
                $priceString = strpos($book, '(Free!)') == TRUE ? 0 : $arrayPriceString[0]; 
                $arrayPriceInt = array();
                $priceIntRegex = '/[0-9]+(\.[0-9]{1,2})?/';
                preg_match($priceIntRegex, $priceString, $arrayPriceInt);
                $price = $arrayPriceInt[0];
                $book = new Book($id, $title, $price);
                array_push($booklist, $book);
            endforeach;
            return $booklist;
        }
    }

