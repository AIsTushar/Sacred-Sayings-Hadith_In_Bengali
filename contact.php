<!-- <div class="section__contact_us">
  <div class="container_contact">
    <p>CONTACT US</p>

    <div class="contact_user">
      <input type="text" placeholder="Your Name" class="contact_input" />
      <input type="text" placeholder="Your Email Address" class="contact_input" />
    </div>

    <div class="subject">
      <input type="text" placeholder="Subject" class="contact_input" />
    </div>

    <div class="contact_msg">
      <textarea class="contact_area" placeholder="Leave a Message"></textarea>
    </div>

    <div class="contact_btn">Send Message</div>
  </div>
</div> -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["contact_us"])) {
  $hostname = 'localhost';
  $username = 'root';
  $password = '';
  $database = 'cse479';

  $conn = new mysqli($hostname, $username, $password, $database);


  if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
  }

  $name = $_POST['name'];
  $email = $_POST['email'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];

  $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Message sent successfully!')</script>";
  } else {
    echo "<script>alert('Error: " . "<br>" . $conn->error . "')</script>";
  }

  $conn->close();
}
?>

<div class="section__contact_us">
  <div class="container_contact">
    <p>যোগাযোগ করুন</p>

    <form method="POST" action="">
      <div class="contact_user">
        <input type="text" name="name" placeholder="নাম" class="contact_input" required />
        <input type="text" name="email" placeholder="ইমেইল " class="contact_input" required />
      </div>

      <div class="subject">
        <input type="text" name="subject" placeholder="বিষয়" class="contact_input" />
      </div>

      <div class="contact_msg">
        <textarea name="message" class="contact_area" placeholder="মন্তব্য করুন" required></textarea>
      </div>

      <div class="contact_btn">
        <button type="submit" class="contact_btn_custom" name="contact_us">বার্তা পাঠান</button>
      </div>
    </form>
  </div>
</div>