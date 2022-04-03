<?php
	if (isset($_POST['key'])) {

		$conn = new mysqli('localhost', 'root', '123456', 'login');

		if ($_POST['key'] == 'getRowData') {
			$rowID = $conn->real_escape_string($_POST['rowID']);
			$sql = $conn->query("SELECT * FROM broken_equipment LIMIT $start, $limit");
			// $sql = $conn->query("SELECT countryName, shortDesc, longDesc FROM country WHERE id='$rowID'");
			$data = $sql->fetch_array();
			$jsonArray = array(
				'countryName' => $data['countryName'],
				'shortDesc' => $data['shortDesc'],
				'longDesc' => $data['longDesc'],
			);

			exit(json_encode($jsonArray));
 		}

		if ($_POST['key'] == 'getExistingData') {
			$start = $conn->real_escape_string($_POST['start']);
			$limit = $conn->real_escape_string($_POST['limit']);

			$sql = $conn->query("SELECT id, countryName FROM country LIMIT $start, $limit");
			if ($sql->num_rows > 0) {
				$response = "";
				while($data = $sql->fetch_array()) {
					$response .= '
						<tr>
							<td>'.$data["JId"].'</td>
							<td>'.$data["catgories"].'</td>
							<td>'.$data["equip_code"].'</td>
							<td>'.$data["date"].'</td>
							<td>'.$data["detail"].'</td>
							<td>'.$data["status"].'</td>
							<td>'.$data["priority"].'</td>
							<td>
								<input type="button" onclick="edit('.$data["id"].')" value="Edit" class="btn btn-primary">
								<input type="button" value="View" class="btn">
								<input type="button" value="Delete" class="btn btn-danger">
							</td>
						</tr>
					';
				}
				exit($response);
			} else
				exit('reachedMax');
		}

		$name = $conn->real_escape_string($_POST['name']);
		$shortDesc = $conn->real_escape_string($_POST['shortDesc']);
		$longDesc = $conn->real_escape_string($_POST['longDesc']);
		$rowID = $conn->real_escape_string($_POST['rowID']);

		if ($_POST['key'] == 'updateRow') {
			$conn->query("UPDATE country SET countryName='$name', shortDesc='$shortDesc', longDesc='$longDesc' WHERE id='$rowID'");
			exit('success');
		}

		if ($_POST['key'] == 'addNew') {
			$sql = $conn->query("SELECT id FROM country WHERE countryName = '$name'");
			if ($sql->num_rows > 0)
				exit("Country With This Name Already Exists!");
			else {
				$conn->query("INSERT INTO country (countryName, shortDesc, longDesc)
							VALUES ('$name', '$shortDesc', '$longDesc')");
				exit('Country Has Been Inserted!');
			}
		}
	}
?>
