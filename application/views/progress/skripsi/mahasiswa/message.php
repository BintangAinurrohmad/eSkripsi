<!DOCTYPE html>
<html>
<div class="card">

  <div class="card-body">
    <!--<h5 class="card-title">General Form Elements</h5>-->

    <!-- General Form Elements 
              <form>
                <div class="row mb-3 mt-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">Tanggal</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputJudul" class="col-sm-2 col-form-label">Judul</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control">
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Pembimbing</label>
                  <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example">
                      <option selected="">Pilih</option>
                      <option value="1">david</option>
                      <option value="2">satria</option>
                      <option value="3">aziz</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label">Bab</label>
                  <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example">
                      <option selected="">Pilih</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                    </select>
                  </div>
                </div>

                <div class="row mb-3">
                <label for="inputTentang" class="col-sm-2 col-form-label">Pembahasan</label>
                  <div class="col-sm-10">
                    <input type="Tentang" class="form-control">
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputNumber" class="col-sm-2 col-form-label">Bukti</label>
                  <div class="col-sm-10">
                    <input class="form-control" type="file" id="formFile">
                  </div>
                </div>

                <div class="row mb-3">
                  <label class="col-sm-2 col-form-label"></label>
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Selesai</button>
                  </div>
                </div>

              </form> End General Form Elements -->



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
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>

  </div>
</div>

</html>