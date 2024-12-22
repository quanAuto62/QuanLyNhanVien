
<?php include('C:\laragon\www\QuanLyNhanVien\includes\config.php'); ?>

<?php

// Gọi stored procedure cho tất cả các nhiệm vụ
$query = "SELECT id FROM tbltask WHERE status = 'Completed'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row['id'];

        // Gọi stored procedure để tính điểm
        $callProcedure = $conn->prepare("CALL CalculateScoreByTask(?)");
        $callProcedure->bind_param('i', $id);
        $callProcedure->execute();
    }
}
$sql = "SELECT first_name, last_name, designation, image_path, score 
        FROM tblemployees 
        ORDER BY score DESC 
        LIMIT 4";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberFort</title>

    <link rel="stylesheet" href="./cssforclient/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="icon" href="./images/pngegg.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="./js/main.js"></script>
</head>


<!-- BODY -->

<body>
    <header class="header">
        <!-- Bootstrap Navbar -->
        <nav class="navbar navbar-expand-lg w-100" style="background-color: transparent;">
            <div class="container-fluid">
                <!-- Logo -->
                <a class="navbar-brand" href="#">
                    <img src="./images/cyber.png" alt="Logo" style="max-width: 150px; max-height:80px;">
                </a>
    
                <!-- Toggler for mobile view -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#home">Trang Chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#about">Về chúng tôi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#service">Dịch vụ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#portfolio">Dự án</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#team">Đội ngũ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="careers.html">Tuyển dụng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#contact">Liên hệ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#faq">Hỏi đáp</a>
                        </li>
                        <a href="index1.php" class="btn btn-outline-light ms-lg-3 feather icon-log-out" style="font-family: 'Roboto', serif; font-size: large;">Đăng nhập</a>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    

    <section id="home" class="home">
        <h1>Chuyên gia bảo mật</h1>
        <h2>bảo vệ từng bước đi của bạn</h2>
        <!-- Hiệu ứng sóng -->
        <div class="wave wave1"></div>
        <div class="wave wave2"></div>
        <div class="wave wave3"></div>
        <div class="wave wave1"></div>
        <div class="wave wave1"></div>
        <div class="wave wave1"></div>
    </section>

    <!-- Về chúng tôi -->
    <section id="about" class="about">
        <h1 class="heading">Về chúng tôi</h1>
        <div class="row">
            <div class="content">
                <h3>Chúng tôi bảo vệ thông tin của bạn, để bạn có thể tập trung vào công việc quan trọng hơn!</h3>
                <p>Sứ mệnh của chúng tôi là tạo ra một môi trường trực tuyến an toàn, bảo vệ thông tin và dữ liệu quan
                    trọng của khách hàng khỏi các mối nguy hiểm trong thế giới số.</b><br>
                    Chúng tôi hiểu rằng bảo mật không chỉ là một dịch vụ mà là yếu tố then chốt quyết định sự thành công
                    và bền vững của doanh nghiệp trong thời đại kỹ thuật số.</p>
                <a href="#"><button class="btn">Đọc tiếp</button></a>
            </div>
        </div>
    </section>

    <!-- Dịch vụ -->
    <div class="pt-5 pb-5" style="background-color: #f2f2f2;">
        <div class="container">
            <div class="row">
                <div class="section-head col-sm-12" id="service">
                    <h1>Dịch vụ của chúng tôi</h1>
                    <p>Chúng tôi cung cấp các giải pháp bảo mật mạng mạnh mẽ để ngăn chặn các cuộc tấn công từ bên ngoài
                        và bên trong, bảo vệ hệ thống mạng của bạn khỏi các mối đe dọa như tấn công DDoS, xâm nhập trái
                        phép, và lỗ hổng bảo mật.
                    </p>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="item"> <span class="icon feature_box_col_one"><i class="fa fa-laptop"></i></span>
                        <h6>Bảo mật mạng</h6>
                        <p>Giám sát và phát hiện xâm nhập (IDS/IPS)<br>
                            Cấu hình tường lửa và VPN<br>
                            Quản lý mạng bảo mật</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="item"> <span class="icon feature_box_col_two"><i class="fa fa-android"></i></span>
                        <h6>Phòng Chống Mã Độc </h6>
                        <p>Phát hiện và ngăn chặn mã độc<br>
                            Phân tích và xử lý sự cố mã độc<br>
                            Quản lý phần mềm diệt virus và bảo vệ điểm cuối<br></p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="item"> <span class="icon feature_box_col_three"><i class="fa fa-magic"></i></span>
                        <h6>Kiểm Tra Bảo Mật</h6>
                        <p>Kiểm tra bảo mật ứng dụng web, API và mạng<br>
                            Đánh giá các lỗ hổng bảo mật hệ thống<br>
                            Báo cáo chi tiết và kế hoạch khắc phục<br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- .... -->
    <section class="counters">
        <div class="container">
            <div>
                <i class="far fa-clock fa-4x"></i>
                <div class="counter" data-target="13500">0</div>
                <h3>Giờ Làm Việc</h3>
            </div>
            <div>
                <i class="fas fa-gift fa-4x"></i>
                <div class="counter" data-target="720">0</div>
                <h3>Dự Án Đã Thực Hiện</h3>
            </div>
            <div>
                <i class="fas fa-users fa-4x"></i>
                <div class="counter" data-target="480">0</div>
                <h3>Khách Hàng</h3>
            </div>
            <div>
                <i class="fas fa-award fa-4x"></i>
                <div class="counter" data-target="120">0</div>
                <h3>Giải Thưởng Quốc Tế</h3>
            </div>
        </div>
    </section>
    <!-- Dự án đã thực hiện -->
    <div class="pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="section-head-1 col-sm-12" style="text-align: center;">
                    <h4 style="margin-top: -5rem;" id="portfolio"><span>Dự án</span> của chúng tôi</h4>

                    <p>chúng tôi tự hào đã thực hiện nhiều dự án bảo mật thành công cho các khách hàng trên toàn thế
                        giới. Mỗi dự án đều thể hiện cam kết của chúng tôi trong việc bảo vệ dữ liệu, hệ thống và mạng
                        của khách hàng khỏi các mối đe dọa.
                    </p>
                </div>

                <div class="col-lg-4 col-sm-6">

                    <div class="item"> <span class="icon feature_box_col_four"><i class="fa fa-database"></i></span>
                        <h6>Phòng Chống Mã Độc Cho Doanh Nghiệp Viettel Telecom</h6>

                        <p>Doanh nghiệp này đã giảm thiểu đáng kể các cuộc tấn công mã độc, bảo vệ được các giao dịch và
                            thông tin khách hàng khỏi sự cố bảo mật.<br><br><br></p>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-6">
                    <div class="item"> <span class="icon feature_box_col_five"><i class="fa fa-upload"></i></span>
                        <h6>kiểm tra hệ thống quản lý dữ liệu của PTIT</h6>
                        <p>Chúng tôi thực hiện kiểm tra bảo mật toàn diện cho một hệ thống quản lý dữ liệu của khách
                            hàng. Các lỗ hổng bảo mật trong phần mềm và cơ sở dữ liệu đã được phát hiện và khắc phục kịp
                            thời.<br><br><br></p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="item"> <span class="icon feature_box_col_six"><i class="fa fa-camera"></i></span>
                        <h6>Đào Tạo Nhận Thức Bảo Mật Cho Doanh Nghiệp FPT</h6>
                        <p>Chúng tôi đã tổ chức các khóa đào tạo về nhận thức bảo mật cho nhân viên của một công ty lớn.
                            Các buổi đào tạo tập trung vào nhận diện và phòng chống các cuộc tấn công phishing và các
                            mối đe dọa từ mạng.<br><br><br></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="communicate">
        <h3>An toàn không phải là tùy chọn</h3>
        <p>đó là yếu tố quyết định sự thành công</p>
        <a href="#contact"><button class="btn">Liên hệ</button></a>
    </div>

    <!-- Nhận xét -->
    <div class="testimonials mt-100">
        <div class="container">
            <div class="section-header" style="text-align: center;">
                <h2 style="margin-top: -15rem;">Nhận xét</h2>
                <p style="font-size: 2rem;">
                    Cùng xem những khách hàng đã nói gì về chúng tôi
                </p>
            </div>

            <div class="owl-carousel testimonials-carousel">
                <div class="testimonial-item row align-items-center">
                    <div class="testimonial-img">
                        <img src="./images/testimonial-1.jpg" alt="Testimonial image">
                    </div>
                    <div class="testimonial-text">
                        <h3>Hussein-Alta</h3>
                        <h4>CEO</h4>
                        <p>
                            Nhận xét

                        </p>
                    </div>
                </div>
                <div class="testimonial-item row align-items-center">
                    <div class="testimonial-img">
                        <img src="./images/testimonial-2.jpg" alt="Testimonial image">
                    </div>
                    <div class="testimonial-text">
                        <h3>Trương Mỹ Lan</h3>
                        <h4>CEO</h4>
                        <p>
                            Nhận xét

                        </p>
                    </div>
                </div>
                <div class="testimonial-item row align-items-center">
                    <div class="testimonial-img">
                        <img src="./images/testimonial-3.jpg" alt="Testimonial image">
                    </div>
                    <div class="testimonial-text">
                        <h3>Changpeng Zhao</h3>
                        <h4>CEO Binance</h4>
                        <p>
                            Nhận xét

                        </p>
                    </div>
                </div>
                <div class="testimonial-item row align-items-center">
                    <div class="testimonial-img">
                        <img src="./images/testimonial-4.jpg" alt="Testimonial image">
                    </div>
                    <div class="testimonial-text">
                        <h3>Nguyễn thị thanh nhàn</h3>
                        <h4>CEO AIC</h4>
                        <p>
                            Nhận xét

                        </p>
                    </div>
                </div>
                <div class="testimonial-item row align-items-center">
                    <div class="testimonial-img">
                        <img src="./images/testimonial-5.jpg" alt="Testimonial image">
                    </div>
                    <div class="testimonial-text">
                        <h3>Andrey aybar</h3>
                        <h4>Designation</h4>
                        <p>
                            Nhận xét

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Khách hàng -->
    <div class="clients mt-100">
        <div class="container">
            <div class="section-header">
                <h2>Khách hàng của chúng tôi</h2>
                <p>
                    Giữ an toàn cho doanh nghiệp của bạn, ngay từ hôm nay.
                </p>
            </div>
            <div class="owl-carousel clients-carousel">
                <img src="./images/fb.png" alt="Client Logo">
                <img src="./images/fpt.jpg" alt="Client Logo">
                <img src="./images/viettel.jpg" alt="Client Logo">
                <img src="./images/ytb.png" alt="Client Logo">
                <img src="./images/tt.png" alt="Client Logo">
                <img src="./images/ptit.jpg" alt="Client Logo">
                <img src="./images/insta.png" alt="Client Logo">
                <img src="./images/neu.png" alt="Client Logo">
            </div>
        </div>
    </div>
    <a href="#" class="back-to-top"><i class="ion-ios-arrow-up"></i></a>
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Nhân sự nổi bật -->
    <section class="team" style="margin-top: 7rem;">
        <h1 class="heading" style="margin-top: -1.5rem;" id="team">Nhân sự nổi bật</h1>
        <p></p>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fullName = $row['first_name'] . " " . $row['last_name'];
                $designation = $row['designation'];
                $imagePath = $row['image_path'];
                $score = $row['score'];
                $imagePath = str_replace('../uploads', './uploads', $imagePath);
                echo '
                <div class="row">
                    <div class="card">
                        <div class="image">
                            <img src="' . htmlspecialchars($imagePath) . '" alt="' . $fullName . '">
                        </div>
                        <div class="info">
                            <h3>' . $fullName . '</h3>
                            <span>' . $designation . '</span>
                            <p>Điểm số: ' . $score . '</p>
                            <div class="icons">
                                <a href="https://www.facebook.com/" class="fab fa-facebook-f"></a>
                                <a href="https://twitter.com/login" class="fab fa-twitter"></a>
                                <a href="https://www.instagram.com/" class="fab fa-instagram"></a>
                                <a href="https://www.linkedin.com/" class="fab fa-linkedin"></a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo "Không có nhân viên nào.";
        }
        ?>
    </section>

    <!-- Liên hệ -->
    <section id="contact" class="contact">
        <h1 class="heading">liên hệ</h1>
    </section>
    <div class="contact-in">
        <div class="contact-map">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30711243.17762776!2d64.4398422293091!3d20.011408266548177!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30635ff06b92b791%3A0xd78c4fa1854213a6!2sIndia!5e0!3m2!1sen!2sin!4v1644684739958!5m2!1sen!2sin" width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3725.8682420405885!2d105.79947128125838!3d20.957805730842644!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ade248c4bf99%3A0x358d9fcd1027863c!2zQ2h1bmcgY8awIDkgdOG6p25nIEPhuqd1IELGsMahdQ!5e0!3m2!1sen!2sin!4v1732866414855!5m2!1sen!2sin"
                width="100%" height="auto" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        <div class="contact-form">
            <form action="./contactme.php" method="POST">
                <input type="text" name="name" placeholder="Họ và tên" class="contact-form-txt" required>
                <input type="tel" id="phone" name="phone" pattern="[0-9]{10}" required placeholder="Thông tin liên lạc"
                    maxlength="10" class="contact-form-phone">
                <input type="email" name="email" placeholder="Email" class="contact-form-email" required>
                <textarea placeholder="Tin nhắn" name="message" class="contact-form-txtarea" required></textarea>
                <input type="submit" value="Gửi" name="submit" class="contact-form-btn">
            </form>
        </div>
    </div>

    <!-- Hỏi đáp -->
    <section class="faq">
        <h1 class="heading" style="margin-top: -2rem; color: #00bfff;" id="faq">Hỏi đáp</h1>
        <div class="row">
            <div class="accordion-container">
                <div class="accordion">
                    <div class="accordion-header">
                        <span>+</span>
                        <h3>Giá cả dịch vụ thế nào?</h3>
                    </div>
                    <div class="accordion-body">
                        <p>Để biết rõ hơn về chi phí của những gì bạn muốn xây dựng, hãy gọi nhanh cho chúng tôi. Chúng
                            tôi sẽ hỏi bạn một số câu hỏi về bản chất của trang web, loại tương tác mà trang web sẽ có,
                            nhu cầu thiết kế đồ họa của bạn, v.v. Sau đó, chúng tôi sẽ có thể cung cấp cho bạn một số
                            liệu về sân chơi bóng chày. Nếu bạn vẫn quan tâm, chúng tôi sẽ đến địa điểm kinh doanh của
                            bạn và đưa ra báo giá chắc chắn.</p>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header">
                        <span>+</span>
                        <h3>Mất bao lâu?</h3>
                    </div>
                    <div class="accordion-body">
                        <p>The time limit of any assignment is normally dictated by the client. If you have any time
                            limit in mind we will attempt to assemble it for you.
                            The main general delay in the making of a website is waiting for the content of the pagjes
                            to be sent to us by the client.</p>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header">
                        <span>+</span>
                        <h3>Tôi có thể làm việc với công ty như thế nào?</h3>
                    </div>
                    <div class="accordion-body">
                        <p>Quá trình bắt đầu khi bạn liên hệ với chúng tôi về yêu cầu của bạn. Chúng tôi phân tích yêu
                            cầu của bạn và trả lời bạn. Trên cơ sở thảo luận thêm, bạn có thể chọn mô hình tương tác phù
                            hợp với mình nhất. Sau đó, chúng tôi bắt đầu quá trình phát triển.</p>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header">
                        <span>+</span>
                        <h3>Công ty của bạn cung cấp những dịch vụ bảo mật nào?</h3>
                    </div>
                    <div class="accordion-body">
                        <p>Chúng tôi cung cấp một loạt các dịch vụ bảo mật chuyên nghiệp, bao gồm bảo mật mạng, phòng
                            chống mã độc, bảo mật đám mây, kiểm tra bảo mật (Penetration Testing), giải pháp bảo mật cho
                            doanh nghiệp, và đào tạo nhận thức bảo mật. Mỗi dịch vụ của chúng tôi đều được thiết kế để
                            đáp ứng nhu cầu bảo mật cụ thể của từng khách hàng.</p>
                    </div>
                </div>
                <div class="accordion">
                    <div class="accordion-header">
                        <span>+</span>
                        <h3>Công ty có hỗ trợ khách hàng trong trường hợp khẩn cấp không?</h3>
                    </div>
                    <div class="accordion-body">
                        <p>Có, chúng tôi cung cấp hỗ trợ 24/7 để ứng phó với các sự cố bảo mật và tấn công mạng. Nếu bạn
                            gặp phải sự cố bảo mật khẩn cấp, đội ngũ chuyên gia của chúng tôi sẽ nhanh chóng can thiệp
                            để giảm thiểu thiệt hại và phục hồi hệ thống của bạn. Chúng tôi cam kết sẽ hỗ trợ bạn trong
                            mọi tình huống khẩn cấp.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Về chúng tôi</h4>
                        <ul>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#">Trang chủ</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#about">Về chúng tôi</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#service">Dịch Vụ</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#">Điều Khoản</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#">chính sách bảo mật</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Hữu dụng</h4>
                        <ul>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#portfolio">Đầu tư</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#team">Đội ngũ</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="careers.html">tuyển dụng</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#contact">Liên hệ</a></li>
                            <li><i class="ion-ios-arrow-forward"></i> <a href="#faq">Hỏi đáp</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-contact" style="font-size: 1.5rem;">
                        <h4>Liên hệ</h4>
                        <p>
                            Tầng 8 chung cư 9 tầng Cầu bươu<br>
                            Thanh Trì, Hà Nội<br>
                            Việt Nam <br>
                            <strong>Tel:</strong> 0971618936<br>
                            <strong>Email:</strong> quanlab21at152@gmail.com<br>
                        </p>

                        <div class="social-links">
                            <a href="https://www.facebook.com/"><i class="ion-logo-facebook"></i></a>
                            <a href="https://twitter.com/login?lang=en"><i class="ion-logo-twitter"></i></a>
                            <a href="https://www.linkedin.com/"><i class="ion-logo-linkedin"></i></a>
                            <a href="https://www.instagram.com/"><i class="ion-logo-instagram"></i></a>
                            <a
                                href="https://accounts.google.com/servicelogin/signinchooser?flowName=GlifWebSignIn&flowEntry=ServiceLogin"><i
                                    class="ion-logo-googleplus"></i></a>
                        </div>

                    </div>

                    <div class="col-lg-3 col-md-6 footer-newsletter">
                        <h4>Dịch vụ</h4>
                        <p>Hãy đăng ký dịch vụ bảo mật của chúng tôi để bảo vệ hệ thống, mạng và dữ liệu quan trọng của
                            bạn khỏi các mối đe dọa và tấn công mạng. Chúng tôi cung cấp các gói dịch vụ bảo mật linh
                            hoạt, phù hợp với nhu cầu của mọi loại hình doanh nghiệp, từ các công ty nhỏ đến các tập
                            đoàn lớn.</p>
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Đăng ký">
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 copyright" style="color: #fff; font-size: 1.3rem;">
                    Copyright &copy; 2024 CyberFort Website. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
      
    <a href="#" class="back-to-top"><i class="ion-ios-arrow-up"></i></a>
</body>

</html>