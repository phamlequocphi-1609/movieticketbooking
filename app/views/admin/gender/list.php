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
                        <h5 class="card-title">Table Gender</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Create_at</th>
                                    <th scope="col">Update_at</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($genders)) : ?>
                                <?php foreach($genders as $key=>$value) :?>
                                <tr>
                                    <th scope="row"><?php echo $value['id']?></th>
                                    <td><?php echo $value['gender'] ?></td>
                                    <td><?php echo $value['create_at']?></td>
                                    <td><?php echo $value['update_at']?></td>
                                </tr>
                                <?php endforeach ; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/gender-add" class="btn btn-primary">Add Gender</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>