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
                        <h5 class="card-title">Table Members</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Password</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Birthday</th>
                                    <th scope="col">Country</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($members)) : ?>
                                <?php  foreach($members as $key => $value) : ?>
                                <tr>
                                    <td><?php echo $value['id']?></td>
                                    <td><?php echo $value['name']?></td>
                                    <td><?php echo $value['password']?></td>
                                    <td><?php echo $value['email']?></td>
                                    <?php 
                                        $genderName = '';
                                        $countryName = '';
                                        if(!empty($genders)){
                                            foreach($genders as $gender){
                                                if($gender['id'] == $value['id_gender']){
                                                    $genderName = $gender['gender'];
                                                }
                                            }
                                        }
                                        if(!empty($countries)){
                                            foreach($countries as $country){
                                                if($country['id'] == $value['id_country']){
                                                    $countryName = $country['name'];
                                                }
                                            }
                                        }
                                    ?>
                                    <td><?php echo $genderName ?></td>
                                    <td><?php echo $value['phone'] ?></td>
                                    <td><?php echo $value['address'] ?></td>
                                    <td>
                                        <img width="80"
                                            src="<?php echo __WEB_ROOT__?>/public/upload/member/avatar/<?php echo $value['avatar'] ?>"
                                            alt="">
                                    </td>
                                    <td><?php echo date('d-m-Y', strtotime($value['birthday'])) ?></td>
                                    <td><?php echo $countryName ?></td>
                                    <td>
                                        <a href="<?php echo __WEB_ROOT__?>/member/delete/<?php echo $value['id'] ?>"
                                            class="btn btn-danger btn-sm p-2 text-white"><i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>

                                <?php endforeach ?>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>