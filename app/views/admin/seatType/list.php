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
                        <h5 class="card-title">Table Country</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Seat Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($seatTypes)):?>
                                <?php foreach($seatTypes as $key => $value):?>
                                <tr>
                                    <th scope="row"><?php echo $value['id'] ?></th>
                                    <td><?php echo $value['seat_type'] ?></td>

                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/seatType/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                                <?php  endforeach; ?>

                                <?php endif; ?>
                            </tbody>
                        </table>
                        <a href="<?php echo __WEB_ROOT__ ?>/seatType/add" class="btn btn-primary">Add Seat Type</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>