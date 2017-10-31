<?php


	class DB{

		private $_hostname = "localhost";
		private $_hostuser = "root";
		private $_hostpass = "";
		private $_hostdb = "laravel_4";

		public $conn;

		public function __construct(){

			$this->connection();

		}



		public function connection(){

			$this->conn = new mysqli($this->_hostname,$this->_hostuser,$this->_hostpass,$this->_hostdb);
			return $this->conn?true:false;

			/*if($this->conn){
				return $this->conn;
			}
			else
			{
				return false;

			}*/

		}

		public function marksheet($roll)
		{

			$sql = "Select * from first_semester where roll_no='$roll' ";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			       return "Your marks are as follows :: Information Technology:".$row['IT']."     ".
			       "C Programming:".$row['C']."              ".
			       "Calculus:".$row['calculus']."              ".
			       "Probability and Statistics:".$row['prob']."    ".
			       "Statistics:".$row['stat']."            ".
			       "Total:".$row['total']."               ".
			       "Percentage:".$row['percentage']."%";



			    	


			    }
			}
			 else {
			    return "No records were found!! Please enter roll number again";
			}

			return $roll;
		}

	public function result($roll)
		{
			
			$sql = "Select result from first_semester where roll_no='$roll' ";
			$result = $this->conn->query($sql);

			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        return  $row['result'];

			    }
			}
			 else {
			    return "No records were found!! Please enter roll number again";
			}
			
			 
		}


		public function roll($roll)
		{
			$sql = "Insert into roll(roll) values($roll)";

			$this->conn->query($sql);
			    
		}

		public function getroll()
		{
			$sql = "Select * from roll order by id desc limit 1";
			$result = $this->conn->query($sql);
			if ($result->num_rows > 0) {
			    // output data of each row
			    while($row = $result->fetch_assoc()) {
			        return  $row['roll'];

			    }
			}
			 else {
			    return "No records were found!! Please enter roll number again";
			}

		}


	}
