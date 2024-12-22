-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2024 at 08:25 PM
-- Server version: 8.0.40
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlynhanvien`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `CalculateScoreByTask` (IN `taskId` INT)   BEGIN
    DECLARE empId INT;
    DECLARE taskPriority VARCHAR(10);
    DECLARE taskStatus VARCHAR(20);
    DECLARE scoreToAdd INT DEFAULT 0;

    -- Lấy thông tin nhiệm vụ
    SELECT assigned_to, priority, status
    INTO empId, taskPriority, taskStatus
    FROM tbltask
    WHERE id = taskId AND is_scored = 0;

    -- Kiểm tra nếu nhiệm vụ tồn tại và chưa được tính điểm
    IF ROW_COUNT() > 0 AND taskStatus = 'Completed' THEN
        -- Tính điểm
        CASE taskPriority
            WHEN 'High' THEN SET scoreToAdd = 100;
            WHEN 'Medium' THEN SET scoreToAdd = 60;
            WHEN 'Low' THEN SET scoreToAdd = 20;
            ELSE SET scoreToAdd = 0;
        END CASE;

        -- Cập nhật điểm cho nhân viên
        UPDATE tblemployees
        SET score = score + scoreToAdd
        WHERE emp_id = empId;

        -- Đánh dấu nhiệm vụ đã tính điểm
        UPDATE tbltask
        SET is_scored = 1
        WHERE id = taskId;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tạo bảng
--

CREATE TABLE `tbldepartments` (
  `id` int NOT NULL,
  `department_name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `department_desc` text COLLATE utf8mb4_vietnamese_ci,
  `creation_date` datetime NOT NULL,
  `last_modified_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Truyền dữ liệu
--

INSERT INTO `tbldepartments` (`id`, `department_name`, `department_desc`, `creation_date`, `last_modified_date`) VALUES
(3, 'Phòng Kỹ Thuật', 'Phụ trách triển khai các dịch vụ bảo mật.\nPhản ứng sự cố (Incident Response).\nNghiên cứu và cập nhật các công nghệ bảo mật mới..', '2024-12-05 11:53:30', '2024-12-06 05:44:04'),
(4, 'Phòng Tư vấn và Đào tạo', 'Cung cấp dịch vụ tư vấn an ninh mạng, chính sách bảo mật.\nĐào tạo nhân sự nội bộ và khách hàng về bảo mật thông tin.', '2024-12-05 11:55:12', NULL),
(5, 'Phòng Phát Triển Sản Phẩm', 'Thiết kế và phát triển các giải pháp bảo mật (phần mềm bảo mật, hệ thống bảo mật tích hợp).', '2024-12-05 11:56:20', NULL),
(6, 'Phòng Nhân Sự', 'Tuyển dụng, đào tạo và phát triển nhân viên.', '2024-12-06 21:42:39', NULL),
(7, 'Phòng Kế Toán', 'Quản lý thu chi của công ty', '2024-12-06 22:05:01', NULL);

-- --------------------------------------------------------

--
-- Tạo bảng
--

CREATE TABLE `tblemployees` (
  `emp_id` int NOT NULL,
  `department` int NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `middle_name` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `phone_number` varchar(20) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `designation` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `email_id` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT '123456',
  `gender` enum('Nam','Nữ','Khác') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `image_path` varchar(255) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_vietnamese_ci DEFAULT NULL,
  `staff_id` varchar(20) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `is_supervisor` int NOT NULL DEFAULT '0',
  `password_reset` tinyint NOT NULL DEFAULT '0',
  `lock_unlock` tinyint NOT NULL DEFAULT '0',
  `date_created` datetime DEFAULT CURRENT_TIMESTAMP,
  `supervisor_id` int DEFAULT NULL,
  `can_be_assigned` enum('YES','NO') COLLATE utf8mb4_vietnamese_ci NOT NULL DEFAULT 'YES',
  `score` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Truyền dữ liệu
--

INSERT INTO `tblemployees` (`emp_id`, `department`, `first_name`, `last_name`, `middle_name`, `phone_number`, `designation`, `email_id`, `password`, `gender`, `image_path`, `role`, `staff_id`, `is_supervisor`, `password_reset`, `lock_unlock`, `date_created`, `supervisor_id`, `can_be_assigned`, `score`) VALUES
(1, 3, 'Lê Anh ', 'Quân', '', '0971618936', 'Network Security Director', 'admin@gmail.com', 'undefined', 'Nam', '../uploads/images/LLM 001_f-1.jpg', 'Manager', 'CF 001', 1, 1, 0, '2024-11-27 22:02:37', NULL, 'NO', 80),
(2, 3, 'Vũ Đức', 'Mạnh', '', '0971618937', 'Security Training Specialist', 'ducmanh@gmail.com', 'undefined', 'Nam', '../uploads/images/LLM 002_f-2.jpg', 'Staff', 'CF 002', 0, 1, 0, '2024-11-28 09:21:32', 3, 'YES', 200),
(3, 1, 'Bá Ngọc', 'Tài', '', '0971618938', 'Security Software Developer', 'ngoctai@gmail.com', '123456', 'Nam', '../uploads/images/LLM 003_f-3.jpg', 'Staff', 'CF 003', 1, 1, 0, '2024-11-28 19:56:20', NULL, 'YES', 0),
(5, 5, 'Đỗ Trần', 'Trung', '', '0971618941', 'CTO', 'trantrung@gmail.com', 'undefined', 'Nam', '../uploads/images/CF 005_testimonial-1.jpg', 'Manager', 'CF 005', 0, 0, 0, '2024-12-06 13:41:17', NULL, 'YES', 0),
(6, 4, 'Lê Thị', 'Nụ', '', '0971618939', 'Tiếp Khách', 'thinu@gmail.com', '123456', 'Nữ', '../uploads/images/CF 006_testimonial-2.jpg', 'Staff', 'CF 006', 0, 0, 0, '2024-12-06 21:37:31', NULL, 'YES', 0),
(7, 6, 'Đỗ Trần', 'Quân', '', '0971618946', 'HR Manager', 'tranquan@gmail.com', '123456', 'Nam', '../uploads/images/CF 007_pexels-hussein-altameemi-2776353.jpg', 'Manager', 'CF 007', 1, 1, 0, '2024-12-06 21:45:32', NULL, 'YES', 0),
(8, 6, 'Vũ Trần ', 'Trang', '', '0971618999', 'HR', 'trantrang@gmail.com', '123456', 'Nữ', '../uploads/images/CF 008_testimonial-4.jpg', 'Staff', 'CF 008', 0, 0, 0, '2024-12-06 21:50:02', NULL, 'YES', 0),
(10, 0, 'Lê ', 'Quân', '', '09716189999', 'ADMIN', 'admin1@gmail.com', '123', 'Nam', '../uploads/images/CF 010_pexels-hussein-altameemi-2776353.jpg', 'Admin', 'CF 010', 0, 1, 0, '2024-12-06 22:20:14', NULL, 'YES', 0),
(11, 5, 'Trần Văn ', 'Mạnh', '', '0987654321', 'Security Operating system', 'vanmanh@gmail.com', '1234', 'Nam', '../uploads/images/CF 011_testimonial-1.jpg', 'Staff', 'CF 011', 0, 1, 0, '2024-12-06 23:52:55', NULL, 'YES', 100),
(12, 4, 'Nguyễn Thu ', 'Trà', '', '0971618936', 'Sales Engineer', 'thutra@gmail.com', '123456', 'Nữ', '../uploads/images/CF 012_pexels-andrea-piacquadio-745136.jpg', 'Staff', 'CF 012', 0, 0, 0, '2024-12-07 00:58:14', NULL, 'YES', 0),
(13, 7, 'Bá Mạnh', 'Tài', '', '0971111111', 'Hốc Trưởng', 'manhtai@gmail.com', 'undefined', 'Nam', '../uploads/images/CF 013_testimonial-3.jpg', 'Staff', 'CF 013', 0, 0, 0, '2024-12-07 00:59:49', NULL, 'YES', 60),
(14, 7, 'Trương Mỹ', 'Lan', '', '0986912092', 'Kế Toán Trưởng', 'mylan@gmail.com', 'undefined', 'Nữ', '../uploads/images/CF 014_anhcanhan-2.jpg', 'Manager', 'CF 014', 0, 0, 0, '2024-12-07 01:09:34', NULL, 'YES', 0);

-- --------------------------------------------------------

--
-- Tạo bảng
--

CREATE TABLE `tbltask` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_vietnamese_ci NOT NULL,
  `description` text COLLATE utf8mb4_vietnamese_ci,
  `assigned_to` int NOT NULL,
  `assigned_by` int NOT NULL,
  `status` enum('Pending','In Progress','Completed') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT 'Pending',
  `priority` enum('Low','Medium','High') CHARACTER SET utf8mb4 COLLATE utf8mb4_vietnamese_ci DEFAULT 'Medium',
  `start_date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_scored` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Truyền dữ liệu
--

INSERT INTO `tbltask` (`id`, `title`, `description`, `assigned_to`, `assigned_by`, `status`, `priority`, `start_date`, `due_date`, `created_at`, `updated_at`, `is_scored`) VALUES
(1, 'Kiểm thử phần mềm', '<p><span style=\"font-family: &quot;Times New Roman&quot;;\">Kiểm thử phần mềm: LMSATTTPTIT, cần có báo cáo chi tiết</span><span style=\"font-family: &quot;Times New Roman&quot;;\">﻿</span></p>', 2, 1, 'Completed', 'High', '2024-12-04', '2024-12-07', '2024-12-05 13:36:25', '2024-12-06 19:54:55', 1),
(2, '1', '<p><br></p>', 1, 1, 'Completed', 'Low', '2024-12-04', '2024-12-06', '2024-12-06 07:35:27', '2024-12-06 19:54:55', 1),
(3, 'Kiểm Thử Xâm Nhập Hệ Thống MB Bank', '<p>Kiểm thử và báo cáo chi tiết</p>', 1, 1, 'Completed', 'Medium', '2024-12-06', '2024-12-07', '2024-12-06 14:58:04', '2024-12-06 19:54:55', 1),
(4, 'Kiểm thử hệ điều hành cho bên Viettel', 'Kiểm thử', 11, 10, 'Completed', 'High', '2024-12-07', '2024-12-07', '2024-12-06 16:54:17', '2024-12-06 19:54:55', 1),
(5, '123', '<p>123</p>', 2, 1, 'Completed', 'High', '2024-12-06', '2024-12-11', '2024-12-06 19:08:04', '2024-12-06 19:54:55', 1),
(13, 'Đớp hết 50% ngân sách công ty', '<p>Đớp thật kín</p>', 13, 10, 'Completed', 'Medium', '2024-12-07', '2024-12-08', '2024-12-06 19:58:49', '2024-12-06 19:59:04', 1);

--
-- 
--

--
-- Indexes for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblemployees`
--
ALTER TABLE `tblemployees`
  ADD PRIMARY KEY (`emp_id`),
  ADD UNIQUE KEY `staff_id` (`staff_id`);

--
-- Indexes for table `tbltask`
--
ALTER TABLE `tbltask`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `assigned_by` (`assigned_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbldepartments`
--
ALTER TABLE `tbldepartments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblemployees`
--
ALTER TABLE `tblemployees`
  MODIFY `emp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbltask`
--
ALTER TABLE `tbltask`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbltask`
--
ALTER TABLE `tbltask`
  ADD CONSTRAINT `tbltask_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `tblemployees` (`emp_id`),
  ADD CONSTRAINT `tbltask_ibfk_2` FOREIGN KEY (`assigned_by`) REFERENCES `tblemployees` (`emp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
