<main id="main" class="main ">
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
                        <h5 class="card-title">Table Blog</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Heading</th>
                                    <th scope="col">Content</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($blogs)):?>
                                <?php foreach($blogs as $key => $value):?>
                                <?php $heading = json_decode($value['heading'], true);
                                      $imageArr = json_decode($value['image'], true);
                                      $contentArr = json_decode($value['content'], true);
                                ?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <td><?php echo $value['title'] ?></td>
                                    <td>
                                        <ul class="p-0">
                                            <?php foreach($heading as $head) : ?>
                                            <li class="list-unstyled mb-2"><?php echo $head ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="p-0">
                                            <?php foreach($contentArr as $content) : ?>
                                            <li class="list-unstyled mb-2"><?php echo $content ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <ul class="p-0">
                                            <?php foreach($imageArr as $img) :?>
                                            <li class="list-unstyled mb-2">
                                                <img width="150"
                                                    src="<?php echo __WEB_ROOT__?>/public/upload/admin/blog/<?php echo $img ?>"
                                                    alt="<?php echo $img ?>">
                                            </li>
                                            <?php endforeach;  ?>
                                        </ul>
                                    </td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/blog/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white "><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/blog/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i
                                                class="bi bi-trash  "></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/blog/add" class="btn btn-primary">Add Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>