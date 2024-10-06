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
                        <div class="col-lg-12 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="<?php echo __WEB_ROOT__?>/public/admin/assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">NiceAdmin</span>
                                </a>
                            </div><!-- End Logo -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Update Blog</h5>
                                    </div>
                                    <?php if (!empty($validation)) : ?>
                                    <div class="alert alert-danger">
                                        <?php foreach ($validation as $error) : ?>
                                        <p><?php echo $error; ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                    <?php endif; ?>
                                    <form action="<?php echo __WEB_ROOT__ ?>/blog/update/<?php echo $blog['id'] ?>"
                                        enctype="multipart/form-data" class="row g-3 needs-validation" novalidate
                                        method="POST">
                                        <div class="col-12">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title" class="form-control"
                                                value="<?php echo isset($_POST['title']) ? $_POST['title'] : $blog['title']; ?>">
                                        </div>
                                        <?php 
                                            $heading = json_decode($blog['heading'], true);                           
                                            $headingString = implode(",",$heading);      
                                            $content = json_decode($blog['content'], true);
                                            $contentString = implode(";", $content);
                                            $image = json_decode($blog['image'], true);
                                        ?>
                                        <div class="col-12">
                                            <label class="form-label">Heading</label>
                                            <textarea name="heading" id="" class="form-control" rows="5"
                                                value="<?php echo isset($_POST['heading']) ? $_POST['heading'] : $headingString ?>"><?php echo isset($_POST['heading']) ? $_POST['heading'] : $headingString ?>
                                            </textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Content</label>
                                            <textarea name="content" class="form-control" rows="10"
                                                value="<?php echo isset($_POST['content']) ? $_POST['content'] : $contentString; ?>"><?php echo isset($_POST['content']) ? $_POST['content'] : $contentString  ?>
                                            </textarea>
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label">Image</label>
                                            <input type="file" name="image[]" class="form-control" multiple value="">
                                            <div class="flex items-center justify-center my-5 ">
                                                <?php foreach($image as $img) :?>
                                                <img width="150" class="mb-2"
                                                    src="<?php echo __WEB_ROOT__?>/public/upload/admin/blog/<?php echo $img ?>"
                                                    alt="<?php echo $img ?>">
                                                <input type="checkbox" style="width: 30px; height: 30px;"
                                                    name="deleteImg[]" value="<?php echo $img ?>" />
                                                <?php endforeach;  ?>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Update Blog</button>
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