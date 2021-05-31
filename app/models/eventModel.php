<?php
    require_once "../../config/db.php";
    class Event{
        private static $db;
        private static $queryCount;
        private static $table = "events";

      

        public static function getBadSuccess(){
            Db::query("SELECT E.* FROM events E WHERE (SELECT COUNT(*) FROM tickets T, events E WHERE T.id_e = E.id AND E.date - T.date > 5) <= E.tot_tickets / 2");
            return Db::FetchAll();
        }
        
        public static function discount($title, $percent){
            self::$queryCount +=1;
            $res = Db::query("UPDATE events SET ticket_price = ticket_price - (ticket_price / 100 * ?) WHERE title = ?" , [$percent , $title]);

            return $res;
        }

        public static function getDiscount($title){
            self::$queryCount +=1;
            $res = Db::query("SELECT discounted FROM " . self::$table ." WHERE title = ?" , [$title])::FetchOne()["discounted"];

            return $res;
        }

        public static function getAll($genrefilter , $typefilter , $bad_success){
            self::$queryCount +=1;

            if($bad_success){
                $res = self::getBadSuccess();
                    if (!$res){
                        $res = "Error";
                    }
            }else{
                if ($genrefilter && $typefilter){
                    Db::query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM ".  self::$table ." E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type AND G.genre = ? AND T.type = ?" , [$genrefilter , $typefilter]);
                    $res = Db::FetchAll();
                    if (!$res){
                        $res = "Error";
                    }
    
                }else{
                    
                        if($genrefilter || $typefilter){
                            $filter = ($genrefilter == NULL ? $typefilter : $genrefilter);
                            $queryFilter = ($genrefilter == NULL ? "T.type = ?" : "G.genre = ?");
        
                            Db::query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM " . self::$table . " E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type AND $queryFilter" , [$filter]);
                            $res = Db::FetchAll();
                            if (!$res){
                                $res = "Error";
                            }
                        }else{
                            Db::query("SELECT E.*, P.place, P.city, P.nation, P.lat, P.lng FROM " . self::$table . " E, genres G, types T, places P WHERE E.place_id = P.id AND G.id = E.id_genre AND T.id = E.id_type");
                            $res = Db::FetchAll();
                            if (!$res){
                                $res = "Error";
                            }
                        }
                }
            }

            

            return $res;

        }

        public static function exist($title){
            Db::query("SELECT * FROM " . self::$table . "WHERE title = ?" , [$title]);
            $res = Db::FetchOne();

            return ($res ? true : false );
        }

        public static function create($title , $img_src, $date , $hour , $ticket_price , $artists , $genre, $type, $tot_tickets, $id_place){
            
            self::$queryCount +=1;
            
            Db::query("SELECT id FROM genres WHERE genre = ?" , [$genre]);
            $id_genre = Db::FetchOne()["id"];

            Db::query("SELECT id FROM types WHERE type = ?" , [$type]);
            $id_type = Db::FetchOne()["id"];

            $params = [$title ,$id_type , $id_genre , $img_src , $date , $hour , $ticket_price , $artists , $tot_tickets, $id_place];

            //print_r($params);
            
            $res = Db::query("INSERT INTO " . self::$table . " (title , id_type , id_genre ,img_src , date , hour , ticket_price , artists, tot_tickets, discounted, place_id) VALUES ( ? , ? , ? , ? , ? , ? , ? , ? , ? , 0, ?)" , $params );

            
            return $res;

        }

        

        public static function getOne($title){
            self::$queryCount +=1;

            Db::query("SELECT * FROM " . self::$table . " E, places P WHERE P.id = E.place_id AND title = ?" , [$title]);
            $res =Db::FetchOne();

            return $res;
        }

       
        public static function getCostByTitle($title){
            self::$queryCount += 1;
            Db::query("SELECT ticket_price FROM events WHERE title = ?" , [$title]);
            $res = Db::FetchOne();
            if(!$res){
                $out = $res;
            }else{
                $out = $res["ticket_price"];
            }
            return $out;

        }

        public static function getTotTickets($title){
            self::$queryCount += 1;

            Db::query("SELECT tot_tickets FROM events WHERE title = ?" , [$title]);
            $res = Db::FetchOne()["tot_tickets"];

            return $res;

        }

        public static function deleteOldEvents(){
            self::$queryCount += 1;
            Db::query("SELECT id FROM events WHERE date < CURRENT_DATE()");
            $ids = Db::FetchAll();
            $deltable = null;  
            foreach ($ids as $id){
            
                $tables = ["prefer_events" , "tickets"];
                foreach($tables as $table){
                    $deltable = Db::query("DELETE FROM $table WHERE id_e = ?" , [$id["id"]]);
                    if(!$deltable){
                        break;
                    }
                }

                $deltable = Db::query("DELETE FROM " . self::$table . " WHERE id = ?" , [$id["id"]]);

            }


            return $deltable;
        }

        public static function es1(){
            self::$queryCount += 1;

            Db::query(     
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
                LIMIT 5
                ");
            $res = Db::FetchAll();
            return $res;


        }

        public static function es2(){
            self::$queryCount += 1;

            Db::query(     
                "SELECT
                        SUM(E.ticket_price) AS 'somma_rock'
                FROM EVENTS
                        E,
                        genres G,
                        tickets T
                WHERE
                        E.id = T.id_e AND G.id = E.id_genre AND MONTH(E.date) > MONTH(CURRENT_DATE) - 6 AND G.genre = 'rock'
                ");
            $res = Db::FetchOne();
            return $res;
        }

        public static function es3(){
            self::$queryCount += 1;

            Db::query(     
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
                ");
            $res = Db::FetchOne();
            return $res;
        }

        public static function getRemanaintTickets($title){
            Db::query("SELECT E.tot_tickets - 
                (
                    SELECT COUNT(*) FROM tickets T, events E WHERE T.id_e = E.id AND E.title = ?
                ) as 'remain_tickets'
                
                FROM events E WHERE E.title = ? " , [$title, $title]);
            $res = Db::FetchOne()["remain_tickets"];

            return $res;
        }

    }


    
?>