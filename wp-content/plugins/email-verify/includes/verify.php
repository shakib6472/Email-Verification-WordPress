<style>
    body {
        margin: 0;
        font-family: "Poppins", Arial, sans-serif;
        /* background: linear-gradient(135deg, #0f172a, #1e293b); */
        background-color: #020205;
        background-size: 400% 400%;
        animation: gradientShift 6s ease infinite;
        color: #c9d1d9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    @keyframes gradientShift {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    .protected-container {
        text-align: center;
        border: 2px solid #30363d;
        border-radius: 20px;
        padding: 50px;
        background-color: #15171e;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.6);
        animation: fadeIn 1s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        max-width: 400px;
        /* Set a max width for the container */
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .protected-container .icon {
        font-size: 100px;
        color: #8b5cf6;
        margin-bottom: 20px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .protected-container h1 {
        font-size: 24px;
        margin-bottom: 10px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
    }

    .protected-container p {
        margin-bottom: 30px;
        font-size: 16px;
        color: #8b949e;
    }

    .protected-container .input-container {
        position: relative;
        width: 100%;
        max-width: 300px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .protected-container input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #30363d;
        border-radius: 4px;
        background-color: #0d1117;
        color: #c9d1d9;
        font-size: 1em;
        transition: border-color 0.3s, box-shadow 0.3s, transform 0.3s;
    }

    .protected-container input:focus {
        outline: none;
        border-color: #8b5cf6;
        box-shadow: 0 0 8px rgba(139, 92, 246, 0.7);
        transform: scale(1.05);
    }

    .protected-container label {
        position: absolute;
        left: 15px;
        top: 12px;
        font-size: 1em;
        color: #8b949e;
        pointer-events: none;
        transition: 0.3s ease;
    }

    .protected-container input:focus+label,
    .protected-container input:not(:placeholder-shown)+label {
        top: -10px;
        left: 15px;
        font-size: 0.85em;
        color: #8b5cf6;
        background: #15171e;
        padding: 0 10px;
    }

    .protected-container button {
        margin: 20px;
        padding: 8px 30px;
        font-size: 1em;
        color: white;
        background: linear-gradient(90deg, #8b5cf6, #7c3aed);
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease,
            background-color 0.3s ease;
        align-self: center;
        /* Centers the button horizontally */
    }

    .protected-container button:hover {
        background-color: #7c3aed;
        box-shadow: 0 8px 20px rgba(139, 92, 246, 0.6);
        transform: translateY(-5px);
    }

    .protected-container button:active {
        transform: scale(0.98);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
    }

    .protected-container .success-message p {
        margin: 0;
        margin-bottom: 0;
        color: #2ecc71;
        font-size: 14px;
        display: none;
    }

    .protected-container #resend-mail {
        margin: 0;
        margin-bottom: 0;
        color: #2ecc71;
        font-size: 14px;
        cursor: pointer;
    }

    .protected-container .error-message p {
        margin: 0;
        margin-bottom: 0;
        color: #e74c3c;
        font-size: 14px;
        display: none;
    }
</style>

<div class="protected-container">
    <div class="icon">&#128274;</div>
    <h1>Please Verify Your Email</h1>
    <p>Insert the Verification Code</p>
    <div class="input-container">
        <input type="text" id="passcode" placeholder=" " required />
        <label for="passcode">Verification Code</label>
    </div>
    <button id="verify">Verify</button>
    <div class="resend">
        <p id="resend-mail">Resend</p>
    </div>
    <div class="success-message">
        <p>Successfully Verified..</p>
    </div>
    <div class="error-message">
        <p>Code is incorrect. Please try again</p>
    </div>
</div>

<script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
<script>
    jQuery(document).ready(function($) {
        $('#verify').click(function() {
            var passcode = $('#passcode').val();
            if (passcode === '') {
                alert('Please enter the Verification Code.');
                return;
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php') ?>', // WordPress AJAX URL provided via wp_localize_script
                data: {
                    action: 'skb_verify_email', // Action hook to handle the AJAX request in your functions.php 
                    passcode: passcode,
                },
                dataType: 'json',
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    if (response.success) {
                        $('.success-message p').fadeIn();
                        $('.error-message p').hide();
                        //refresh the page
                        setTimeout(function() {
                            // location.reload();
                        }, 1000);

                    } else {
                        $('.error-message p').fadeIn();
                        $('.success-message p').hide();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle error
                    $('.error-message p').fadeIn();
                    $('.success-message p').hide();
                    console.error('Error:', errorThrown);
                }
            });
        });

        $('#resend-mail').click(function() {
            $(this).text('Resending...');
            $.ajax({
                type: 'POST',
                url: '<?php echo admin_url('admin-ajax.php') ?>', // WordPress AJAX URL provided via wp_localize_script
                data: {
                    action: 'skb_resend_email', // Action hook to handle the AJAX request in your functions.php 
                },
                dataType: 'json',
                success: function(response) {
                    // Handle success response
                    console.log(response);
                    if (response.success) {
                        $('#resend-mail').text('Sent');
                        $('.success-message p').text(response.data.message).fadeIn();
                        $('.error-message p').hide();
                    } else {
                        $('#resend-mail').text('Resend');
                        $('.error-message p').text(response.data.message).fadeIn();
                        $('.success-message p').hide();
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    // Handle error
                    $('.error-message p').text('Failed to resend email. Please try again.').fadeIn();
                    $('.success-message p').hide();
                }
            });
        });

    });
</script>