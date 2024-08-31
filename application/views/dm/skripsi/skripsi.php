<section class="section">
    <div class="card">
        <div class="card-body" style="padding-top: 4rem;">

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-info alert-dismissible fade show" style="margin-top: 4rem;" role="alert">
                    <?php echo $this->session->flashdata('success'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">NPM</th>
                        <th scope="col">Mahasiswa</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Bidang</th>
                        <th scope="col">Pembimbing 1</th>
                        <th scope="col">Pembimbing 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($skripsi as $t) { ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $t->npm; ?></td>
                            <td><?= $t->nama_mahasiswa; ?></td>
                            <td><?= $t->judul; ?></td>
                            <td>
                                <?php
                                $bidang = $this->db->where('id', $t->bidang_id)->get('research_area')->row();
                                echo $bidang->nama;
                                ?>
                            </td>
                            <td>
                                <?php
                                $dosen1 = $this->db->where('id', $t->dospem_1_id)->get('users')->row();
                                echo $dosen1->nama;
                                ?>
                            </td>
                            <td>
                                <?php
                                $dosen2 = $this->db->where('id', $t->dospem_2_id)->get('users')->row();
                                echo $dosen2->nama;
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <a class="btn btn-primary position-absolute top-0 end-0 m-3" href="<?= base_url() ?>dm/add_skripsi" style="border-radius: 15px;">
                <i class="ri-add-line"></i>
                Tambah
            </a>

        </div>
    </div>
</section>