<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Table Movie</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="h6 p-0">ID</th>
                                    <th class="h6 p-0">Name</th>
                                    <th class="h6 p-0">Description</th>
                                    <th class="h6 p-0">Trailer</th>
                                    <th class="h6 p-0">Genre</th>
                                    <th class="h6 p-0">Release Date</th>
                                    <th class="h6 p-0">Duration</th>
                                    <th class="h6 p-0">Format</th>
                                    <th class="h6 p-0">Poster</th>
                                    <th class="h6 p-0">Age rating</th>
                                    <th class="h6 p-0">Content Rating</th>
                                    <th class="h6 p-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if(!empty($movies)):?>
                                <?php foreach($movies as $value):?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <td><?php echo $value['name'] ?></td>
                                    <td><?php echo $value['description'] ?></td>
                                    <td class="p-0">
                                        <video width="100" controls class="mt-2">
                                            <source
                                                src="<?php echo __WEB_ROOT__?>/public/upload/admin/movie/trailer/<?php echo $value['trailer'] ?> ">
                                        </video>
                                    </td>
                                    <td><?php echo $value['genre'] ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($value['release_date'])) ?></td>
                                    <td><?php echo $value['duration'] ?></td>
                                    <td><?php echo $value['format'] ?></td>
                                    <td class="p-0">
                                        <img width="100" class="mt-2"
                                            src="<?php echo __WEB_ROOT__?>/public/upload/admin/movie/poster/<?php echo $value['poster_image'] ?>"
                                            alt="">
                                    </td>

                                    <td><?php echo $value['age_rating'] ?></td>
                                    <td><?php echo $value['content_rating'] ?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/movie/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/movie/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/movie/add" class="btn btn-primary">Add Movie</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>