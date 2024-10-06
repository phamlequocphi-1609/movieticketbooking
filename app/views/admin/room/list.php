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
                        <h5 class="card-title">Table Room</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Cinema</th>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Create_at</th>
                                    <th scope="col">Update_at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($rooms)):?>
                                <?php foreach($rooms as  $value):?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <td><?php echo $value['name'] ?></td>
                                    <?php
                                        $roomName = '';
                                        if(!empty($cinemas)){
                                           foreach($cinemas as $cinema){
                                                if($value['cinema_id'] == $cinema['id']){
                                                    $roomName = $cinema['name'];
                                                }
                                           }
                                        }
                                    ?>
                                    <td><?php echo $roomName ?></td>
                                    <td><?php echo $value['create_at'] ?></td>
                                    <td><?php echo $value['update_at'] ?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/room/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/room/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/room/add" class="btn btn-primary">Add Room</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>