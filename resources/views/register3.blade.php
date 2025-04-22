<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/img/favicon-96x96.png" sizes="96x96" />
    <title>REGISTER</title>
    <link href="https://unpkg.com/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
    <script src="{{ asset('assets/js/register.js') }}" defer></script>

</head>

<body>
    <div class="registration-container">

        <div class="image-container">
            <div class="logo-container">
                <img src="{{ asset('assets/img/whitelogo.png') }}" alt="Logo" class="logo">
                <p class="logo-text">Adventure Awaits!</p>
            </div>
            <img src="{{ asset('assets/img/arkila.gif') }}">
        </div>


        <div class="form-container">

            <form action="{{ route('register.complete.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-header">
                    <h1>Welcome!</h1>
                    <p>Sign up with ARKILA to get moving.</p>
                </div>


                <div class="timeline-registration-container">
                    <div class="timeline">
                        <div class="timeline-step" id="step-1">1</div>
                        <div class="timeline-line" id="line-1"></div>
                        <div class="timeline-step" id="step-2">2</div>
                        <div class="timeline-line" id="line-2"></div>
                        <div class="timeline-step" id="step-3">3</div>
                    </div>
                </div>

                <div class="valid-ids-section">
                    <h2 class="valid-id-heading">Valid IDs</h2>
                    <p>III. Would you prefer to drive the vehicle yourself or have a professional driver assist you?
                        <br> <span>Please select your preferred option: Self-Drive or With Driver</span>
                    </p>


                    <div class="service-buttons-container">
                        <button type="button" class="service-button" id="self-drive-button">Self-Drive</button>
                        <button type="button" class="service-button" id="with-driver-button">With Driver</button>
                    </div>
                    <input type="hidden" name="service_type" id="service_type">



                    <form action="{{ route('upload.files') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div id="self-drive-form" class="hidden">
                            <div class="form-group">
                                <label for="driver-license">Select Driver's License</label>
                                <select id="driver-license" name="driver_license_type">
                                    <option value="professional">Professional</option>

                                </select>
                            </div>

                            <div class="form-group">

                                <label for="front-license-upload">Upload Front of Driver's License</label>
                                <div class="file-upload-box">
                                    <input type="file" id="front-license-upload" name="front_license"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="front-license-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('front-license-upload').click();">Choose
                                        File</button>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="back-license-upload">Upload Back of Driver's License</label>
                                <div class="file-upload-box">
                                    <input type="file" id="back-license-upload" name="back_license"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="back-license-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('back-license-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>



                            <div class="form-group">
                                <label for="second-id">Select Second ID</label>
                                <select id="second-id" name="second_id_type">
                                    <option value="passport">Passport</option>
                                    <option value="ssr">SSS ID</option>
                                    <option value="philhealth">PhilHealth ID</option>
                                    <option value="voters">Voter's ID</option>
                                    <option value="postal">Postal ID</option>
                                    <option value="national">National ID</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="front-second-id-upload">Upload Front of Selected ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="front-second-id-upload" name="front_second_id"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="front-second-id-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('front-second-id-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="back-second-id-upload">Upload Back of Selected ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="back-second-id-upload" name="back_second_id"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="back-second-id-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('back-second-id-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="proof-of-billing">Select Proof of Billing</label>
                                <select id="proof-of-billing" name="proof_of_billing_type">
                                    <option value="electric" {{ old('proof_of_billing_type') == 'electric' ? 'selected' : '' }}>Electric Bill</option>
                                    <option value="water" {{ old('proof_of_billing_type') == 'water' ? 'selected' : '' }}>
                                        Water Bill</option>
                                    <option value="internet" {{ old('proof_of_billing_type') == 'internet' ? 'selected' : '' }}>Internet Bill</option>
                                    <option value="cable" {{ old('proof_of_billing_type') == 'cable' ? 'selected' : '' }}>
                                        Cable Bill</option>
                                    <option value="credit_card" {{ old('proof_of_billing_type') == 'credit_card' ? 'selected' : '' }}>Credit Card Statement</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="proof-of-billing-upload">Upload Proof of Billing</label>
                                <div class="file-upload-box">
                                    <input type="file" id="proof-of-billing-upload" name="proof_of_billing"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="proof-of-billing-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('proof-of-billing-upload').click();">
                                        Choose File
                                    </button>
                                </div>
                            </div>



                            <div class="id-verification-instructions">
                                <h3>Self - Drive: ID Verification Instructions for ARKILA</h3>
                                <p><strong>Prepare Your IDs:</strong></p>
                                <ul>
                                    <li>Make sure you have (2) two different valid IDs available, you are required to
                                        upload your Driver's License.</li>
                                    <li>The IDs should be government-issued and should include your full name, clear
                                        photo, and birthdate.</li>
                                </ul>
                                <p><strong>Requirements for Uploaded IDs:</strong></p>
                                <ul>
                                    <li>The IDs must be clear and legible. Blurry, obscured, or low-quality images may
                                        result in delays in the verification process.</li>
                                    <li>Accepted ID formats: JPEG, PNG, or PDF.</li>
                                    <li>File size should not exceed 5 MB per ID.</li>
                                </ul>
                                <p><strong>Uploading Both Sides of Each ID:</strong></p>
                                <ul>
                                    <li><strong>Front of ID:</strong> Ensure the front of each ID is clear, showing your
                                        photo, name, and other details.</li>
                                    <li><strong>Back of ID:</strong> Make sure to capture the back side, which often
                                        includes additional information and security features.</li>
                                </ul>
                                <p><strong>Privacy Protection:</strong></p>
                                <ul>
                                    <li>Your documents are stored securely and will be used only for verification
                                        purposes,
                                        in compliance with our Privacy Policy.</li>
                                </ul>
                            </div>

                        </div>


                        <div id="with-driver-form" class="hidden">
                            <div class="form-group">
                                <label for="first-id">Select First ID</label>
                                <select id="first-id" name="first_id">
                                    <option value="passport">Passport</option>
                                    <option value="sss">SSS ID</option>
                                    <option value="philhealth">PhilHealth ID</option>
                                    <option value="voters">Voter's ID</option>
                                    <option value="postal">Postal ID</option>
                                    <option value="national">National ID</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="first-id-front-upload">Upload Front of First ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="first-id-front-upload" name="first_id_front"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="first-id-front-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('first-id-front-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="first-id-back-upload">Upload Back of First ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="first-id-back-upload" name="first_id_back"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="first-id-back-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('first-id-back-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="second-id">Select Second ID</label>
                                <select id="second-id" name="second_id_type">
                                    <option value="passport">Passport</option>
                                    <option value="sss">SSS ID</option>
                                    <option value="philhealth">PhilHealth ID</option>
                                    <option value="voters">Voter's ID</option>
                                    <option value="postal">Postal ID</option>
                                    <option value="national">National ID</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="second-id-front-upload">Upload Front of Second ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="second-id-front-upload" name="driver_front_second_id"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="second-id-front-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('second-id-front-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="second-id-back-upload">Upload Back of Second ID</label>
                                <div class="file-upload-box">
                                    <input type="file" id="second-id-back-upload" name="driver_back_second_id"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="second-id-back-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('second-id-back-upload').click();">Choose
                                        File</button>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="proof-of-billing">Select Proof of Billing</label>
                                <select id="proof-of-billing" name="proof_of_billing_type">
                                    <option value="electric" {{ old('proof_of_billing_type') == 'electric' ? 'selected' : '' }}>Electric Bill</option>
                                    <option value="water" {{ old('proof_of_billing_type') == 'water' ? 'selected' : '' }}>
                                        Water Bill</option>
                                    <option value="internet" {{ old('proof_of_billing_type') == 'internet' ? 'selected' : '' }}>Internet Bill</option>
                                    <option value="cable" {{ old('proof_of_billing_type') == 'cable' ? 'selected' : '' }}>
                                        Cable Bill</option>
                                    <option value="credit_card" {{ old('proof_of_billing_type') == 'credit_card' ? 'selected' : '' }}>Credit Card Statement</option>
                                </select>

                            </div>

                            <div class="form-group">
                                <label for="driver-proof-of-billing-upload">Upload Proof of Billing</label>
                                <div class="file-upload-box">
                                    <input type="file" id="driver-proof-of-billing-upload" name="driver_proof_of_billing"
                                        accept=".jpeg,.jpg,.png,.pdf" onchange="validateFile(this)"
                                        style="display: none;" />
                                    <span id="proof-of-billing-filename">No file chosen</span>
                                    <button type="button" class="custom-file-upload"
                                        onclick="document.getElementById('driver-proof-of-billing-upload').click();">
                                        Choose File
                                    </button>
                                </div>
                            </div>


                            <div class="id-verification-instructions">
                                <h3>With Driver : ID Verification Instructions for ARKILA</h3>
                                <p><strong>Prepare Your IDs:</strong></p>
                                <ul>
                                    <li>Make sure you have (2) two different valid IDs available.</li>
                                    <li>The IDs should be government-issued and should include your full name, clear
                                        photo, and birthdate.</li>
                                </ul>
                                <p><strong>Requirements for Uploaded IDs:</strong></p>
                                <ul>
                                    <li>The IDs must be clear and legible. Blurry, obscured, or low-quality images may
                                        result in delays in the verification process.</li>
                                    <li>Accepted ID formats: JPEG, PNG, or PDF.</li>
                                    <li>File size should not exceed 5 MB per ID.</li>
                                </ul>
                                <p><strong>Uploading Both Sides of Each ID:</strong></p>
                                <ul>
                                    <li><strong>Front of ID:</strong> Ensure the front of each ID is clear, showing your
                                        photo, name, and other details.</li>
                                    <li><strong>Back of ID:</strong> Make sure to capture the back side, which often
                                        includes additional information and security features.</li>
                                </ul>
                                <p><strong>Privacy Protection:</strong></p>
                                <ul>
                                    <li>Your documents are stored securely and will be used only for verification
                                        purposes,
                                        in compliance with our Privacy Policy.</li>
                                </ul>
                            </div>
                        </div>



                        <div class="form-group new-terms">
                            <input type="checkbox" id="agree-privacy" class="new-custom-checkbox" name="agree_privacy"
                                disabled>
                            <label for="agree-privacy">
                                I have read and agreed to the <a href="{{ asset('documents/PP_ARKILA.pdf') }}"
                                    target="_blank" id="privacy-link" > Privacy Policy</a>.
                            </label>

                        </div>
                        <p class="note" id="privacy-note" style="color: red; ">Note: Please click the link to read the Privacy Policy for
                            a minute before
                            logging in.</p>

                        <div class="navigation-buttons">
                            <button type="submit" id="proceed-btn" class="next1-button" disabled>Proceed to
                                Login</button>
                            <button type="button" class="back1-button" onclick="goToBack()">Back</button>
                        </div>

                    </form>
                </div>
            </form>
        </div>
    </div>
    <script>

        document.getElementById('privacy-link').addEventListener('click', function () {
        let checkbox = document.getElementById('agree-privacy');
        let proceedBtn = document.getElementById('proceed-btn');
        let privacyNote = document.getElementById('privacy-note');

        if (checkbox.dataset.timerStarted) return;
        checkbox.dataset.timerStarted = true;

        let timeLeft = 30;
        privacyNote.style.color = 'blue'; 
        privacyNote.innerText = `Reading Privacy Policy... Please wait ${timeLeft} seconds `;

        let countdown = setInterval(function () {
            timeLeft--;
            privacyNote.innerText = `Reading Privacy Policy... Please wait ${timeLeft} seconds `;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                checkbox.disabled = false;
                privacyNote.innerText = 'Privacy Policy read. You may now check the box to proceed .';
                privacyNote.style.color = 'green'; 
            }
        }, 1000);
    });

  
    document.getElementById('agree-privacy').addEventListener('change', function () {
        document.getElementById('proceed-btn').disabled = !this.checked;
    });

   
    document.getElementById('self-drive-button').addEventListener('click', function () {
        document.getElementById('service_type').value = 'Self-Drive';
    });

    document.getElementById('with-driver-button').addEventListener('click', function () {
        document.getElementById('service_type').value = 'With Driver';
    });




    </script>
</body>

</html>