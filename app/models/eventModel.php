<?php

    class Event{
        private $db;
        private $queryCount;
        private $table = "events";

        function __construct($db){
            $this->db = $db;
        }

        public function getBadSuccess(){
            return $this->db->query("SELECT E.* FROM events E WHERE (SELECT COUNT(*) FROM tickets T, events E WHERE T.id_e = E.id AND E.date - T.date > 5) <= E.tot_tickets / 2")->FetchAll();
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
                    $res = $this->db->query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM $this->table E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type AND G.genre = ? AND T.type = ?" , [$genrefilter , $typefilter])->FetchAll();
                    if (!$res){
                        $res = "Error";
                    }
    
                }else{
                    
                        if($genrefilter || $typefilter){
                            $filter = ($genrefilter == NULL ? $typefilter : $genrefilter);
                            $queryFilter = ($genrefilter == NULL ? "T.type = ?" : "G.genre = ?");
        
                            $res = $this->db->query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM $this->table E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type AND $queryFilter" , [$filter])->FetchAll();
                            if (!$res){
                                $res = "Error";
                            }
                        }else{
                            $res = $this->db->query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM $this->table E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type")->FetchAll();
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

        public function create($title , $img_src, $date , $hour , $ticket_price , $artists , $genre, $type, $tot_tickets, $id_place){
            
            $this->queryCount +=1;
            
            
            $id_genre = $this->db->query("SELECT id FROM genres WHERE genre = ?" , [$genre])->FetchOne()["id"];
            $id_type = $this->db->query("SELECT id FROM types WHERE type = ?" , [$type])->FetchOne()["id"];

            $params = [$title ,$id_type , $id_genre , $img_src , $date , $hour , $ticket_price , $artists , $tot_tickets, $id_place];

            //print_r($params);
            
            $res = $this->db->query("INSERT INTO $this->table (title , id_type , id_genre ,img_src , date , hour , ticket_price , artists, tot_tickets, discounted, place_id) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , 0, ?)" , $params );

            
            return $res;

        }

        public function getAllType(){
            $this->queryCount +=1;

            $res = $this->db->query("SELECT * FROM types")->FetchAll();

            return $res;
        }

        public function getOne($title){
            $this->queryCount +=1;

            $res = $this->db->query("SELECT * FROM $this->table E, places P WHERE P.id = E.place_id AND title = ?" , [$title])->FetchOne();

            return $res;
        }

        public function addWishList($title , $username,$case){
            $this->queryCount +=1 ;
            $id = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

            //$table= ($case == 0? "prefer_events" : "like_events");

            if($case == 1 && $this->db->query("SELECT * FROM prefer_events WHERE id_e = ? AND username = ?" , [$id,$username])->FetchOne()){
                $query = "DELETE FROM prefer_events WHERE username = ? AND id_e = ? AND caso = ?";
            }else{
                $query = "INSERT INTO prefer_events (username , id_e, caso) VALUES ( ? , ? , ?)";
            }

            $res = $this->db->query($query , [$username , $id, $case]);
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

            return $this->db->query("SELECT * FROM prefer_events WHERE id_e = ? AND username = ? AND caso = 1" , [$id,$username])->FetchOne();
        }

        public function removeOneWishList($username , $title){

            $this->queryCount += 1;
           
            $id_e = $this->db->query("SELECT id FROM events WHERE title = ?" , [$title])->FetchOne()["id"];

            $res = $this->db->query("DELETE FROM prefer_events WHERE id_e= ? AND username = ? AND caso = 0" , [$id_e,$username]);

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

        public function es1(){
            $this->queryCount += 1;

            $res = $this->db->query(     
                "SELECT 
                    COUNT(*) AS 'next_month_tickets', E.title
                FROM EVENTS
                        E,
                        tickets T
                WHERE
                        E.id = T.id_e AND MONTH(E.date) = MONTH(CURRENT_DATE) + 1
                GROUP BY
                        E.title
                ORDER BY
                        next_month_tickets
                DESC
                LIMIT 1
                ")->FetchOne();
            return $res;


        }

        public function es2(){
            $this->queryCount += 1;

            $res = $this->db->query(     
                "SELECT
                        SUM(E.ticket_price) AS 'somma_rock'
                FROM EVENTS
                        E,
                        genres G,
                        tickets T
                WHERE
                        E.id = T.id_e AND G.id = E.id_genre AND MONTH(E.date) > MONTH(CURRENT_DATE) - 6 AND G.genre = 'rock'
                ")->FetchOne();
            return $res;
        }

        public function es3(){
            $this->queryCount += 1;

            $res = $this->db->query(     
                "SELECT 
                    COUNT(*) as 'num_eventi' , MONTH(E.date) as 'mese'
                FROM 
                    events E 
                WHERE 
                    YEAR(CURRENT_DATE) = YEAR(E.date) 
                GROUP BY 
                    MONTH(E.date)
                ORDER BY 
                    num_eventi DESC
                LIMIT 1
                ")->FetchOne();
            return $res;
        }

        public function getRemanaintTickets($title){
            $res = $this->db->query("SELECT E.tot_tickets - 
                (
                    SELECT COUNT(*) FROM tickets T, events E WHERE T.id_e = E.id AND E.title = ?
                ) as 'remain_tickets'
                
                FROM events E WHERE E.title = ? " , [$title, $title])->FetchOne()["remain_tickets"];

            return $res;
        }

    }


    
?>