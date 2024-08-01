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
                <th>Pembimbing</th>
                <th>Bab</th>
                <th>Pembahasan</th>
                <th>Bukti Bimbingan</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($data_proposal as $row) : ?>
                <tr>
                  <td><?php echo date('l, d F Y', strtotime($row->tanggal)); ?></td>
                  <td><?php echo $row->judul; ?></td>
                  <td><?php echo $row->nama_pembimbing; ?></td>
                  <td><?php echo $row->bab; ?></td>
                  <td><?php echo $row->pembahasan; ?></td>
                  <td>
                    <a href="<?php echo site_url('Progress_proposal/download_bukti/' . $row->id); ?>">
                      <button class="btn btn-success">Lihat</button>
                    </a>
                  </td>
                  <td><?php echo $row->status === 'approved' ? 'Diterima' : ($row->status === 'rejected' ? 'Ditolak' : 'Menunggu Disetujui'); ?></td>
                  <td width="15%">
                    <?php echo form_open('Progress_proposal/update_status/' . $row->id . '/' . $mahasiswa_id, ['id' => 'statusForm' . $row->id]); ?>
                    <?php echo form_hidden($this->security->get_csrf_token_name(), $this->security->get_csrf_hash()); ?>
                    <div class="d-flex gap-3 ">
                      <select name="status" class="form-control" onchange="document.getElementById('statusForm<?php echo $row->id; ?>').submit();">
                        <option value="pending" <?php if ($row->status == 'pending') echo 'selected'; ?>>Diproses</option>
                        <option value="approved" <?php if ($row->status == 'approved') echo 'selected'; ?>>Diterima</option>
                        <option value="rejected" <?php if ($row->status == 'rejected') echo 'selected'; ?>>Ditolak</option>
                      </select>
                    </div>
                    <?php echo form_close(); ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <!-- <a href="<?php echo site_url('Progress_proposal/download_log'); ?>">
                        <button class="btn btn-primary">Unduh Log</button>
                    </a> -->


        </div>
      </div>
    </div>
</section>

</html>