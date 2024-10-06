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
                        <h5 class="card-title">Table Price</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Movie</th>
                                    <th scope="col">Cinema</th>
                                    <th scope="col">Schedule Date</th>
                                    <th scope="col">Seat</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($prices)):?>
                                <?php foreach($prices as $key => $value):?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <?php
                                        $movieName = '';
                                        $cinema = '';
                                        $schedule_date = "";
                                        $seat_Type = '';
                                        if(!empty($schedules)){
                                            foreach($schedules as $schedule){
                                                if($value['schedule_id'] == $schedule['id']){
                                                    $movieName = $schedule['movie_name'];
                                                    $cinema = $schedule['cinema_name'];
                                                    $schedule_date = $schedule['schedule_date'];
                                                }
                                            }
                                        }

                                        if(!empty($seatType)){
                                            foreach($seatType as $seat){
                                                if($value['seat_type_id'] == $seat['id']){
                                                    $seat_Type = $seat['seat_type'];
                                                }
                                            }
                                        }
                                    ?>
                                    <td><?php echo $movieName ?></td>
                                    <td><?php echo $cinema ?></td>
                                    <td><?php echo date('d-m-Y', strtotime($schedule_date)) ?></td>
                                    <td><?php echo $seat_Type ?></td>
                                    <td><?php echo number_format($value['price'], 0,',', '.') . ' VNĐ '?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/price/update/<?php echo $value['id'] ?>"
                                            class="btn btn-primary btn-sm p-2 text-white"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <a href="<?php echo __WEB_ROOT__?>/price/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/price/add" class="btn btn-primary">Add Price</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>