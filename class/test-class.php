<?php
	//print("test".sqlsrv_connect("ADZS_ONLINE-PC1", array("Database"=>"testDatabase")));
	class test_class {
		public $conn;

		/*public function selectMenuOptions() {
			$tsql = "{call testDatabase.dbo.selectMenuOptions}";
			$stmt = sqlsrv_prepare($this->conn, $tsql);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$rows[] = $row;
			}
			return $rows;
		}*/
		
		public function selectUsers() {
			$tsql = "{call testDatabase.dbo.selectUsers}";
			$stmt = sqlsrv_prepare($this->conn, $tsql);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$rows[] = $row;
			}
			return $rows;
		}

		public function selectUserDetails($data) {
			$tsql = "{call testDatabase.dbo.selectUserDetails(?)}";
			$params = array(
				array($data['id'], SQLSRV_PARAM_IN)
			);
			$stmt = sqlsrv_prepare($this->conn, $tsql, $params);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				return $row;
			}
		}
		
		public function selectAccountNames() {
			$tsql = "{call testDatabase.dbo.selectAccountNames}";
			$stmt = sqlsrv_prepare($this->conn, $tsql);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				$rows[] = $row;
			}
			return $rows;
		}

		public function addUserDetails($data) {
			$data['passwordEncrypted'] = password_hash($data['password'],PASSWORD_DEFAULT);
			/*$data['passwordEncrypted'] = str_replace("$", "\$", $data['passwordEncrypted']);*/
			
			if (password_verify($data['password'], $data['passwordEncrypted'])) {
				$tsql = "{call testDatabase.dbo.addUserDetails(?,?,?,?,?,?,?,?)}";
				$params = array(
					array($data['username'], SQLSRV_PARAM_IN),
					array($data['passwordEncrypted'], SQLSRV_PARAM_IN),
					array($data['name'], SQLSRV_PARAM_IN),
					array($data['address1'], SQLSRV_PARAM_IN),
					array($data['address2'], SQLSRV_PARAM_IN),
					array($data['city'], SQLSRV_PARAM_IN),
					array($data['countyState'], SQLSRV_PARAM_IN),
					array($data['postcode'], SQLSRV_PARAM_IN)
				);
				$stmt = sqlsrv_prepare($this->conn, $tsql, $params);
				if (!sqlsrv_execute($stmt)) {
					die(print_r(sqlsrv_errors(), true));
				}
				return array("success"=>true);
			} else {
				return array("success"=>false, "error"=>"Password could not hash.");
			}
		}

		public function editUserDetails($data) {
			$passwordFlag = false;
			if ($data['newPassword'] != "") {
				$passwordFlag = true;
				$data['passwordEncrypted'] = password_hash($data['newPassword'],PASSWORD_DEFAULT);
			} else {
				$data['passwordEncrypted'] = NULL;
			}
			
			if ( !$passwordFlag || ($passwordFlag && password_verify($data['newPassword'], $data['passwordEncrypted'])) ) {
				$tsql = "{call testDatabase.dbo.editUserDetails(?,?,?,?,?,?,?,?)}";
				$params = array(
					array($data['users'], SQLSRV_PARAM_IN),
					array($data['passwordEncrypted'], SQLSRV_PARAM_IN),
					array($data['name'], SQLSRV_PARAM_IN),
					array($data['address1'], SQLSRV_PARAM_IN),
					array($data['address2'], SQLSRV_PARAM_IN),
					array($data['city'], SQLSRV_PARAM_IN),
					array($data['countyState'], SQLSRV_PARAM_IN),
					array($data['postcode'], SQLSRV_PARAM_IN)
				);
				$stmt = sqlsrv_prepare($this->conn, $tsql, $params);
				if (!sqlsrv_execute($stmt)) {
					die(print_r(sqlsrv_errors(), true));
				}
				return array("success"=>true);
			} else {
				return array("success"=>false, "error"=>"Password could not hash.");
			}
		}

		public function selectUserPassword($data) {
			$tsql = "{call testDatabase.dbo.selectUserPassword(?)}";
			$params = array(
				array($data['id'], SQLSRV_PARAM_IN)
			);
			$stmt = sqlsrv_prepare($this->conn, $tsql, $params);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
				return $row;
			}
		}

		public function deleteAccount($data) {
			$tsql = "{call testDatabase.dbo.deleteAccount(?)}";
			$params = array(
				array($data['id'], SQLSRV_PARAM_IN)
			);
			$stmt = sqlsrv_prepare($this->conn, $tsql, $params);
			if (!sqlsrv_execute($stmt)) {
				die(print_r(sqlsrv_errors(), true));
			}
			return array("success"=>true);
		}
	}
?>