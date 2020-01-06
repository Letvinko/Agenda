<?php foreach ($res as $bigRow) {
    echo ('<div class="container">
                                <td class="smallrow" colspan="5"></td>
                                <tr></tr>
								<tr></tr>');
    if (empty($bigRow)) {
        echo '<td>';
        echo '<td colspan="3"> Tidak ada acara <td>';
        echo '</td>';
        echo '<tr>';
    } else {
        foreach ($bigRow as $data) {
            echo '<td>';
            // echo json_encode($data);
            echo "<td>" . $data["time_start"] . "-" . $data["time_ends"] . "<td>" . $data["judul_agenda"] . "<td>" . $data["isi_agenda"] . "<td>" . $data["penanggung_jawab"];
            echo '</td>';
            echo '<tr>';
        }
    }
    echo '</div>';
}
