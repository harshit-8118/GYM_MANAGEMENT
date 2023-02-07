<?php 

    class Database{
        private $db_host = "hostname";
        private $db_user = "dbuser";
        private $db_pass = "dbpass";
        private $db_name = "dbname";

        private $mysqli = '';
        private $result = array();
        private $conn = false;

        public function __construct(){
            if(!$this->conn){
                $this->conn = true;
                $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
                if($this->mysqli->connect_error){
                    array_push($this->result, $this->mysqli->connect_error);
                    return false;
                }else{
                    return true;
                }
            }
        }

        public function tableExists($table){
            $sql = "SHOW TABLES FROM $this->db_name LIKE '$table'";

            $allTables = $this->mysqli->query($sql);
            if($allTables){
                if($allTables->num_rows == 1){
                    return true;
                }else{
                    array_push($this->result, $table." doesn't exists");
                    return false;
                }
            }
        }   

        // insert into database;
        public function insert($table, $attrs = array()){
            if($this->tableExists($table)){
                $table_columns = implode(',', array_keys($attrs));
                $table_values = implode("','", $attrs);
                // echo $table_columns."<br>". $table_values;
                // exit();
                $sql = "INSERT INTO $table ($table_columns) VALUES ('$table_values')";
                if($this->mysqli->query($sql)){
                    array_push($this->result, $this->mysqli->insert_id);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }else{
                return false;
            }
        }

        public function update($table, $attrs = array(), $where = null){
            if($this->tableExists($table)){

                $args = array();
                foreach($attrs as $key=>$val){
                    $args[] = "$key = '$val'";
                }
                $sql = "UPDATE $table SET ".implode(", ", $args);
                if($where != null){
                    $sql .= " WHERE $where";
                }
                // echo $sql;
                // die();
                if($this->mysqli->query($sql)){
                    array_push($this->result, $this->mysqli->affected_rows);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }else{
                return false;
            }
        }

        public function delete($table, $where = null){
            if($this->tableExists($table)){

                $sql = "DELETE FROM $table";
                if($where != null){
                    $sql .= " WHERE $where";
                }
                echo $sql;
                // die();
                if($this->mysqli->query($sql)){
                    array_push($this->result, $this->mysqli->affected_rows);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }else{
                return false;
            }
        }
        

        public function select($table, $rows = "*", $join = null, $where = null, $order = null, $limit = null){
            if($this->tableExists($table)){

                $sql = "SELECT $rows FROM $table";
                if($join != null){
                    $sql .= " JOIN $join";
                }
                if($where != null){
                    $sql .= " WHERE $where";
                }
                if($order != null){
                    $sql .= " ORDER BY $order";
                }
                if($limit != null){
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $start = ($page - 1) * $limit;
                    $sql .= " LIMIT $start, $limit";
                }

                if($this->mysqli->query($sql)){
                    $query = $this->mysqli->query($sql);
                    $this->result = $query->fetch_all(MYSQLI_ASSOC);
                    return true;
                }else{
                    array_push($this->result, $this->mysqli->error);
                    return false;
                }
            }else{
                return false;
            }
        }

        public function pagination($table, $join = null, $where = null, $limit = null){
            if($this->tableExists($table)){

                if($limit != null){
                    $sql = "SELECT COUNT(*) FROM $table";
                    if($join != null){
                        $sql .= " JOIN $join";
                    }
                    if($where != null){
                        $sql .= " WHERE $where";
                    }

                    $query = $this->mysqli->query($sql);
                    $total_records = $query->fetch_array();
                    $total_records = $total_records[0];

                    $total_pages = ceil($total_records / $limit);

                    $url = basename($_SERVER['PHP_SELF']);
                    if(isset($_GET['page'])){
                        $page = $_GET['page'];
                    }else{
                        $page = 1;
                    }
                    $output = "<ul class='pagination'>";
                    if($page > 1){
                        $output .= "<li><a href='$url?page=".($page - 1)."'>Prev</a></li>";
                    }
                    if($total_records > $limit){
                        for($i = 1; i <= $total_pages; $i++){
                            if($i == $page){
                                $cls = "class='active'";
                            }else{
                                $cls = "";
                            }
                            $output .= "<li $cls ><a href='$url?page=$i'>$i</a></li>";
                        }
                    }
                    if($total_pages > $page){
                        $output .= "<li><a href='$url?page=".($page + 1)."'>Next</a></li>";
                    }
                    $output .= "</ul>";

                    return $output;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        public function sql($sql){
            $query = $this->mysqli->query($sql);
      
            if($query){
              $this->result = $query->fetch_all(MYSQLI_ASSOC);
              return true;
            }else{
              array_push($this->result, $this->mysqli->error);
              return false;
            }
        }

        public function getResult(){
            $arr = $this->result;
            $this->result = array();
            return $arr;
        }

        public function escapeString($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $this->mysqli->real_escape_string($data);
        }

        public function __destruct(){
            if($this->conn){
                if($this->mysqli->close()){
                    $this->conn = false;
                    return true;
                }
            }else return false;
        }

    }

?>