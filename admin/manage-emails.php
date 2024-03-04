<?php
include "header.php";
?>

<section>
    <div class="fs-4 fw-semibold">Manage Emails</div>

    <div class="accordion my-2" id="slidesAccordion">
        <div class="accordion-item  position-relative">

            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                <div class="align-self-center m-0 p-0 text-dark fw-semibold">View Auto Sending Email Details</div>
            </button>

            <div id="collapseZero" class="collapse" aria-labelledby="headingTwo">
                <div class="accordion-body row gx-1 py-0 px-2">

                    <div class="container-fluid px-2 py-1">

                        <div class="table-responsive">

                            <?php
                            // Query to fetch data from the "languages" table
                            $query = "SELECT * FROM email_format";
                            $connection->set_charset('utf8');
                            $result = $connection->query($query);

                            // Check if any rows are returned
                            if ($result->num_rows > 0) {
                                // Start the HTML table
                                echo '<table class="table bg-white">';

                                // Fetch the column names
                                $fields = $result->fetch_fields();

                                // Output the table header row
                                echo '<tr>';
                                foreach ($fields as $field) {
                                    echo '<th>' . $field->name . '</th>';
                                }
                                echo '</tr>';

                                // Output the table data rows
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    foreach ($row as $columnName => $columnValue) {
                                        if ($columnName === 'id') {
                                            $language_id = $columnValue;
                                        }

                                        if ($columnName === 'status') {

                            ?>
                                            <td>
                                                <div>
                                                    <?php if ($columnValue == 1) { ?>
                                                        <div class="fst-italic text-secondary mb-1">Hidden</div>
                                                        <div class="ms-auto px-2 py-1 d-flex z-1 flex-nowrap gap-1">
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                <input type="hidden" name="table" value="languages">
                                                                <input type="hidden" name="value" value="2">
                                                                <button class="btn btn-success" type="submit" name="update-status">
                                                                    <i class="bi bi-eye"></i>
                                                                </button>
                                                            </form>
                                                            <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $language_id; ?>">
                                                                <i class="bi bi-trash"></i>
                                                            </div>
                                                        <?php } elseif ($columnValue == 2) { ?>
                                                            <div class="fst-italic text-success mb-">Published</div>
                                                            <div class="ms-auto px-2 py-1 d-flex z-1 flex-nowrap gap-1">
                                                                <form action="" method="post">
                                                                    <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                    <input type="hidden" name="table" value="languages">
                                                                    <input type="hidden" name="value" value="1">
                                                                    <button class="btn btn-secondary" type="submit" name="update-status">
                                                                        <i class="bi bi-eye-slash"></i>
                                                                    </button>
                                                                </form>
                                                                <div class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal-<?php echo $language_id; ?>">
                                                                    <i class="bi bi-trash"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>

                                                </div>
                                            </td>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal-<?php echo $language_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header py-2 alert alert-danger">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Confirm Delete</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this language <?php echo $language_id ?>?
                                                        </div>
                                                        <div class="modal-footer py-1">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <form action="" method="post">
                                                                <input type="hidden" name="id" value="<?php echo $language_id ?>">
                                                                <input type="hidden" name="table-name" value="languages">
                                                                <input type="submit" class="btn btn-danger" name="delete-button" value="Delete">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                            <?php
                                        } else {
                                            echo '<td class="truncate"><div class="truncate-content">' . $columnValue . '</div></td>';
                                        }
                                    }
                                    echo '</tr>';
                                }

                                // End the HTML table
                                echo '</table>';
                            } else {
                                echo 'No rows found.';
                            }

                            ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-1">
        <form action="" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">

            <div class="position-relative">


                    <div class="accordion my-4" id="accordionExample">
                        <div class="accordion-item  position-relative">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Update Auto Sending Email Contents</div>
                            </button>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="my-3 p-2">
                                            <input type="hidden" name="primary_key" value="id">
                                            <select class="form-select" name="primary_value" aria-label="Default select example" required>
                                                <option disabled selected>Select Format</option>
                                                <?php
                                                    $sql = "SELECT * FROM email_format";
                                                    $result = $connection->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        foreach ($result as $row) {
                                                            $id = $row['id'];
                                                            $format_name = $row['format_name'];
                                                            echo '<option value="' . $id . '">' . $format_name . '</option>';
                                                        }
                                                    }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="mb-2 p-2 bg-white rounded">
                                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject">
                                        </div>
                                        <div class="mb-2 p-2 bg-white rounded">
                                            <label for="top_banner" class="form-label">Top Banner Image</label>
                                            <input type="file" class="form-control" id="top_banner" name="image">
                                        </div>

                                            
                                            
                                                            


                
                
                
                
                
                
                                                <div class="accordion my-4 row p-2" id="accordionExampleOne">
                                            <div class="mb-2 bg-white rounded col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                                                                
                                                    <div class="accordion-item  position-relative">
                            
                                                        <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                                            <div class="align-self-center m-0 p-0 text-dark fw-semibold">Top Part</div>
                                                        </button>
                            
                                                        <div id="collapseTwo" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleOne">
                                                            <div class="accordion-body row gx-1 py-0 px-2">
                            
                                                                <div class="container-fluid px-2 py-1">
                            
                            
                                                                    <textarea class="form-control" id="format-top-editor" name="top_text" rows="3"></textarea>
                            
                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            </div>
                                            <div class="mb-2 bg-white rounded col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">

                                                                        <div class="accordion-item  position-relative">
                                                
                                                                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                                                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part</div>
                                                                            </button>
                                                
                                                                            <div id="collapseThree" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleOne">
                                                                                <div class="accordion-body row gx-1 py-0 px-2">
                                                
                                                                                    <div class="container-fluid px-2 py-1">
                                                
                                                
                                                
                                                                                    <textarea class="form-control" id="format-bottom-editor" name="bottom_text" rows="3"></textarea>
                                                
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                            <div class="mb-2 bg-white rounded col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">

                                                                        <div class="accordion-item  position-relative">
                                                
                                                                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                                                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part 2</div>
                                                                            </button>
                                                
                                                                            <div id="collapseFour" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleOne">
                                                                                <div class="accordion-body row gx-1 py-0 px-2">
                                                
                                                                                    <div class="container-fluid px-2 py-1">
                                                
                                                
                                                
                                                                                    <textarea class="form-control" id="format-bottom-editor-2" name="bottom_text_2" rows="3"></textarea>
                                                
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                            <div class="mb-2 bg-white rounded col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">

                                                                        <div class="accordion-item  position-relative">
                                                
                                                                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 deep-bg collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                                                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part 3</div>
                                                                            </button>
                                                
                                                                            <div id="collapseFive" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleOne">
                                                                                <div class="accordion-body row gx-1 py-0 px-2">
                                                
                                                                                    <div class="container-fluid px-2 py-1">
                                                
                                                
                                                
                                                                                    <textarea class="form-control" id="format-bottom-editor-3" name="bottom_text_3" rows="3"></textarea>
                                                
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                            </div>


                                        
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-success" name="table_name" value="email_format">Update</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            </div>
        </form>
    </div>
    
    
    
    
    <div class="mt-4 deep-bg rounded p-2">
<div class="fs-5 fw-bold">Send Custom Emails</div>
<form action="" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
    <div class="position-relative pt-3">
        <div class="container-fluid row px-0 py-1 mx-0">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5 mb-2 p-0 pe-2">
                <div class="bg-white rounded h-100 p-2 overflow-auto" id="email-goes-to">
                    <div class="mb-2">
                        <input type="text" class="form-control" id="user-search" placeholder="Search here">
                    </div>

                    <?php
                    if (isset($user_list) && !empty($user_list)) {
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check-all" name="check-all" value="all">
                            <label class="form-check-label" for="check-all">Select All</label>
                        </div>
                        <?php
                        foreach ($user_list as $data) {
                            if($data->email != "") {
                            ?>
                            <div class="form-check user-checkbox">
                                <input class="form-check-input" type="checkbox" id="<?php echo $data->id ?>" name="email[]" value="<?php echo $data->email ?>">
                                <label class="form-check-label" for="<?php echo $data->id ?>"><?php echo $data->name ?> (@<?php echo $data->user_name ?>)</label>
                            </div>
                            <?php
                            }
                        }
                    } else {
                        echo "No member found";
                    }
                    ?>
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7 mb-3 p-0">
                <div class="mb-2 p-2 bg-white rounded">
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject (Required)" required>
                </div>
                <div class="mb-2 p-2 bg-white rounded">
                    <label for="top_banner" class="form-label">Top Banner Image</label>
                    <input type="file" class="form-control" id="top_banner" name="top_banner">
                </div>
                
                
                    <div class="accordion my-4" id="accordionExampleTwo">
                        <div class="accordion-item  position-relative my-4">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Top Part (Required)</div>
                            </button>

                            <div id="collapseSix" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleTwo">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">


                                        <div class="mb-2 p-2 bg-white rounded">
                                            <textarea class="form-control" id="custom-top-editor" name="top_text" rows="3"></textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item  position-relative my-4">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part</div>
                            </button>

                            <div id="collapseSeven" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleTwo">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        
                                        <div class="mb-2 p-2 bg-white rounded">
                                            <textarea class="form-control" id="custom-bottom-editor" name="bottom_text" rows="3"></textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item  position-relative my-4">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEight" aria-expanded="true" aria-controls="collapseEight">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part 2</div>
                            </button>

                            <div id="collapseEight" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleTwo">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        
                                        <div class="mb-2 p-2 bg-white rounded">
                                            <textarea class="form-control" id="custom-bottom-editor-2" name="bottom_text_2" rows="3"></textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item  position-relative my-4">

                            <button class="accordion-button d-flex position-relative ps-2 pe-3 py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNine" aria-expanded="true" aria-controls="collapseNine">
                                <div class="align-self-center m-0 p-0 text-dark fw-semibold">Bottom Part 3</div>
                            </button>

                            <div id="collapseNine" class="collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExampleTwo">
                                <div class="accordion-body row gx-1 py-0 px-2">

                                    <div class="container-fluid px-2 py-1">
                                        
                                        <div class="mb-2 p-2 bg-white rounded">
                                            <textarea class="form-control" id="custom-bottom-editor-3" name="bottom_text_3" rows="3"></textarea>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                <div class="mb-2 p-2 bg-white rounded">
                    <label for="attachments" class="form-label">Attchments</label>
                    <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-success" name="sendMail" value="custom_email">Send</button>
                </div>
            </div>
        </div>

    </div>
</form>


    </div>

</section>




<?php
include "footer.php";
?>