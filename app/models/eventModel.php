<?php

    class Event{
        private $db;
        private $queryCount;
        private $table = "events";

        function __construct($db){
            $this->db = $db;
        }

        public function getAll($genrefilter , $typefilter){
            $this->queryCount +=1;
            if ($genrefilter && $typefilter){
                $res = $this->db->query("SELECT * FROM $this->table E, genres G, types T WHERE G.id = E.id_genre AND T.id = E.id_type AND G.genre = ? AND T.type = ?" , [$genrefilter , $typefilter])->FetchAll();
                if (!$res){
                    $res = "Error";
                }

            }else{
                if($genrefilter || $typefilter){
                    $filter = ($genrefilter == NULL ? $typefilter : $genrefilter);
                    $queryFilter = ($genrefilter == NULL ? "T.type = ?" : "G.genre = ?");

                    $res = $this->db->query("SELECT * FROM $this->table E, genres G, types T WHERE G.id = E.id_genre AND T.id = E.id_type AND $queryFilter" , [$filter])->FetchAll();
                    if (!$res){
                        $res = "Error";
                    }
                }else{
                    $res = $this->db->query("SELECT * FROM $this->table E, genres G, types T WHERE G.id = E.id_genre AND T.id = E.id_type")->FetchAll();
                    if (!$res){
                        $res = "Error";
                    }
                }
                

            }

            return $res;

        }

        public function exist($title){
            $res = $this->db->select("*")->from($this->table)->where("title = ?")->params([$title])->FetchOne();

            return ($res ? true : false );
        }

        public function create($title , $img_src , $location , $date , $hour , $ticket_price , $selt_tickets , $artists , $genre, $type){
            
            $this->queryCount +=1;
            
            
            $id_genre = $this->db->query("SELECT id FROM genres WHERE genre = ?" , [$genre])->FetchOne()["id"];
            $id_type = $this->db->query("SELECT id FROM types WHERE type = ?" , [$type])->FetchOne()["id"];

            $params = [$title ,$id_type , $id_genre , $img_src , $location , $date , $hour , $ticket_price , $selt_tickets , $artists];

            //print_r($params);
            
            $res = $this->db->query("INSERT INTO $this->table (title , id_type , id_genre ,img_src , location , date , hour , ticket_price , selt_tickets , artists) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? ,?)" , $params );

            
            return $res;

        }

    }

?>