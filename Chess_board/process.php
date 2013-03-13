<?php

	$data = "<table>";
		for ($i=0; $i < $_POST['width']; $i++) {
			if ($i % 2) {
				$data .= "<tr>";
				for ($j=0; $j < $_POST['height']; $j++) { 
					if ($j % 2) {
						$data .= "<td class='color'></td>";
					}
					else {
						$data .= "<td></td>";
					}
				}
				$data .= "</tr>";
			}
			else {
				$data .= "<tr>";
				for ($j=0; $j < $_POST['height']; $j++) { 
					if ($j % 2) {
						$data .= "<td></td>";
					}
					else {
						$data .= "<td class='color'></td>";
					}
				}
				$data .= "</tr>";	
			}
		}
	$data .= "</table>";

	echo json_encode($data);

	?>