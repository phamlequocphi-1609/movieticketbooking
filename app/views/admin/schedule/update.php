<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/img/favicon.png" rel="icon">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo __WEB_ROOT__ ?>/public/admin/assets/css/style.css" rel="stylesheet">
</head>

<body>

    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Update Schedule</h5>
                                    </div>
                                    <?php if (!empty($validation)) : ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($validation as $error) : ?>
                                        <p><?php echo $error; ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    <form
                                        action="<?php echo __WEB_ROOT__ ?>/schedule/update/<?php echo $schedule['id'] ?>"
                                        class="row g-3 needs-validation" novalidate method="POST">
                                        <div class="col-12">
                                            <label class="form-label">Movie</label>
                                            <select name="movie_id" class="form-control form-control-line">
                                                <option value="">Select Movie</option>
                                                <?php if(!empty($movies)) :?>
                                                <?php foreach($movies as $value) :?>
                                                <option value="<?php echo $value['id'] ?>"
                                                    <?php echo $schedule['movie_id'] == $value['id']  ? "selected" : ''?>>
                                                    <?php  echo $value['name'] ?>
                                                </option>
                                                <?php endforeach;?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Room</label>
                                            <select name="room_id" class="form-control form-control-line">
                                                <option value="">Select Room</option>
                                                <?php if(!empty($rooms)) :?>
                                                <?php foreach($rooms as $key=>$value) :?>
                                                <option value="<?php echo $value['id']?>"
                                                    <?php echo $schedule['room_id'] == $value['id'] ? "selected" : '' ?>>
                                                    <?php echo $value['name'] ?>
                                                </option>
                                                <?php endforeach;?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Date</label>
                                            <input type="date"
                                                value="<?php echo isset($_POST['schedule_date']) ? $_POST['schedule_date'] : $schedule['schedule_date']; ?>"
                                                name="schedule_date" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Start Time</label>
                                            <input type="time"
                                                value="<?php echo isset($_POST['start_time']) ? $_POST['start_time'] : $schedule['start_time']; ?>"
                                                name="start_time" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">End Time</label>
                                            <input type="time"
                                                value="<?php echo isset($_POST['end_time']) ? $_POST['end_time'] : $schedule['end_time']; ?>"
                                                name="end_time" class="form-control">
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Create Schedule</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="credits">
                                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/chart.js/chart.umd.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/echarts/echarts.min.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/quill/quill.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/vendor/php-email-form/validate.js"></script>
    <!-- Template Main JS File -->
    <script src="<?php echo __WEB_ROOT__ ?>/public/admin/assets/js/main.js"></script>
</body>

</html>