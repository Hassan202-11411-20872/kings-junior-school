-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2025 at 01:59 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kings_junior_school`
--

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `section` enum('Nursery','Lower Primary','Upper Primary') NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `stream` varchar(50) DEFAULT NULL,
  `has_streams` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `section`, `class_name`, `stream`, `has_streams`, `created_at`) VALUES
(1, 'Nursery', 'Baby Class', NULL, 1, '2025-06-24 07:10:36'),
(2, 'Nursery', 'Middle Class', NULL, 0, '2025-06-24 07:10:56'),
(3, 'Nursery', 'Top Class', 'Blue', 1, '2025-06-24 07:11:45'),
(4, 'Lower Primary', 'Primary 1', 'East', 1, '2025-07-02 20:52:46'),
(5, 'Lower Primary', 'Primary 1', 'West', 1, '2025-07-05 09:37:07'),
(6, 'Nursery', 'Top Class', 'Orange', 1, '2025-07-05 09:38:34'),
(7, 'Lower Primary', 'Primary 2', 'East', 1, '2025-07-05 09:39:16'),
(8, 'Lower Primary', 'Primary 2', 'West', 1, '2025-07-05 09:39:28'),
(9, 'Lower Primary', 'Primary 3', 'East', 1, '2025-07-05 09:39:41'),
(10, 'Lower Primary', 'Primary 3', 'West', 1, '2025-07-05 09:39:51'),
(11, 'Upper Primary', 'Primary 4', 'East', 1, '2025-07-05 09:40:03'),
(12, 'Upper Primary', 'Primary 4', 'West', 1, '2025-07-05 09:40:15'),
(13, 'Upper Primary', 'Primary 5', 'East', 1, '2025-07-05 09:40:27'),
(14, 'Upper Primary', 'Primary 5', 'West', 1, '2025-07-05 09:40:40'),
(15, 'Upper Primary', 'Primary 6', 'East', 1, '2025-07-05 09:40:55'),
(16, 'Upper Primary', 'Primary 6', 'West', 1, '2025-07-05 09:41:07'),
(17, 'Upper Primary', 'Primary 7', '', 0, '2025-07-05 09:45:54');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `min_marks` int(11) NOT NULL,
  `max_marks` int(11) NOT NULL,
  `teacher_comment` text NOT NULL,
  `headteacher_comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `grading_scale`
--

CREATE TABLE `grading_scale` (
  `id` int(11) NOT NULL,
  `min_mark` int(11) NOT NULL,
  `max_mark` int(11) NOT NULL,
  `grade` varchar(5) NOT NULL,
  `remark` varchar(100) NOT NULL,
  `division` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grading_scale`
--

INSERT INTO `grading_scale` (`id`, `min_mark`, `max_mark`, `grade`, `remark`, `division`, `created_at`) VALUES
(1, 0, 39, 'F9', 'Needs Attention', 9, '2025-07-03 05:56:04'),
(2, 40, 44, 'P8', 'More Effort', 8, '2025-07-03 05:56:45'),
(3, 45, 49, 'P7', 'Fair', 7, '2025-07-03 05:57:24'),
(4, 50, 54, 'C6', 'Fair Good', 6, '2025-07-03 05:57:59'),
(5, 55, 59, 'C5', 'Average', 5, '2025-07-03 05:58:55'),
(6, 60, 69, 'C4', 'Good', 4, '2025-07-03 05:59:15'),
(7, 70, 79, 'C3', 'Very Good', 3, '2025-07-03 05:59:44'),
(8, 80, 89, 'D2', 'Excellent', 2, '2025-07-03 06:00:11'),
(9, 90, 100, 'D1', 'Outstanding', 1, '2025-07-03 06:00:36'),
(10, 90, 100, 'D1', 'Outstanding', 1, '2025-07-03 06:02:23');

-- --------------------------------------------------------

--
-- Table structure for table `major_subject_comments`
--

CREATE TABLE `major_subject_comments` (
  `total` int(11) NOT NULL,
  `headteacher_comment` text NOT NULL,
  `teacher_comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `major_subject_comments`
--

INSERT INTO `major_subject_comments` (`total`, `headteacher_comment`, `teacher_comment`) VALUES
(0, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(1, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(2, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(3, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(4, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(5, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(6, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(7, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(8, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(9, 'Needs complete academic overhaul.', 'No attempt. Extremely disappointing.'),
(10, 'Requires emergency intervention.', 'Almost no academic input.'),
(11, 'Requires emergency intervention.', 'Almost no academic input.'),
(12, 'Requires emergency intervention.', 'Almost no academic input.'),
(13, 'Requires emergency intervention.', 'Almost no academic input.'),
(14, 'Requires emergency intervention.', 'Almost no academic input.'),
(15, 'Requires emergency intervention.', 'Almost no academic input.'),
(16, 'Requires emergency intervention.', 'Almost no academic input.'),
(17, 'Requires emergency intervention.', 'Almost no academic input.'),
(18, 'Requires emergency intervention.', 'Almost no academic input.'),
(19, 'Requires emergency intervention.', 'Almost no academic input.'),
(20, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(21, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(22, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(23, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(24, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(25, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(26, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(27, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(28, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(29, 'Urgent turnaround required.', 'Minimal effort or understanding.'),
(30, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(31, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(32, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(33, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(34, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(35, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(36, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(37, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(38, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(39, 'Academic failure imminent.', 'No evidence of effort or understanding.'),
(40, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(41, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(42, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(43, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(44, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(45, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(46, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(47, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(48, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(49, 'Must be closely monitored.', 'Shows no grasp of subjects.'),
(50, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(51, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(52, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(53, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(54, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(55, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(56, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(57, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(58, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(59, 'Take immediate corrective action.', 'Underperforming across all subjects.'),
(60, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(61, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(62, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(63, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(64, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(65, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(66, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(67, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(68, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(69, 'Needs full academic rehabilitation.', 'Extremely low. Must change attitude.'),
(70, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(71, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(72, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(73, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(74, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(75, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(76, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(77, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(78, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(79, 'Plan for urgent improvement.', 'Major knowledge gaps visible.'),
(80, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(81, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(82, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(83, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(84, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(85, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(86, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(87, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(88, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(89, 'Critical performance—parental involvement needed.', 'Serious academic concerns.'),
(90, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(91, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(92, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(93, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(94, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(95, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(96, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(97, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(98, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(99, 'Take immediate steps.', 'Very little comprehension of subjects.'),
(100, 'Student must commit to learning.', 'Little to no effort shown.'),
(101, 'Student must commit to learning.', 'Little to no effort shown.'),
(102, 'Student must commit to learning.', 'Little to no effort shown.'),
(103, 'Student must commit to learning.', 'Little to no effort shown.'),
(104, 'Student must commit to learning.', 'Little to no effort shown.'),
(105, 'Student must commit to learning.', 'Little to no effort shown.'),
(106, 'Student must commit to learning.', 'Little to no effort shown.'),
(107, 'Student must commit to learning.', 'Little to no effort shown.'),
(108, 'Student must commit to learning.', 'Little to no effort shown.'),
(109, 'Student must commit to learning.', 'Little to no effort shown.'),
(110, 'Time to step in with urgent help.', 'Severe academic decline.'),
(111, 'Time to step in with urgent help.', 'Severe academic decline.'),
(112, 'Time to step in with urgent help.', 'Severe academic decline.'),
(113, 'Time to step in with urgent help.', 'Severe academic decline.'),
(114, 'Time to step in with urgent help.', 'Severe academic decline.'),
(115, 'Time to step in with urgent help.', 'Severe academic decline.'),
(116, 'Time to step in with urgent help.', 'Severe academic decline.'),
(117, 'Time to step in with urgent help.', 'Severe academic decline.'),
(118, 'Time to step in with urgent help.', 'Severe academic decline.'),
(119, 'Time to step in with urgent help.', 'Severe academic decline.'),
(120, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(121, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(122, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(123, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(124, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(125, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(126, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(127, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(128, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(129, 'Failing academically. Needs guidance.', 'Extremely poor. Attend remedial lessons.'),
(130, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(131, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(132, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(133, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(134, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(135, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(136, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(137, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(138, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(139, 'Needs strict supervision.', 'Avoiding academic responsibilities.'),
(140, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(141, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(142, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(143, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(144, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(145, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(146, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(147, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(148, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(149, 'Immediate action needed from all sides.', 'Very poor. Lack of interest in academics.'),
(150, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(151, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(152, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(153, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(154, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(155, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(156, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(157, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(158, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(159, 'Follow-up and extra work required.', 'Needs intensive support to improve.'),
(160, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(161, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(162, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(163, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(164, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(165, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(166, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(167, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(168, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(169, 'We are concerned; urgent support needed.', 'Shows little academic engagement.'),
(170, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(171, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(172, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(173, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(174, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(175, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(176, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(177, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(178, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(179, 'Work closely with mentors.', 'Needs full attention to subjects.'),
(180, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(181, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(182, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(183, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(184, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(185, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(186, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(187, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(188, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(189, 'Far below expectations.', 'Inadequate understanding. Must consult teachers.'),
(190, 'Close follow-up is essential.', 'Falling short in many areas.'),
(191, 'Close follow-up is essential.', 'Falling short in many areas.'),
(192, 'Close follow-up is essential.', 'Falling short in many areas.'),
(193, 'Close follow-up is essential.', 'Falling short in many areas.'),
(194, 'Close follow-up is essential.', 'Falling short in many areas.'),
(195, 'Close follow-up is essential.', 'Falling short in many areas.'),
(196, 'Close follow-up is essential.', 'Falling short in many areas.'),
(197, 'Close follow-up is essential.', 'Falling short in many areas.'),
(198, 'Close follow-up is essential.', 'Falling short in many areas.'),
(199, 'Close follow-up is essential.', 'Falling short in many areas.'),
(200, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(201, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(202, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(203, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(204, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(205, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(206, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(207, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(208, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(209, 'We need to support this student more.', 'Struggling academically. Needs intervention.'),
(210, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(211, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(212, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(213, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(214, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(215, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(216, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(217, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(218, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(219, 'Let’s coordinate efforts.', 'Needs support and determination to improve.'),
(220, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(221, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(222, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(223, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(224, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(225, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(226, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(227, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(228, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(229, 'Needs parental and teacher support.', 'Very low marks. Focus and discipline needed.'),
(230, 'We are watching closely.', 'Lack of concentration affecting results.'),
(231, 'We are watching closely.', 'Lack of concentration affecting results.'),
(232, 'We are watching closely.', 'Lack of concentration affecting results.'),
(233, 'We are watching closely.', 'Lack of concentration affecting results.'),
(234, 'We are watching closely.', 'Lack of concentration affecting results.'),
(235, 'We are watching closely.', 'Lack of concentration affecting results.'),
(236, 'We are watching closely.', 'Lack of concentration affecting results.'),
(237, 'We are watching closely.', 'Lack of concentration affecting results.'),
(238, 'We are watching closely.', 'Lack of concentration affecting results.'),
(239, 'We are watching closely.', 'Lack of concentration affecting results.'),
(240, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(241, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(242, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(243, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(244, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(245, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(246, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(247, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(248, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(249, 'Put in more effort to progress.', 'Weak performance. Engage more in class activities.'),
(250, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(251, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(252, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(253, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(254, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(255, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(256, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(257, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(258, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(259, 'A turnaround is possible with effort.', 'Needs improvement across all areas.'),
(260, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(261, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(262, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(263, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(264, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(265, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(266, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(267, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(268, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(269, 'Needs urgent academic attention.', 'Poor results. Work hard and seek help.'),
(270, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(271, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(272, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(273, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(274, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(275, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(276, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(277, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(278, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(279, 'Support and structure recommended.', 'Progress is possible with better study habits.'),
(280, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(281, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(282, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(283, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(284, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(285, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(286, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(287, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(288, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(289, 'Monitor and support closely.', 'A below-average performance. Must improve.'),
(290, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(291, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(292, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(293, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(294, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(295, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(296, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(297, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(298, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(299, 'Let’s help channel their strengths.', 'Needs more consistency and focus.'),
(300, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(301, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(302, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(303, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(304, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(305, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(306, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(307, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(308, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(309, 'Needs to take studies more seriously.', 'A fair try. Greater effort is required.'),
(310, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(311, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(312, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(313, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(314, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(315, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(316, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(317, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(318, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(319, 'Let’s work together to improve.', 'Some progress. Try to stay more focused.'),
(320, 'We believe in your potential.', 'A decent score. More practice needed.'),
(321, 'We believe in your potential.', 'A decent score. More practice needed.'),
(322, 'We believe in your potential.', 'A decent score. More practice needed.'),
(323, 'We believe in your potential.', 'A decent score. More practice needed.'),
(324, 'We believe in your potential.', 'A decent score. More practice needed.'),
(325, 'We believe in your potential.', 'A decent score. More practice needed.'),
(326, 'We believe in your potential.', 'A decent score. More practice needed.'),
(327, 'We believe in your potential.', 'A decent score. More practice needed.'),
(328, 'We believe in your potential.', 'A decent score. More practice needed.'),
(329, 'We believe in your potential.', 'A decent score. More practice needed.'),
(330, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(331, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(332, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(333, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(334, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(335, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(336, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(337, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(338, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(339, 'Encourage to aim higher next term.', 'Fair performance. Strive to improve.'),
(340, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(341, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(342, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(343, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(344, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(345, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(346, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(347, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(348, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(349, 'Can do better with consistent effort.', 'You’re doing well. Focus on weak areas.'),
(350, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(351, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(352, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(353, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(354, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(355, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(356, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(357, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(358, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(359, 'A hardworking student with promise.', 'Above average. Push for excellence.'),
(360, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(361, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(362, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(363, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(364, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(365, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(366, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(367, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(368, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(369, 'Has the potential to reach the top.', 'Strong performance. A little more polish will help.'),
(370, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(371, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(372, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(373, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(374, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(375, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(376, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(377, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(378, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(379, 'Continues to make us proud.', 'Good job. Maintain the momentum.'),
(380, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(381, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(382, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(383, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(384, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(385, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(386, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(387, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(388, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(389, 'Shows strong leadership and academic focus.', 'Great effort and consistent results.'),
(390, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(391, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(392, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(393, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(394, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(395, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(396, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(397, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(398, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(399, 'An excellent learner with bright prospects.', 'Very impressive work. Aim for perfection!'),
(400, 'Excellent. A role model to others!', 'Outstanding performance. Keep it up!');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `term_id` int(11) NOT NULL,
  `exam_type` enum('Mid Term','End Term') NOT NULL,
  `marks` int(11) NOT NULL,
  `remarks` text DEFAULT NULL,
  `recorded_by` int(11) NOT NULL,
  `recorded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `student_id`, `subject_id`, `term_id`, `exam_type`, `marks`, `remarks`, `recorded_by`, `recorded_at`) VALUES
(1, 5, 2, 1, 'Mid Term', 45, 'Fair', 1, '2025-07-03 06:15:27'),
(2, 5, 3, 1, 'Mid Term', 60, 'Good', 1, '2025-07-03 06:15:27'),
(3, 5, 4, 1, 'Mid Term', 70, 'Very Good', 1, '2025-07-03 06:15:27'),
(4, 5, 5, 1, 'Mid Term', 45, 'Fair', 1, '2025-07-03 06:15:27'),
(5, 5, 6, 1, 'Mid Term', 66, 'Good', 1, '2025-07-03 06:15:27'),
(6, 5, 7, 1, 'Mid Term', 80, 'Excellent', 1, '2025-07-03 06:15:27'),
(7, 5, 8, 1, 'Mid Term', 34, 'Needs Attention', 1, '2025-07-03 06:15:27'),
(8, 5, 9, 1, 'Mid Term', 90, 'Outstanding', 1, '2025-07-03 06:15:27'),
(9, 5, 10, 1, 'Mid Term', 90, 'Outstanding', 1, '2025-07-03 06:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `admission_number` varchar(20) UNIQUE,
  `school_pay_number` varchar(20) DEFAULT NULL,
  `full_name` varchar(100) NOT NULL,
  `class_id` int(11) NOT NULL,
  `stream` varchar(50) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('Male','Female') DEFAULT NULL,
  `session` enum('Day Scholar','Boarding Scholar') NOT NULL DEFAULT 'Day Scholar',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `admission_number`, `school_pay_number`, `full_name`, `class_id`, `stream`, `photo_path`, `dob`, `gender`, `session`, `created_at`) VALUES
(2, '1234567890', NULL, 'Hassan mugi', 1, 'East', 'uploads/students/1234567890.png', '2025-06-03', 'Male', 'Day Scholar', '2025-07-03 05:19:49'),
(4, 'GGYYY', NULL, 'ISMAIL', 1, 'East', 'uploads/students/GGYYY.JPG', '2025-07-01', 'Male', 'Day Scholar', '2025-07-03 05:26:13'),
(5, '10000', NULL, 'Muhammad', 4, 'West', 'uploads/students/10000.jpg', '2025-07-01', 'Male', 'Day Scholar', '2025-07-03 05:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `subject_name` varchar(100) NOT NULL,
  `is_core` tinyint(1) DEFAULT 0,
  `max_score` int(11) DEFAULT 100
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `class_id`, `subject_name`, `is_core`, `max_score`) VALUES
(1, 1, 'English', 1, 100),
(2, 4, 'English', 1, 100),
(3, 4, 'Mathematics', 1, 100),
(4, 4, 'Literacy B', 1, 100),
(5, 4, 'Literacy A', 1, 100),
(6, 4, 'Oral', 0, 100),
(7, 4, 'Reading', 0, 100),
(8, 4, 'R.E', 0, 100),
(9, 4, 'Luganda', 0, 100),
(10, 4, 'Luganda', 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) DEFAULT NULL,
  `initials` varchar(10) DEFAULT NULL,
  `subjects` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `user_id`, `class_id`, `initials`, `subjects`) VALUES
(3, 2, 4, 'S.I', 'English'),
(4, 4, 4, 'M.H', 'English, Luganda, Mathematics, Literacy A, Literacy B');

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `year` year(4) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `terms`
--

INSERT INTO `terms` (`id`, `name`, `year`, `start_date`, `end_date`, `is_current`, `created_at`) VALUES
(1, 'Term 2', '2025', NULL, NULL, 1, '2025-07-03 05:51:37'),
(2, 'Term 1', '2025', NULL, NULL, 0, '2025-07-03 05:51:53'),
(3, 'Term 3', '2025', NULL, NULL, 0, '2025-07-03 05:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','teacher') NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `full_name`, `email`, `phone`, `created_at`) VALUES
(1, 'irene', '$2y$10$Dr5hPvfUkf/6fm7pcNRDg.a89zYGHvDBoCs7mdql3yIXTv9FuUQ52', 'admin', 'Irene Admin', 'irene@kingsjunior.ac.ug', '+256700000011', '2025-06-24 06:40:50'),
(2, 'silvia', '$2y$10$C8qU2heA2fV3YW/O.ZGcZOLMACBDP3y3/TjQ5bHdDSbcJnQGc7Btm', 'teacher', 'Silvia Teacher', 'silvia@kingsjunior.ac.ug', '+256700000022', '2025-06-24 06:40:50'),
(4, 'harm', '$2y$10$rVxJJqcXO.PJYsPaWFIZE.tpKIJLBL87a9vLhAQBfPAQPZCRATU.2', 'teacher', 'HASSAN MUGI', 'harm@gmail.com', '070000', '2025-06-24 07:54:25');

-- Table for academic years
CREATE TABLE IF NOT EXISTS academic_years (
  id INT AUTO_INCREMENT PRIMARY KEY,
  year_label VARCHAR(20) NOT NULL,
  is_current TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for terms
CREATE TABLE IF NOT EXISTS terms (
  id INT AUTO_INCREMENT PRIMARY KEY,
  term_label VARCHAR(20) NOT NULL,
  academic_year_id INT NOT NULL,
  is_current TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (academic_year_id) REFERENCES academic_years(id) ON DELETE CASCADE
);

-- Table for student promotion history
CREATE TABLE IF NOT EXISTS student_history (
  id INT AUTO_INCREMENT PRIMARY KEY,
  student_id INT NOT NULL,
  from_class_id INT NOT NULL,
  to_class_id INT NOT NULL,
  promoted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  academic_year_id INT,
  term_id INT,
  FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
  FOREIGN KEY (from_class_id) REFERENCES classes(id),
  FOREIGN KEY (to_class_id) REFERENCES classes(id),
  FOREIGN KEY (academic_year_id) REFERENCES academic_years(id),
  FOREIGN KEY (term_id) REFERENCES terms(id)
);

-- Table for audit logs
CREATE TABLE IF NOT EXISTS audit_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(100) NOT NULL,
  details TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `grading_scale`
--
ALTER TABLE `grading_scale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `major_subject_comments`
--
ALTER TABLE `major_subject_comments`
  ADD PRIMARY KEY (`total`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `term_id` (`term_id`),
  ADD KEY `recorded_by` (`recorded_by`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admission_number` (`admission_number`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grading_scale`
--
ALTER TABLE `grading_scale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `marks`
--
ALTER TABLE `marks`
  ADD CONSTRAINT `marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `marks_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`),
  ADD CONSTRAINT `marks_ibfk_3` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`),
  ADD CONSTRAINT `marks_ibfk_4` FOREIGN KEY (`recorded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `students`
--
ALTER TABLE `students`