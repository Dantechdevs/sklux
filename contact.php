<?php
require_once "includes/functions.php";
include "includes/header.php";

// Handle form submission
if (isset($_POST['contact_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    // Basic validation
    if ($name && $email && $subject && $message) {
        // Send email (use PHP mail or configure SMTP)
        $to = "info@skylux.com"; // Replace with your email
        $headers = "From: $name <$email>\r\n";
        $body = "Name: $name\nEmail: $email\n\n$message";

        if (mail($to, $subject, $body, $headers)) {
            setFlash('contact', 'Thank you! Your message has been sent.');
        } else {
            setFlash('contact', 'Oops! Something went wrong. Please try again.', 'danger');
        }
        redirect('contact.php');
    } else {
        setFlash('contact', 'Please fill in all fields.', 'danger');
        redirect('contact.php');
    }
}
?>

<div class="container my-5">
    <h2 class="mb-4">📞 Contact Us</h2>

    <?php flash('contact'); ?>

    <div class="row">
        <!-- Contact Form -->
        <div class="col-md-6">
            <form method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>

                <button type="submit" name="contact_submit" class="btn btn-primary">
                    ✉️ Send Message
                </button>
            </form>
        </div>

        <!-- Contact Details -->
        <div class="col-md-6">
            <h5>Our Contact Details</h5>
            <p>📍 Address: 123 Skylux Street, Nairobi, Kenya</p>
            <p>📧 Email: info@skylux.com</p>
            <p>📞 Phone: +254 712 328 150</p>
            <p>🌐 Website: www.skylux.com</p>

            <!-- WhatsApp Button -->
            <a href="https://wa.me/254712328150" target="_blank" class="btn btn-success mt-3">
                💬 WhatsApp Us
            </a>
        </div>
    </div>
</div>

<?php include "includes/footer.php"; ?>