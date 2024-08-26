<html>
<section class="section">
    <div class="card">
        <div class="card-body">
            <div class="tab-content pt-2">
                <div class="tab-pane fade profile-overview active show" id="profile-overview" role="tabpanel">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Judul</th>
                                <!-- <th>Pembimbing</th>
                                <th>Bab</th> -->
                                <th>Pembahasan</th>
                                <th>Bukti Bimbingan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data_skripsi as $row) : ?>
                                <tr>
                                    <td><?php echo date('l, d F Y', strtotime($row->tanggal)); ?></td>
                                    <td><?php echo $row->judul; ?></td>
                                    <!-- <td><?php echo $row->nama_pembimbing; ?></td>
                                    <td><?php echo $row->bab; ?></td> -->
                                    <td><?php echo $row->pembahasan; ?></td>
                                    <td>
                                        <!-- <a href="<?php echo site_url('Progress_skripsi/download_bukti/' . $row->id); ?>">
                                            <button class="btn btn-success">unduh</button>
                                        </a> -->

                                        <!-- 13/08 -->
                                        <a class="btn btn-primary" href="<?= base_url() ?>progress_skripsi/view_file/bukti/<?= $row->bukti; ?>">Lihat</a>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        switch ($row->status) {
                                            case 'approved':
                                                $statusClass = 'badge bg-success';
                                                $statusText = 'Disetujui';
                                                break;
                                            case 'rejected':
                                                $statusClass = 'badge bg-danger';
                                                $statusText = 'Ditolak';
                                                break;
                                            case 'pending':
                                            default:
                                                $statusClass = 'badge bg-warning text-dark';
                                                $statusText = 'pilih';
                                                break;
                                        }
                                        ?>
                                        <span class="badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                                    </td>
                                    <td width="15%">
                                        <?php echo form_open('Progress_skripsi/update_status/' . $row->id . '/' . $mahasiswa_id, ['id' => 'statusForm' . $row->id]); ?>
                                        <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                                        <div class="d-flex gap-3 ">
                                            <select name="status" class="form-control" onchange="document.getElementById('statusForm<?php echo $row->id; ?>').submit();">
                                                <option value="pending" <?php if ($row->status == 'pending') echo 'selected'; ?>>Pilih</option>
                                                <option value="approved" <?php if ($row->status == 'approved') echo 'selected'; ?>>Disetujui</option>
                                                <option value="rejected" <?php if ($row->status == 'rejected') echo 'selected'; ?>>Ditolak</option>
                                            </select>
                                        </div>
                                        <?php echo form_close(); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- <a href="<?php echo site_url('Progress_skripsi/download_log'); ?>">
                        <button class="btn btn-primary">Unduh Log</button>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</section>

</html>