<?php
    require_once "vendor/autoload.php";
    
    require_once "bootstrap.php";

    class Article
    {
        /**
         * @get
         */
        private int $id;
        /**
         * @get
         * @set
         */
        private string $headline;
        /**
         * @get
         * @set
         */
        private string $content;
        public function __construct(){}
        private function __clone(){}
        /**
         * Getter for id
         */
        public function getId()
        {
            return $this->id;
        }

        /**
         * Getters and Setters for headline
         */
        public function getHeadline()
        {
            return $this->headline;
        }
        public function setHeadline(string $headline): self
        {
            $this->headline = $headline;
            return $this;
        }
        /////////////////////////////////////////
        /**
         * Getters and Setters for content
         */
        public function getContent()
        {
            return $this->content;
        }
        public function setContent(string $content)
        {
            $this->content = $content;
            return $this;
        }
        public static function find($id)
        {
            
        }
    }
?>