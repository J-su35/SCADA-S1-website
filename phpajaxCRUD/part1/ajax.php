<?php
	if (isset($_POST['key'])) {

		$conn = new mysqli('localhost', 'root', '123456', 'testing');

		if ($_POST['key'] == 'getExistingData') {
			$start = $conn->real_escape_string($_POST['start']);
			$limit = $conn->real_escape_string($_POST['limit']);

			$sql = $conn->query("SELECT id, countryName FROM country LIMIT $start, $limit");
			if ($sql->num_rows > 0) {
				$response = "";
				while($data = $sql->fetch_array()) {
					$response .= '
						<tr>
							<td>'.$data["id"].'</td>
							<td>'.$data["countryName"].'</td>
							<td>
								<input type="button" value="Edit" class="btn btn-primary">
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
