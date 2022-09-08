<?php
if (!$data) {
    echo '<tr class="row_0"><td colspan="5" align="center">Tidak ada data jadwal poli</td></tr>';
} else {
    foreach ($data as $item) {
        ?>
        <tr class="row_<?= $item->id ?>">
            <td><?= $this->conv->hariIndo($item->hari) ?></td>
            <td><?= $item->open ?></td>
            <td><?= $item->close ?></td>
            <td><?= $item->quota ?></td>
            <td>
                <a title="Rubah Data" class="btn btn-primary" href="<?= site_url('admin/schedule_poli_edit/' . $item->id) ?>" onclick="show_modal(this);return false"><i class="fa fa-pencil"></i> Rubah</a>
                <a title="Hapus data" href="<?= site_url('admin/schedule_poli_delete/'.$item->id);?>" onclick="konfirmasi(this);return false" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</a>
            </td>
        </tr>
        <?php
    }
}