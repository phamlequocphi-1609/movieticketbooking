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
                        <h5 class="card-title">Table Schedule</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Movie</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start time</th>
                                    <th scope="col">End time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($schedules)):?>
                                <?php foreach($schedules as  $value):?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>

                                    <?php
                                        $MovieName = '';
                                        if(!empty($movies)){
                                           foreach($movies as $movie){
                                                if($value['movie_id'] == $movie['id']){
                                                    $MovieName = $movie['name'];
                                                }
                                           }
                                        }
                                    ?>
                                    <td><?php echo $MovieName ?></td>
                                    <?php
                                        $RoomName = '';
                                        if(!empty($rooms)){
                                           foreach($rooms as $room){
                                                if($value['room_id'] == $room['id']){
                                                    $RoomName = $room['name'];
                                                }
                                           }
                                        }
                                    ?>
                                    <td><?php echo $RoomName ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($value['schedule_date'])) ?></td>
                                    <td><?php echo $value['start_time'] ?></td>
                                    <td><?php echo $value['end_time'] ?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/schedule/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/schedule/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/schedule/add" class="btn btn-primary">Add Schedule</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>