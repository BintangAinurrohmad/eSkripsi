<!DOCTYPE html>
<html>
<div class="card">

  <div class="card-body">
    <!--<h5 class="card-title">General Form Elements</h5>-->

    <head>
      <title>Progress Proposal</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
      <div class="container">
        <h1>Input Bimbingan</h1>

        <?php if (isset($error)) { ?>
          <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
          </div>
        <?php } ?>

        <?php if (isset($success)) { ?>
          <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
          </div>
        <?php } ?>

        <form method="post" action="<?php echo base_url('progress_proposal/insert_bimbingan'); ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo date('d-m-Y'); ?>">
          </div>

          <div class="form-group">
            <label for="bab">judul</label>
            <select class="form-control" id="judul" name="judul">
              <option value="<?php echo $judul_list->id; ?>"><?php echo $judul_list->judul; ?></option>
            </select>
          </div>

          <div class="form-group">
            <label for="pembimbing">Pembimbing</label>
            <select class="form-control" id="pembimbing" name="pembimbing">
              <?php foreach ($pembimbing_list as $pembimbing) : ?>
                <option value="<?php echo $pembimbing->id; ?>"><?php echo $pembimbing->nama; ?> - <?php echo $pembimbing->role; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- 
          <div class="form-group">
            <label for="bab">Bab</label>
            <select class="form-control" id="bab" name="bab">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div> -->

          <div class="form-group">
            <label for="pembahasan">Pembahasan</label>
            <textarea class="form-control" id="pembahasan" name="pembahasan" rows="5" placeholder="Masukkan Pembahasan"></textarea>
          </div>

          <!-- 13/08 -->
          <div class="form-group">
            <label for="bukti">Bukti (jpg png pdf, maks. 1 mb)</label>
            <input type="file" class="form-control-file" id="bukti" name="bukti" 
            accept="image/png, image/gif, image/jpeg, application/pdf">
          </div>

          <button type="submit" class="btn btn-primary">Selesai</button>
        </form>
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

  </div>
</div>

</html>