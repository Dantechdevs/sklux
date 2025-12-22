<?php
include 'includes/header.php';
include 'includes/db.php';
include 'includes/functions.php';
session_start();

$message_sent = false;

// Handle contact form submission
if(isset($_POST['send_message'])){
    $name = sanitize($_POST['name'], $conn);
    $email = sanitize($_POST['email'], $conn);
    $subject = sanitize($_POST['subject'], $conn);
    $message = sanitize($_POST['message'], $conn);

    $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $name, $email, $subject, $message);
    if($stmt->execute()){
        $message_sent = true;
    }
    $stmt->close();
}
?>

<div class="container my-5">
    <h2 class="text-3xl font-bold mb-5 text-center text-gray-800">Contact Us</h2>

    <?php if($message_sent): ?>
    <div class="alert alert-success text-center">Your message has been sent. We'll get back to you soon!</div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Contact Form -->
        <div class="col-md-6">
            <div class="p-4 border rounded shadow-sm bg-white">
                <form method="POST" action="contact.php">
                    <div class="mb-3">
                        <label class="form-label font-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-semibold">Subject</label>
                        <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label font-semibold">Message</label>
                        <textarea name="message" rows="6" class="form-control" placeholder="Write your message..."
                            required></textarea>
                    </div>
                    <button type="submit" name="send_message"
                        class="btn btn-primary w-full hover:bg-blue-600 transition">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Contact Info & Map -->
        <div class="col-md-6">
            <div class="p-4 border rounded shadow-sm bg-white">
                <h5 class="text-xl font-bold mb-3">Our Contact Info</h5>
                <p><strong>Phone:</strong> 0712 328 150</p>
                <p><strong>Mpesa Till No:</strong> 5148677</p>
                <p><strong>Location:</strong> Muthetheni, Kenya</p>
                <p><strong>WhatsApp:</strong> <a href="https://wa.me/254712328150"
                        class="text-green-600 font-semibold hover:underline">Chat with us</a></p>


                <h5 class="text-xl font-bold mt-4 mb-2">Chat with us</h5>
                <div class="flex gap-3">
                    <a href="https://wa.me/254712328150" target="_blank"
                        class="inline-flex items-center justify-center w-12 h-12 bg-green-500 rounded-full hover:bg-green-600 transition">
                        <i class="fab fa-whatsapp text-white text-2xl"></i>
                    </a>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>