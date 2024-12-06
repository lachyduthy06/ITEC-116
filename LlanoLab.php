<?php
    $errors = [];
    $success_message = '';

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $required_fields = [
            'cardnumber' => 'Student number',
            'name' => 'Name',
            'birthday' => 'Birthday',
            'sex' => 'Sex',
            'address' => 'Address',
            'country' => 'Country',
            'phone' => 'Phone number',
            'email' => 'Email',
            'primary_contact' => 'Primary contact',
            'college' => 'College',
            'course' => 'Course'
        ];

        foreach ($required_fields as $field => $label) {
            if (empty($_POST[$field])) {
                $errors[] = "$label is required.";
            }
        }

        if (!empty($_POST['cardnumber']) && !preg_match("/^\d{9}$/", $_POST['cardnumber'])) {
            $errors[] = "Student number must be 9 digits and in numeric form.";
        }
        
        if (!empty($_POST['name']) && !preg_match("/^\d+$/", $_POST['name'])) {
            $errors[] = "Name must not contain numbers.";
        }

        if (!empty($_POST['birthday']) && !preg_match("/^\d{4}-\d{2}-\d{2}$/", $_POST['birthday'])) {
            $errors[] = "Birthday must be in YYYY-MM-DD format.";
        }

        if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }


        if (!empty($_POST['phone']) && !preg_match("/^\+?\d{11}$/", $_POST['phone'])) {
            $errors[] = "Phone number must be valid and have 11 digits.";
        }

        $valid_sexes = ['Male', 'Female', 'Other', 'Not Specified'];
        if (!in_array($_POST['sex'], $valid_sexes)){
            $error[] = "Please select a valid option for sex.";
        }

        if (empty($errors)) {
            $success_message = "Registration Successful!";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Form Validation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <div class="container" style="padding-top: 50px; padding-bottom: 50px;">
        <div class="row justify-content-center">
            <div class="col-md-8 form-container">
                <h2 class="mb-4" style="text-align: center">Registration Form</h2>
                <?php
                if (!empty($errors)) {
                    echo '<div class="alert alert-danger" role="alert"><ul class="mb-0">';
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                    echo '</ul></div>';
                }
                if (!empty($success_message)) {
                    echo "<div class='alert alert-success' role='alert'>$success_message</div>";
                }
                ?>

                <div class="error-messages"></div>
                <div class="result-container"></div>

                <form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="cardnumber" class="form-label">Student Number:</label>
                            <input class="form-control" type="text" id="cardnumber" name="cardnumber">
                        </div>
                        <div class="col-md-3">
                            <label for="college" class="form-label">College:</label>
                            <input type="text" class="form-control" id="college" name="college">
                        </div>
                        <div class="col-md-3">
                            <label for="course" class="form-label">Course:</label>
                            <input type="text" class="form-control" id="course" name="course">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name">
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name">
                        </div>
                        <div class="col-md-6">
                            <label for="birthday" class="form-label">Birthday:</label>
                            <input type="date" class="form-control" id="birthday" name="birthday">
                        </div>
                        <div class="col-md-6">
                            <label for="sex" class="form-label">Sex:</label>
                            <select class="form-select" id="sex" name="sex">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="others">Others</option>
                                <option value="not specified">Not Specified</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="House #, Street, Barangay, City/Municipality">
                        </div>
                        <div class="col-md-2">
                            <label for="country" class="form-label">Zip Code:</label>
                            <input type="text" class="form-control" id="zip" name="zip">
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">Province</label>
                            <input type="text" class="form-control" id="province" name="province">
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label">Country:</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                        <h4>Contacts:</h4>
                        <div class="col-md-4">
                            <label for="phone" class="form-label">Phone Number:</label>
                            <input type="tel" class="form-control" id="phone" name="phone_number">
                        </div>
                        <div class="col-md-4">
                            <label for="secondary_phone" class="form-label">Secondary Phone:</label>
                            <input type="tel" class="form-control" id="secondary_phone" name="secondary_phone">
                        </div>
                        <div class="col-md-4">
                            <label for="other_phone" class="form-label">Other Phone:</label>
                            <input type="tel" class="form-control" id="other_phone" name="other_phone">
                        </div>
                        <div class="col-md-4">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email">
                        </div>
                        <div class="col-md-4">
                            <label for="secondary_email" class="form-label">Secondary Email:</label>
                            <input type="email" class="form-control" id="secondary_email" name="secondary_email">
                        </div>
                        <div class="col-md-4">
                            <label for="primary_contact" class="form-label">Primary Contact:</label>
                            <select class="form-select" id="primary_contact" name="primary_contact">
                                <option value="">Select</option>
                                <option value="phone">Phone Number</option>
                                <option value="email">Email Address</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="registration_date" class="form-label">Registration Date:</label>
                            <input type="date" class="form-control" id="registration_date" name="registration_date" value="<?php echo date('Y-m-d'); ?>" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="expiration_date" class="form-label">Expiration Date:</label>
                            <input type="date" class="form-control" id="expiration_date" name="expiry_date" value="<?php echo date('Y-m-d', strtotime('+1 year')); ?>" readonly>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                        <!-- Success Modal -->
                        <div class="modal fade" id="successModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Registration Successful</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Your registration has been completed successfully!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <script src="index.js"></script>
            </div>
        </div>
    </div>     
</body>
</html>