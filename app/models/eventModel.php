<?php

    class Event{
        private $db;
        private $queryCount;
        private $table = "events";

        function __construct($db){
            $this->db = $db;
        }

        public function getBadSuccess(){
            return $this->db->query("SELECT E.* FROM events E WHERE (SELECT COUNT(*) FROM tickets T, events E WHERE T.id_e = E.id AND E.date - T.date <= 5) <= E.tot_tickets / 2")->FetchAll();
        }
        public function discount($title, $percent){
            $this->queryCount +=1;
            $res = $this->db->query("UPDATE events SET ticket_price = ticket_price - (ticket_price / 100 * ?) WHERE title = ?" , [$percent , $title]);

            return $res;
        }

        public function getDiscount($title){
            $this->queryCount +=1;
            $res = $this->db->query("SELECT discounted FROM $this->table WHERE title = ?" , [$title])->FetchOne()["discounted"];

            return $res;
        }

        public function getAll($genrefilter , $typefilter , $bad_success){
            $this->queryCount +=1;

            if($bad_success){
                $res = $this->getBadSuccess();
                    if (!$res){
                        $res = "Error";
                    }
            }else{
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
            }

            

            return $res;

        }

        public function exist($title){
            $res = $this->db->select("*")->from($this->table)->where("title = ?")->params([$title])->FetchOne();

            return ($res ? true : false );
        }

        public function create($title , $img_src , $location , $date , $hour , $ticket_price , $artists , $genre, $type, $tot_tickets){
            
            $this->queryCount +=1;
            
            
            $id_genre = $this->db->query("SELECT id FROM genres WHERE genre = ?" , [$genre])->FetchOne()["id"];
            $id_type = $this->db->query("SELECT id FROM types WHERE type = ?" , [$type])->FetchOne()["id"];

            $params = [$title ,$id_type , $id_genre , $img_src , $location , $date , $hour , $ticket_price , $artists , $tot_tickets];

            //print_r($params);
            
            $res = $this->db->query("INSERT INTO $this->table (title , id_type , id_genre ,img_src , location , date , hour , ticket_price , artists, tot_tickets, discounted) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , ?, 0)" , $params );

            
            return $res;

        }

        public function getOne($title){
            $this->queryCount +=1;

            $res = $this->db->query("SELECT * FROM $this->table WHERE title = ?" , [$title])->FetchOne();

            return $res;
        }

        public function addWishList($title , $username,$case){
            $this->queryCount +=1 ;
            $id = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

            $table= ($case == 0? "prefer_events" : "like_events");

            if($case == 1 && $this->db->query("SELECT * FROM $table WHERE id_e = ? AND username = ?" , [$id,$username])->FetchOne()){
                $query = "DELETE FROM $table WHERE username = ? AND id_e = ?";
            }else{
                $query = "INSERT INTO $table (username , id_e) VALUES ( ? , ? )";
            }

            $res = $this->db->query($query , [$username , $id]);
            return $res;

        }

        public function getAllWishList($username){
            $this->queryCount += 1;

            $res = $this->db->query("SELECT E.title FROM events E , prefer_events P WHERE P.id_e = E.id AND username = ?" , [$username])->FetchAll();

            return $res;

        }
        
        public function existLikeList($title , $username){
            $this->queryCount += 1;
            $id = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

            return $this->db->query("SELECT * FROM like_events WHERE id_e = ? AND username = ?" , [$id,$username])->FetchOne();
        }

        public function removeOneWishList($username , $title){

            $this->queryCount += 1;
           
            $id_e = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

            $res = $this->db->query("DELETE FROM prefer_events WHERE id_e= ? AND username = ?" , [$id_e,$username]);

            return $res;
        }

        public function getCostByTitle($title){
            $this->queryCount += 1;
            $res = $this->db->query("SELECT ticket_price FROM events WHERE title = ?" , [$title])->FetchOne();
            if(!$res){
                $out = $res;
            }else{
                $out = $res["ticket_price"];
            }
            return $out;

        }

        public function getTotTcikets($title){
            $this->queryCount += 1;

            $res = $this->db->query("SELECT tot_tickets FROM events WHERE title = ?" , [$title])->FetchOne()["tot_tickets"];

            return $res;

        }

    }

?>