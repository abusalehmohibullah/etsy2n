<?php
include "header.php";
?>

<div class="row g-3">

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-5 col-xxl-4">
        <div class="bg-white rounded p-2">

            <div class="fw-bold fs-5 text-center">Add new admin</div>
            <form action="" method="POST">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" id="inputName4" name="name" placeholder="Name" required>
                    <label for="inputName4" class="form-label">Name</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="email" class="form-control" id="inputEmail4" name="email" placeholder="Email Address" required>
                    <label for="inputEmail4" class="form-label">Email</label>
                </div>
                <div class="form-floating mb-2">
                    <input type="password" class="form-control" id="inputPassword4" name="password" placeholder="Password" required minlength="6">
                    <label for="inputPassword4" class="form-label">Password</label>
                </div>
                <div class="w-100">
                    <button type="submit" class="btn btn-lg btn-success w-100" name="add-admin" value="1">Add</button>
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-7 col-xxl-8">
        <div class="table-responsive bg-white rounded p-2">


            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email Address</th>
                        <th>Action</th>
                    </tr>
                </thead>


                <tbody class="table-group-divider">


                    <?php
                    // Prepare and execute the query
                    $query = "SELECT * FROM admins WHERE status = 1";
                    $result = $connection->query($query);
                    $id_count = 0;
                    if ($result->num_rows > 0) {

                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $requestId = $row['id'];
                            $name = $row['name'];
                            $email = $row['user_name'];
                            $status = $row['status'];
                            $id_count++;
                    ?>
                            <tr>
                                <td>
                                    <?php echo $id_count; ?>
                                </td>
                                <td>
                                    <?php echo $name; ?>
                                </td>
                                <td>
                                    <?php echo $email; ?>
                                </td>

                                <td class="align-middle"><button class="btn btn-danger" type="button" data-bs-toggle="modal" data-bs-target="#delete-<?php echo $requestId; ?>"><i class="bi bi-trash"></i></button></td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="delete-<?php echo $requestId; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header py-2 alert alert-danger">
                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to remove this admin?
                                        </div>
                                        <div class="modal-footer py-1">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <form action="" method="post">
                                                <input type="hidden" name="id" value="<?php echo $requestId; ?>">
                                                <input type="hidden" name="table-name" value="admins">
                                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        <?php
                        }
                    } else {
                        ?>

                        <tr>
                            <td>No Admin found.</td>
                        </tr>

                    <?php
                    }

                    ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?php
include "footer.php";
?>