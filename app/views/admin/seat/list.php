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
                        <h5 class="card-title">Table Seat</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Seat Type</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Seat Row</th>
                                    <th scope="col">Seat Number</th>
                                    <th scope="col">status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($seats)):?>
                                <?php foreach($seats as  $value):?>

                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <?php
                                        $seatName = '';
                                        if(!empty($seatTypes)){
                                           foreach($seatTypes as $seatType){
                                                if($value['seat_type_id'] == $seatType['id']){
                                                    $seatName = $seatType['seat_type'];
                                                }
                                           }
                                        }
                                    ?>
                                    <td><?php echo $seatName ?></td>
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
                                    <td><?php echo $value['row'] ?></td>
                                    <td><?php echo $value['number'] ?></td>
                                    <td><?php echo $value['status']?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/seat/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white "><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/seat/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/seat/add" class="btn btn-primary">Add Seat</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>