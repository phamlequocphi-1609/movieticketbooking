<main id="main" class="main">

    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        <?php if(isset($user['avatar'])) :?>
                        <img src="<?php echo __WEB_ROOT__?>/public/upload/admin/avatar/<?php echo $user['avatar']?> "
                            alt="Profile" class="rounded-circle">
                        <?php endif; ?>
                        <h2><?php echo (isset($user['name'])) ? $user['name'] : '' ?></h2>
                        <h3>Backend Developer</h3>
                        <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <h5 class="card-title">Profile Details</h5>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo (!empty($user['name']) ? $user['name'] : '') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo (!empty($user['email']) ? $user['email'] : '') ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Birthday</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo (!empty($user['birthday']) ? date('d-m-Y', strtotime($user['birthday'])) : '')  ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php if (!empty($genders)) : ?>
                                        <?php     
                                            $genderName = '';
                                                foreach ($genders as $gender) {
                                                    if ($gender['id'] == $user['id_gender']) {
                                                        $genderName = $gender['gender'];                         
                                                    }
                                                }
                                                ?>
                                        <?php echo $genderName ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Country</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php if (!empty($countrys)) : ?>
                                        <?php     
                                            $countryName = '';
                                                foreach ($countrys as $country) {
                                                    if ($country['id'] == $user['id_country']) {
                                                        $countryName = $country['name'];                         
                                                    }
                                                }
                                                ?>
                                        <?php echo $countryName ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Address</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo (!empty($user['address']) ? $user['address'] : '')  ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8">
                                        <?php echo (!empty($user['phone']) ? $user['phone'] : '')  ?>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                <?php if (!empty($validation)) : ?>
                                <div class="alert alert-danger">
                                    <?php foreach ($validation as $error) : ?>
                                    <p><?php echo $error; ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <!-- Profile Edit Form -->
                                <form method="POST" action="<?php echo __WEB_ROOT__?>/admin-update"
                                    enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                            Image</label>
                                        <div class="col-md-8 col-lg-9">
                                            <img src="<?php echo __WEB_ROOT__?>/public/upload/admin/avatar/<?php echo isset($_POST['avatar']) ? $_POST['avatar'] : $user['avatar']  ?>"
                                                alt="Profile">
                                            <div class="pt-2">
                                                <input type="file" class="form-control" name="avatar" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input type="text" class="form-control" name="name"
                                                value="<?php echo isset($_POST['name']) ? $_POST['name'] : $user['name'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                value="<?php echo isset($_POST['password']) ? $_POST['password'] : $user['password'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-md-4 col-lg-3 col-form-label">Gender</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="id_gender" class="form-control">
                                                <?php if(isset($genders)) : ?>
                                                <?php foreach($genders as $value) :?>
                                                <option value="<?php echo $value['id']?>"
                                                    <?php $user['id_gender'] == $value['id'] ? "selected" : ''?>>
                                                    <?php echo $value['gender']  ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php  endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Birthday</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="birthday" type="date" class="form-control"
                                                value="<?php echo isset($_POST['birthday']) ? $_POST['birthday'] : $user['birthday'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Country" class="col-md-4 col-lg-3 col-form-label">Country</label>
                                        <div class="col-md-8 col-lg-9">
                                            <select name="id_country" class="form-control">
                                                <?php if(isset($countrys)) : ?>
                                                <?php foreach($countrys as $value) :?>
                                                <option value="<?php echo $value['id']?>"
                                                    <?php $user['id_country'] == $value['id'] ? "selected" : ''?>>
                                                    <?php echo $value['name']  ?>
                                                </option>
                                                <?php endforeach; ?>
                                                <?php endif ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="address" type="text" class="form-control" id="Address"
                                                value="<?php echo isset($_POST['address']) ? $_POST['address'] : $user['address'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="phone" type="text" class="form-control" id="Phone"
                                                value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : $user['phone'] ?>">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="email" type="email" class="form-control"
                                                value="<?php echo isset($_POST['email']) ? $_POST['email'] : $user['email'] ?>">
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form><!-- End Profile Edit Form -->

                            </div>
                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

</main><!-- End #main -->