<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Progress Wizard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"> <!-- Font Awesome for icons -->
  <style>
    .wizard-step {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      position: relative;
      text-align: center;
    }

    .wizard-step::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 4px;
      background-color: #e9ecef;
      top: 50%;
      left: 50%;
      z-index: -1;
      transform: translateX(-50%);
    }

    .wizard-step:first-child::before {
      content: none;
    }

    .wizard-step.completed::before {
      background-color: #0d6efd;
    }

    .wizard-step-circle {
      width: 50px;
      height: 50px;
      background-color: #e9ecef;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: #495057;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .wizard-step.completed .wizard-step-circle,
    .wizard-step.active .wizard-step-circle {
      background-color: #0d6efd;
      color: white;
    }

    .wizard-step-label {
      margin-top: 10px;
      font-size: 14px;
      color: #495057;
      font-weight: 600;
    }

    .wizard-step.active .wizard-step-label,
    .wizard-step.completed .wizard-step-label {
      color: #0d6efd;
    }

    .wizard-step .wizard-step-circle i {
      font-size: 18px;
    }

    .wizard-step.active .wizard-step-circle i,
    .wizard-step.completed .wizard-step-circle i {
      color: white;
    }

    .wizard-step:hover .wizard-step-label {
      color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="container my-5">
    <div class="row">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
          <div class="wizard-step completed">
            <div class="wizard-step-circle"><i class="fa-solid fa-check"></i></div>
            <div class="wizard-step-label">Pengajuan Judul</div>
          </div>
          <div class="wizard-step completed">
            <div class="wizard-step-circle"><i class="fa-solid fa-check"></i></div>
            <div class="wizard-step-label">Judul Diterima</div>
          </div>
          <div class="wizard-step active">
            <div class="wizard-step-circle"><i class="fa-solid fa-pen"></i></div>
            <div class="wizard-step-label">Bimbingan</div>
          </div>
          <div class="wizard-step">
            <div class="wizard-step-circle"><i class="fa-solid fa-file"></i></div>
            <div class="wizard-step-label">Proposal</div>
          </div>
          <div class="wizard-step">
            <div class="wizard-step-circle"><i class="fa-solid fa-graduation-cap"></i></div>
            <div class="wizard-step-label">Skripsi</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script> <!-- Font Awesome for icons -->
</body>

</html>