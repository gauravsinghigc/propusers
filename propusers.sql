-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 12:06 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `propusers`
--

-- --------------------------------------------------------

--
-- Table structure for table `app_quotes`
--

CREATE TABLE `app_quotes` (
  `AppQuotesId` int(100) NOT NULL,
  `AppQuoteName` longtext NOT NULL,
  `AppQuoteDate` varchar(25) NOT NULL,
  `AppQuoteStatus` varchar(10) NOT NULL,
  `AppQuotesCreatedBy` int(10) NOT NULL,
  `AppQuotesCreatedAt` varchar(25) NOT NULL,
  `AppQuotesUpdatedAt` varchar(25) NOT NULL,
  `AppQuotesUpdatedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

CREATE TABLE `assets` (
  `AssetsId` int(100) NOT NULL,
  `AssetName` varchar(1000) NOT NULL,
  `AssetsImage` varchar(1000) NOT NULL,
  `AssetCategory` varchar(100) NOT NULL,
  `AssetModalNo` varchar(100) NOT NULL,
  `AssetSerialNo` varchar(100) NOT NULL,
  `AssetsCost` int(10) NOT NULL,
  `AssetPurchaseDate` varchar(40) NOT NULL,
  `AssetsDescription` varchar(1000) NOT NULL,
  `AssetsCreatedAt` varchar(40) NOT NULL,
  `AssetsUpdatedAt` varchar(40) NOT NULL,
  `AssetsCreatedBy` varchar(40) NOT NULL,
  `AssetsUpdatedBy` varchar(40) NOT NULL,
  `AssetsPurchaseReceipts` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_issued`
--

CREATE TABLE `assets_issued` (
  `AssetsMoveId` int(10) NOT NULL,
  `AssetsMainId` int(10) NOT NULL,
  `AssetsIssuedTo` int(10) NOT NULL,
  `AssetsIssueDate` varchar(20) NOT NULL,
  `AssetsIssueNotes` varchar(255) NOT NULL,
  `AssetsIssuedBy` int(10) NOT NULL,
  `AssetsIssueCreatedAt` varchar(20) NOT NULL,
  `AssetsIssueUpdatedAt` varchar(20) NOT NULL,
  `AssetsIssueStatus` varchar(100) NOT NULL,
  `AssetsIssueReturnedDate` varchar(100) NOT NULL,
  `AssetsIssueReturedTo` varchar(100) NOT NULL,
  `AssetsIssueReturnNotes` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assets_returned`
--

CREATE TABLE `assets_returned` (
  `AssetsReturnedId` int(10) NOT NULL,
  `AssetsMainId` int(10) NOT NULL,
  `AssetsReturnedBy` int(10) NOT NULL,
  `AssetsReturnedDate` varchar(20) NOT NULL,
  `AssetsReturnedNotes` varchar(255) NOT NULL,
  `AssetsReturnReceiveBy` int(10) NOT NULL,
  `AssetsReturnCreatedAt` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `bookingId` int(10) NOT NULL,
  `BookingAckCode` varchar(100) NOT NULL,
  `BookingCustomerName` varchar(100) NOT NULL,
  `BookingCustomerPhone` varchar(100) NOT NULL,
  `BookingForProject` varchar(100) NOT NULL,
  `BookingProjectPhase` varchar(100) NOT NULL,
  `BookingAmount` varchar(10) NOT NULL,
  `BookingPaymentMode` varchar(100) NOT NULL,
  `BookingPaymentSource` varchar(100) NOT NULL,
  `BookingPaymentRefNo` varchar(100) NOT NULL,
  `BookingPaymentDetails` varchar(100) NOT NULL,
  `BookingDate` varchar(100) NOT NULL,
  `BookingNotes` varchar(1000) NOT NULL,
  `BookingCreatedAt` varchar(40) NOT NULL,
  `BookingUpdatedAt` varchar(40) NOT NULL,
  `BookingCreatedBy` varchar(10) NOT NULL,
  `BookingTeamHeadId` varchar(10) NOT NULL,
  `BookingDirectSalePersonId` varchar(10) NOT NULL DEFAULT '1',
  `BookingBusinessHead` varchar(100) NOT NULL,
  `BookingStatus` varchar(100) NOT NULL,
  `BookingUpdatedBy` varchar(10) NOT NULL,
  `BookingMainCustomerId` varchar(100) NOT NULL,
  `LeadsId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_refunds`
--

CREATE TABLE `booking_refunds` (
  `BookingRefundId` int(10) NOT NULL,
  `BookingMainId` int(10) NOT NULL,
  `BookingRefundMode` varchar(100) NOT NULL,
  `BookingRefundSource` varchar(100) NOT NULL,
  `BookingRefundRefNo` varchar(100) NOT NULL,
  `BookingRefundDetails` varchar(10000) NOT NULL,
  `BookingRefundedTo` varchar(100) NOT NULL,
  `BookingRefundDate` varchar(50) NOT NULL,
  `BookingRefundCreatedAt` varchar(50) NOT NULL,
  `BookingRefundUpdatedAt` varchar(50) NOT NULL,
  `BookingRefundBy` int(10) NOT NULL,
  `BookingRefundAmount` varchar(100) NOT NULL,
  `BookingRefundApproxClearingDate` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `booking_refund_documents`
--

CREATE TABLE `booking_refund_documents` (
  `BookingRefundDocId` int(10) NOT NULL,
  `BookingRefundMainId` varchar(10) NOT NULL,
  `BookingRefundDocName` varchar(100) NOT NULL,
  `BookingRefundDocFile` varchar(1000) NOT NULL,
  `BookingRefundDocUploadedAt` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `ChatId` int(100) NOT NULL,
  `ChatRefId` varchar(100) NOT NULL,
  `ChatMainSenderId` varchar(10) NOT NULL,
  `ChatMainReceiverId` varchar(10) NOT NULL,
  `ChatOpenedAt` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_attachements`
--

CREATE TABLE `chat_attachements` (
  `ChatAttachId` int(10) NOT NULL,
  `ChatMsgMainId` int(10) NOT NULL,
  `ChatAttachedFile` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `ChatMessageId` int(10) NOT NULL,
  `ChatMainId` int(100) NOT NULL,
  `ChatMsgSenderId` varchar(10) NOT NULL,
  `ChatMsgReceiverId` varchar(10) NOT NULL,
  `ChatMessageDetails` longtext NOT NULL,
  `ChatMessageSentAt` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circulars`
--

CREATE TABLE `circulars` (
  `CircularId` int(10) NOT NULL,
  `CircularName` varchar(100) NOT NULL,
  `CircularSubject` varchar(200) NOT NULL,
  `CircularDescriptions` longtext NOT NULL,
  `CircularCreatedBy` varchar(10) NOT NULL,
  `CircularUpdatedAt` varchar(40) NOT NULL,
  `CircularCreatedAt` varchar(40) NOT NULL,
  `CircularDate` varchar(40) NOT NULL,
  `CircularStatus` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circular_files`
--

CREATE TABLE `circular_files` (
  `CircularFileId` int(10) NOT NULL,
  `CircularMainId` varchar(10) NOT NULL,
  `CircularDocumentName` varchar(1000) NOT NULL,
  `CircularDocumentFile` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circular_status`
--

CREATE TABLE `circular_status` (
  `CircularStatusId` int(10) NOT NULL,
  `CircularMainId` int(10) NOT NULL,
  `CircularMainUserId` int(10) NOT NULL,
  `CircularViewAt` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comaigns`
--

CREATE TABLE `comaigns` (
  `ComaignId` int(100) NOT NULL,
  `CompaignName` varchar(100) NOT NULL,
  `CompaignDate` varchar(40) NOT NULL,
  `SourceOfCompaign` varchar(100) NOT NULL,
  `ProjectName` varchar(100) NOT NULL,
  `ProjectLocation` varchar(100) NOT NULL,
  `NumberOfLeads` varchar(100) NOT NULL,
  `CompaignCPL` varchar(100) NOT NULL,
  `CompaignForUserId` varchar(100) NOT NULL,
  `CompaignAmountSpent` varchar(100) NOT NULL,
  `CompaingDescription` varchar(1000) NOT NULL,
  `CompaignCreatedAt` varchar(40) NOT NULL,
  `CompaginUpdatedAt` varchar(40) NOT NULL,
  `CompaignStatus` varchar(10) NOT NULL,
  `CompaingAddedBy` varchar(100) NOT NULL,
  `CompaingUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_policies`
--

CREATE TABLE `company_policies` (
  `PolicyId` int(10) NOT NULL,
  `PolicyName` varchar(100) NOT NULL,
  `PolicyDetails` longtext NOT NULL,
  `PolicyActiveFrom` varchar(40) NOT NULL,
  `PolicyCreatedAt` varchar(40) NOT NULL,
  `PolicyUpdatedAt` varchar(40) NOT NULL,
  `PolicyCreatedBy` varchar(40) NOT NULL,
  `PolicyUpdatedBy` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_policies`
--

INSERT INTO `company_policies` (`PolicyId`, `PolicyName`, `PolicyDetails`, `PolicyActiveFrom`, `PolicyCreatedAt`, `PolicyUpdatedAt`, `PolicyCreatedBy`, `PolicyUpdatedBy`) VALUES
(2, 'Leave Policy', 'ekpuaW9xWXFZSSt2L1IrZFlCSllwYjJobWk4UlNhNnR1eWhOc0ZxbHkxND0=', '2022-12-28', '2022-12-28 03:12:02 PM', '2023-02-24 06:27:50 PM', '4', '4'),
(3, 'Medical Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS000QjZHVlVESlVXQkZZb3VQMUNOa0hmaE9GZGVXL1lTbkFKWGZJQVdacUlSc1lFMDJQd3Q4eWtqNjJtQjhBdnBIZUg2M1JVUFRtSHlQK2JXRjJRZ1ZWRm8zcmFPN2FOQlROY3F2Q2lFcTU2', '2022-12-28', '2022-12-28 04:12:42 PM', '2022-12-28 04:12:07 PM', '4', '4'),
(4, 'Health &amp; safty Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS000QjZHVlVESlVXQkZZb3VQMUNOa0hmaE9GZGVXL1lTbkFKWGZJQVdacUlLWit1SklDZDZOZ1RGTXczYmRIYXBCWUNDMjBQb2tqeWdkWjI3UmRKcGl6ck1OMWxtZGVpQ01OY1FsUUlJYWN1', '2022-12-28', '2022-12-28 04:12:56 PM', '2023-02-24 06:28:01 PM', '4', '4'),
(5, 'Break Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBiVEpab2poL3BlRkMvczJVNFpBS1NxalRlQ1p3U083b3hhSHkrN1g2KzdoYjQrTk44b2tWTDBLdWFUckg3UjlLV3ZVYlY1VmVkWVd5aWpIK2hYOWpKaGpDcmRpVWMxcDJZSENnTWk3KzRLUUswd2pYdXIxTDY2a2kwN3NyOWtvUjZBUTR4ZVl5U1ROdjlMYThmZGg1QkFWUGRQU1FpQXFHQUlEeEduanY4WW5YQStGMTFGaHVxYjQ0VXZ2MzhvcVIrV1ZsZElwQ0U3cGkwZWJmVjVkMlhBPT0=', '2022-12-28', '2022-12-28 04:12:19 PM', '2022-12-28 04:12:19 PM', '4', '4'),
(6, 'Time Off work Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHB5eldjNUx6dStmanFEbWl6V2NkN0piNEtQZ216TlFUM283em5zbWNTeWY5dDM2RVdQTGNrQm1jbFFNMGlOTmNwRGtwVEhUN1BKL2VhNUllSElvdzFmaDRqb3R4WlhNazlSNWVBbXdqa0JJN3R5azRmV1RvVEdxSE44MXdubm5PWk9DWm5LSDN1bEY0VitnRU85QXNjT3BjR2ZScU5sWjJUMjFnVHNJUmRNdzY5bzFMazlsYjNWWk8rNStCMlVoUkNGZy92WVhqZ0UxdHdSSC8zdjdrMC9PeHVPc0xaSzFHSzUrdmdwK0NZRkdVPQ==', '2022-12-28', '2022-12-28 04:12:31 PM', '2022-12-28 04:12:31 PM', '4', '4'),
(7, 'On Duty Work Policy', 'bTRvTUo3WTU0OWd6dEl0RDRIdWs4VENoVnNJQ1kyb1d2RWhpYXk4MkxWZz0=', '2022-12-28', '2022-12-28 04:12:02 PM', '2022-12-28 04:12:02 PM', '4', '4'),
(8, 'Termination of employment policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBaSDIxWlgxZnBQd2VCY1R0YmdNRkxrM05UdGdmU2tnbHpSS1dUb0ZWdkFDQjNUR3gzcWs2aUNqNU5wamlJZ1JRWkg3NGtOMUQ4ZzcybUlBd0RMNlkyQm5CREtZMmM2Uml6ZFlUQWhOaTF4VWt2TktTOVhBQnArUVF4VERzZldBQjJ3enJlNllmb05WTG9mV2owVmdlQ3Q3WFhsaXFsNmdpdytwV2lNZHZLZDdHY1M2djdYeDl3VFd1UXpmUkhUcXZXSEZUeHA2ampDT3JQd3I5QStqaG92YjB2R290czNoeGVoTlo1MFBqQ05Db2RsNTgxWGdLU240dVh3SnR0emVwM3cxK2lnZFRTL3lDNnZiTTZnKzR0Zz09', '2022-12-28', '2022-12-28 04:12:16 PM', '2022-12-28 04:12:16 PM', '4', '4'),
(9, 'Dress Code Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBMU1l6cStCZFUxeUV5bDI0Rnorb1NGQWZMRzJtc3htSmRZS1pzTit2NGxJMEJ6M0hQTC9SbEZCd2hPcG1wYUt5MmlUcUlkcUUrVm5sVGR2ZU0zbXVxbVJkdXYwaWxzUGdQQUlVaVVoRXFOSnlMRURnaFRETFRxMWVGK2xxTWpxaXpkdmxIZVJxcEwzN3cvWDRyb3h2S1N2dTlmOXA4ZS9xU2tFZHhud05Gb3JyanluM2d4bnQ5dVJaNVFuMUJidjd1OTJEeUpjTDUwR2IvdDhzV2JCUkFXU25ObGFxaExFck5ZSVFKeDJnK2JZPQ==', '2022-12-28', '2022-12-28 04:12:27 PM', '2022-12-28 04:12:27 PM', '4', '4'),
(10, 'probation and Confirmantion Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBObFpoWkJaQjN6bkpTTFhJOW5HaGI5Y09XRWw0dDl0dExLeTI4d2gwbXZEbjkvdCs3dG1TRTl1b21vQ3ZrQW0zL1pvaFdZTHlrUzJ2RzRwL1VVV2tuemdvckttaDRQQkdVWFc2QkdOd2Z3WldYZHRSTHV2Y2lWaW4wclJNUWkrTUxxT0syVnMxL0dwWXg5U3NIdmlKNldaRzdVakxQVGEwMVYyUlJRbm9ieHBVQk5JOElnSTd0MTkzUEczN2RNdlpoc1ZFRyswUHJZNy9mYXNzOG1qSzF2MXFlMmxCeWdaNW13ZXFRQTV3NDlNTHRZajl0bWx3MmE4Q3VnSDg2UVF6SHpjam5iZnpwSW8rK1FpMmFnNlY4QT09', '2022-12-28', '2022-12-28 04:12:38 PM', '2022-12-28 04:12:38 PM', '4', '4'),
(11, 'Gravience Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBVcU9jRVI2SXYzQlo0cjArUHpPOFlYMTl5NDg0UFVCY1NDTTE2dnpSWVpKV2o1WG1Od1lhVTErbjlkR2JMLzV2OVNoemhWRnZpM2poV1JaUmY3RkxhSnRFazFYNXp5SlZRWmVyTWZncHJLY2w2cEZ0MDhBQXA0djZJY1J1NGd6MS8wWWo4UzlaZ2ZGSDFXbVhuY3BBQ0ZhSkxUdktuVVROQjdoZ3hjdVdvZVVsZjBzQ1lkTkxPN2ZFQTZ3MHVDTTRHNWtnNUg5OUR1M2RkRHlKenlsbVlqSkhFeVpPZ255V2VXL1ZIWWI4NjFrPQ==', '2022-12-28', '2022-12-28 04:12:33 PM', '2022-12-28 04:12:33 PM', '4', '4'),
(12, 'Award and recognization Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBJK0k2eE53Q3BkVnhPL0RZQnRCWU54UitBQXpQdEw1ZzZkOGRtTGEwVmtHM0cwOXpsa3VGYi9UdmprRUpjamRFSXVaUDc4ZFhKZGJxLy9sL0p0bzcwTmMwYXVjcjZvOVExU2xadnVEWjUxZEd2a0RMTnpPMUNZNjFQRDNrMGJvdXBwYjlxMXJOaW5GRjl5SmFRT3E3eDU2V1kyUDBZOGFhdXJxdS92VjdLdzFqcGtQYnR3Vko1UVNJdlBvejZoTElrdU9hNGpqRHV5eHh5K1Z3QmorYUp1bTVaNWpPUnB5S1NCcEwwSGFJNFU4MnBxSlU1UlRjUEhiSHE0M0dzZ05o', '2022-12-28', '2022-12-28 04:12:55 PM', '2022-12-28 04:12:55 PM', '4', '4'),
(13, 'Travel Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHBuV3prWkVpZXVCWDZpKzdlK2tsREsyTWlpNjhzTEhlNXd6NVpyZkdENjBOSHoyS1hQMWJkdWxPeGR1bkVmNUZINTN6VStEeDJxTFRrUlY2Ujd2aUc4eFJpWWQ0WE1PVUlEeXhrMlRSb2p6eTV2aHAwbWxJZ0FWSVlXQTc4QmFOaWhZdFE3M1Npb045ZGF1NDhJVUx0TlFRUUdqOU0vOVFncVEvRkFWUVh1RXNRaHFtRFFpR1lyVGk5V09PeGE0czMyWnR0WTRTWHVNR2VibUJ6L2UrNThnPT0=', '2022-12-28', '2022-12-28 04:12:04 PM', '2022-12-28 04:12:04 PM', '4', '4'),
(14, 'Sexual harrasment in the work Policy', 'bmp0ZXRiMExnb2xFQjdVd1F2bElreWh2dG9OSDRpKzN0WXBNd2tDeHcvVFdyUWRhZkF6SVZDR1R6YWFPcFZhdldTUTcrTzdkQ0tjYk9NQWlKOWxIS0JYSm1PUW9ubUlQOUZrTEtyZVA4K2taazI3dm81NmtxY09vc0NWME5xWHAxVG9QUkVpcEhSYm1icEkvMTlycjRnUmN6MWZLZGQzUjY3N0tIZmRUc2RhUkZnMDd3UUhBT3piMi83VVlaSXNzaFdMM2tPeUZXOGhETDA3MWkyanpPRHA0S1JxNWZ4a0RNUHIybnM0RW1PbmpXUkg4SlE3VFpjbnNXNzRDS1lDSjZlb3F0ZjF3MVJwcXpDcVB4dzdPam1CNFVSQzZwaTUwQ01LVmlZUXZuS20raWNiSGk1bXoxb0dwbzVQbUJzdFBOMC9YWkcvSzNGc3phZXEvREkwZHN3QU1IUWVBNzVyR3BLWDBZM2l4bERkWDdDN1luQjJvdy9yYjJhVmp4N3p5c0pIZ0UxNWlZd0h5SUlPWUVLVis1dz09', '2022-12-28', '2022-12-28 04:12:19 PM', '2022-12-28 04:12:19 PM', '4', '4'),
(15, 'Code Of Conduct Policy ', 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-28', '2022-12-28 04:12:31 PM', '2022-12-28 04:12:31 PM', '4', '4');

-- --------------------------------------------------------

--
-- Table structure for table `company_policy_applicable_on`
--

CREATE TABLE `company_policy_applicable_on` (
  `ApplicableId` int(100) NOT NULL,
  `PolicyMainId` varchar(100) NOT NULL,
  `ApplicableGroupName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_policy_applicable_on`
--

INSERT INTO `company_policy_applicable_on` (`ApplicableId`, `PolicyMainId`, `ApplicableGroupName`) VALUES
(16, '3', 'Admin'),
(17, '3', 'TeamMember'),
(18, '3', 'HR'),
(19, '3', 'Account'),
(20, '3', 'Digital'),
(21, '2', 'Admin'),
(22, '2', 'TeamMember'),
(23, '2', 'HR'),
(24, '2', 'Digital');

-- --------------------------------------------------------

--
-- Table structure for table `configs`
--

CREATE TABLE `configs` (
  `ConfigsId` int(100) NOT NULL,
  `ConfigGroupName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configs`
--

INSERT INTO `configs` (`ConfigsId`, `ConfigGroupName`) VALUES
(1, 'WORK_GROUP'),
(2, 'LEAD_STAGES'),
(5, 'PROJECT_TYPES'),
(6, 'LEAD_PERIORITY_LEVEL'),
(7, 'CALL_STATUS'),
(9, 'LEAD_SOURCES'),
(10, 'CALL_STATUS_SUB_FIELDS'),
(11, 'VISITOR_TYPES'),
(12, 'VISITOR_STATUS'),
(13, 'VISIT_TYPE');

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE `configurations` (
  `configurationsid` int(100) NOT NULL,
  `configurationname` varchar(50) NOT NULL,
  `configurationvalue` varchar(9999) NOT NULL,
  `configurationtype` varchar(30) NOT NULL DEFAULT 'text',
  `configurationsupportivetext` varchar(1000) NOT NULL DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `configurations`
--

INSERT INTO `configurations` (`configurationsid`, `configurationname`, `configurationvalue`, `configurationtype`, `configurationsupportivetext`) VALUES
(1, 'APP_NAME', 'PROP USERS PVT LTD', 'TEXT', 'null'),
(2, 'TAGLINE', 'HOW REAL ESTATE GETS REAL', 'text', 'null'),
(3, 'OWNER_NAME', 'Navix Consultancy Services', 'text', 'null'),
(4, 'PRIMARY_PHONE', '-', 'phone', 'null'),
(5, 'PRIMARY_EMAIL', 'info@roofandassets.com', 'email', 'null'),
(6, 'SHORT_DESCRIPTION', 'bVVObWhBaDNwYnZoTzdBamdKM1Q0Z2ZjNldvTmpWTWtqRFQyazNZUTE2cz0=', 'text', 'null'),
(7, 'PRIMARY_ADDRESS', 'N2w0bUJSKzBzK0RlemZpM2VPMExUUWFSMmJCTFJKb1EvUWxLUHU5UWk2SUtpRk1CditrbldtTXY2NGNaYkhBVEdmVlJOK1V1UmlQNGNLSWZNNlBpeDduWDB5a3hRRDBmQXhsSjU2MzRaYndERjdiSnZ1V1BwVWpXV1N2SkV3ZlptNFdVTDA1eEQ0UkFxdnE2R3NCc0F3PT0=', 'address', 'null'),
(8, 'PRIMARY_MAP_LOCATION_LINK', 'M3N6cEE1V0syMjBKWE9JamJ0d2dERVk0aGNLSGw4cW5SUjYyKzY1NWNvQzVtcmZuc1JkVS81dTRsbFZCaGFuU0ZTVDZ2N1hMNDVuVzNoV3ROaEErZGJRa2hzV2FJbDVjREpGZFo2OUZ0R0pKbnlkNUtuZzFVLzRqdmwycWhnYlZWd0ZGUThnMHA5VE9TdnYwYnpSblZSenlDbUJjNVdFc0xaZEd2Mng5NVBqVnlTYThjZitzaE5ZL04vdU4wdTZnQk1rS3FORnJhYVo5QVBTbzJHczhIaEJTcVgzMStoOHpDM1prRURkV0Z0UFJPMkcyalQ4Mit1Uk5tRWJYUzYrK091R1BkSVR1N3R4ZVpGUTJTSStoM0xCN2xJeko0NXVNMit4Ni9sdyt0M0t2TU45RG5GSXh4U0tmbjRqdzkxcUczNHFlNkhZZHV1SFZTZG9Yc2cwNEpSb0pnbFA5bmlkRk91aHJ2L2NxT0dWUGpTU1A4dEI1MWVOTDVnc05pZlhSYVlQbFdGbVZiQnlQOWk3UE54SFptYjlmUkQ2eEt4SFJhY1gwY1FKd0lXWT0=', 'map', 'null'),
(9, 'SENDER_MAIL_ID', 'info@roofandassets.com', 'email', 'null'),
(10, 'RECEIVER_MAIL', 'info@roofandassets.com', 'email', 'null'),
(11, 'REPLY_TO', 'not available', 'email', 'null'),
(12, 'SUPPORT_MAIL', 'support@roofandassets.com', 'email', 'null'),
(13, 'ENQUIRY_MAIL', 'info@roofandassets.com', 'email', 'null'),
(14, 'ADMIN_MAIL', 'info@roofandassets.com', 'text', 'null'),
(15, 'SMS_API_KEY', 'null', 'text', 'null'),
(16, 'DOWNLOAD_ANDROID_APP_LINK', 'not available', 'link', 'null'),
(17, 'DOWNLOAD_IOS_APP_LINK', 'DOMAIN', 'link', 'null'),
(18, 'DOWNLOAD_BROCHER_LINK', 'DOMAIN\r\n', 'link', 'null'),
(20, 'CONTROL_WORK_ENV', 'DEV', 'boolean', 'dev, prod'),
(21, 'CONTROL_SMS', 'false', 'boolean', 'true, false'),
(23, 'CONTROL_MAILS', 'true', 'boolean', 'true, false'),
(24, 'CONTROL_NOTIFICATION', 'true', 'boolean', 'true, false'),
(25, 'CONTROL_MSG_DISPLAY_TIME', '4500', 'number', '1000, 10000'),
(26, 'CONTROL_APP_LOGS', 'false', 'boolean', 'true, false'),
(27, 'APP_LOGO', 'PROP_USERS_PVT_LTD__21_Mar_2024_03_03_39_5769173264_.jpg', 'img', 'null'),
(28, 'SMS_OTP_TEMP_ID', 'null', 'text', 'null'),
(29, 'PASS_RESET_OTP_TEMP', 'null', 'text', 'null'),
(30, 'SMS_SENDER_ID', 'null', 'text', 'null'),
(31, 'PG_PROVIDER', 'RAZORAPAY', 'text', 'null'),
(32, 'PG_MODE', 'jhvjhdsbvj', 'text', 'null'),
(33, 'MERCHENT_ID', 'jbcjhbdbfm b', 'text', 'null'),
(34, 'MERCHANT_KEY', 'qkjbdjkfbvjdbvkdbkjvbdkjbjkbdjkfd vjdbvgjhdfhbvdf', 'text', 'null'),
(35, 'ONLINE_PAYMENT_OPTION', 'true', 'boolean', 'true, false'),
(36, 'CONTROL_NOTIFICATION_SOUND', 'true', 'boolean', 'true, false'),
(37, 'FINANCIAL_YEAR', 'September - August', 'text', 'null'),
(38, 'GST_NO', '06AALCR4165K1ZZ', 'text', 'null'),
(39, 'COMPANY_TYPE', 'PUBLISHING', 'text', 'null'),
(40, 'LOGIN_BG_IMAGE', 'PROP_USERS_PVT_LTD__21_Mar_2024_03_03_00_23929814228_.jpg', 'text', 'null'),
(41, 'PRIMARY_AREA', 'M3RKYjIyemJJcnFXZ2xLdzZINzdMNVNqRVJFbkY2ZnpTQ1BmNFdQcUgrMD0=', 'text', 'null'),
(42, 'PRIMARY_CITY', 'Q1o2a0w2NEpQOEFLTHA3ZHdNYjh4UT09', 'text', 'null'),
(43, 'PRIMARY_STATE', 'Rm9nUDlDRTVkV20zWm8wMmEvMEpPZz09', 'text', 'null'),
(44, 'PRIMARY_COUNTRY', 'MmtSc3hhcXA1OU1mNjFaYUJ6VVhIZz09', 'text', 'null'),
(45, 'PRIMARY_PINCODE', 'RjV6emhnOUxVeC9ic29tQ25BV211QT09', 'text', 'null'),
(46, 'TAX_NO', 'DELA61323D1', 'text', 'null'),
(47, 'APP_THEME', 'facebook', 'text', 'null'),
(48, 'DEFAULT_RECORD_LISTING', '10', 'text', 'null'),
(49, 'WEBSITE', 'false', 'text', 'null'),
(50, 'APP', 'false', 'text', 'null'),
(51, 'MAX_ORDER_QTY', '', 'text', 'null'),
(52, 'MIN_ORDER_QTY', '', 'text', 'null'),
(53, 'GOOGLE_MAP_API', 'AIzaSyC2Xh8p7kp8B4VZWFonkjVvwfwmPT0A_Hw', 'text', 'null'),
(54, 'MINIMUM_ATTANDANCE_RANGE', '5', 'text', 'null'),
(55, 'OFFICE_START_TIME', '10:00', 'text', 'null'),
(56, 'OFFICE_MAX_START_TIME', '10:15', 'text', 'null'),
(57, 'OFFICE_HALF_DAY_ALLOWED', '16:30', 'text', 'null'),
(58, 'MAXIMUM_ALLOWED_LATE_CHECK_IN', '3', 'text', 'null'),
(59, 'OFFICE_LUNCH_START_TIME', '13:00', 'text', 'null'),
(60, 'OFFICE_END_TIME', '18:30', 'text', 'null'),
(61, 'SHORT_LEAVE_MAX_TIME', '16:30', 'text', 'null'),
(62, 'OFFICE_LUNCH_TIME_IN_MINUTES', '40', 'text', 'null'),
(63, 'WORKING_DAYS_IN_MONTH', '0', 'text', 'null'),
(64, 'AUTO_MONTHLY_PAYROLL_COSING_DATE', '', 'text', 'null'),
(65, 'MAXIMUM_SHORT_LEAVE_IN_MONTH', '3', 'text', 'null'),
(66, 'DEDUCTION_AMOUNT_ON_PER_LATE', '150', 'text', 'null'),
(67, 'EMP_CODE', 'RNA', 'text', 'null'),
(68, 'WEEKLY_OFF_DAY_OF_THE_MONTH', '1', 'text', 'null');

-- --------------------------------------------------------

--
-- Table structure for table `config_holidays`
--

CREATE TABLE `config_holidays` (
  `ConfigHolidayid` int(10) NOT NULL,
  `ConfigHolidayName` varchar(100) NOT NULL,
  `ConfigHolidayFromDate` varchar(25) NOT NULL,
  `ConfigHolidayToDate` varchar(25) NOT NULL,
  `ConfigHolidayNotes` varchar(1000) NOT NULL,
  `ConfigHolidayMediaImage` varchar(1000) NOT NULL,
  `ConfigHolidayCreatedBy` varchar(25) NOT NULL,
  `ConfigHolidayMailStatus` varchar(10) NOT NULL,
  `ConfigHolidayCreatedAt` varchar(25) NOT NULL,
  `ConfigHolidayUpdatedAt` varchar(25) NOT NULL,
  `ConfigHolidayUpdatedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_locations`
--

CREATE TABLE `config_locations` (
  `config_location_id` int(10) NOT NULL,
  `config_location_name` varchar(25) NOT NULL,
  `config_location_address` varchar(255) NOT NULL,
  `config_location_Latitude` varchar(25) NOT NULL,
  `config_location_Longitude` varchar(25) NOT NULL,
  `config_location_status` int(1) NOT NULL,
  `config_location_created_at` varchar(25) NOT NULL,
  `config_location_updated_at` varchar(25) NOT NULL,
  `config_location_created_by` int(10) NOT NULL,
  `config_location_updated_by` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_locations`
--

INSERT INTO `config_locations` (`config_location_id`, `config_location_name`, `config_location_address`, `config_location_Latitude`, `config_location_Longitude`, `config_location_status`, `config_location_created_at`, `config_location_updated_at`, `config_location_created_by`, `config_location_updated_by`) VALUES
(1, 'NOIDA', 'L2pVb2Z2cjhxRVdYUUhlbmVIOHJpRXFRcG40bUhGL1FDUDZhMHp6U3d3OTgxNTlFV2l2R0NybzB5YkxTZnVKRg==', '28.627348', '77.380244', 1, '2023-05-10 05:09:48 pm', '2023-08-29 02:15:38 pm', 1, 1),
(2, 'GURGAON', 'bmwvMkt0VGRXMjZsY0FEaTdHODZ3YnpFNUIrb2FrbGVOQkdzQ2R0S0xrVklYY3NlVm5TK21CN3EzMjFhYTRsWnk5VXpSdnBPeVE5UTZET2RmNWhRMlM5WjNsVE1helZJc2xQK0lZbXpWK0U9', '28.6124729', '77.377668', 1, '2023-05-10 05:11:38 pm', '2023-08-26 06:01:55 pm', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `config_mail_sender`
--

CREATE TABLE `config_mail_sender` (
  `config_mail_sender_id` int(10) NOT NULL,
  `config_mail_sender_host` varchar(255) NOT NULL,
  `config_mail_sender_username` varchar(100) NOT NULL,
  `config_mail_sender_password` varchar(50) NOT NULL,
  `config_mail_sender_port` varchar(10) NOT NULL,
  `config_mail_sent_from` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_mail_sender`
--

INSERT INTO `config_mail_sender` (`config_mail_sender_id`, `config_mail_sender_host`, `config_mail_sender_username`, `config_mail_sender_password`, `config_mail_sender_port`, `config_mail_sent_from`) VALUES
(1, 'smtp.hostinger.com', 'no-reply@roofnassets.com', 'Navix@9810895713', '465', 'no-reply@roofnassets.com');

-- --------------------------------------------------------

--
-- Table structure for table `config_modules`
--

CREATE TABLE `config_modules` (
  `ConfigModuleId` int(100) NOT NULL,
  `ConfigModuleName` varchar(100) NOT NULL,
  `ConfigModuleCreatedAt` varchar(100) NOT NULL,
  `ConfigModuleUpdatedAt` varchar(100) NOT NULL,
  `ConfigModuleUpdatedBy` varchar(100) NOT NULL,
  `ConfigModuleCreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_payroll_allowances`
--

CREATE TABLE `config_payroll_allowances` (
  `payroll_allowance_id` int(10) NOT NULL,
  `payroll_allowance_name` varchar(150) NOT NULL,
  `payroll_allowance_descriptions` varchar(10000) NOT NULL,
  `payroll_allowance_created_at` varchar(30) NOT NULL,
  `payroll_allowance_updated_at` varchar(30) NOT NULL,
  `payroll_allowance_created_by` int(10) NOT NULL,
  `payroll_allowance_updated_by` int(10) NOT NULL,
  `payroll_allowance_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_payroll_allowance_for_users`
--

CREATE TABLE `config_payroll_allowance_for_users` (
  `payroll_allowance_for_emps_id` int(10) NOT NULL,
  `payroll_allowance_for_users_main_user_id` int(10) NOT NULL,
  `payroll_allowance_main_id` int(10) NOT NULL,
  `payroll_allowance_for_users_type` varchar(255) NOT NULL,
  `payroll_allowance_for_users_amount` int(10) NOT NULL,
  `payroll_allowance_for_users_pay_frequency` varchar(255) NOT NULL,
  `payroll_allowance_for_users_effective_date` varchar(40) NOT NULL,
  `payroll_allowance_for_users_created_at` varchar(40) NOT NULL,
  `payroll_allowance_for_users_created_by` int(10) NOT NULL,
  `payroll_allowance_for_users_updated_at` varchar(40) NOT NULL,
  `payroll_allowance_for_users_updated_by` int(10) NOT NULL,
  `payroll_allowance_for_users_status` varchar(10) NOT NULL,
  `payroll_allowance_for_users_notes` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_payroll_deductions`
--

CREATE TABLE `config_payroll_deductions` (
  `payroll_deduction_id` int(10) NOT NULL,
  `payroll_deducation_name` varchar(255) NOT NULL,
  `payroll_deduction_descriptions` varchar(1000) NOT NULL,
  `payroll_deduction_created_at` varchar(40) NOT NULL,
  `payroll_deduction_updated_at` varchar(40) NOT NULL,
  `payroll_deduction_created_by` int(10) NOT NULL,
  `payroll_deduction_updated_by` int(10) NOT NULL,
  `payroll_deduction_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_payroll_deductions_for_users`
--

CREATE TABLE `config_payroll_deductions_for_users` (
  `payroll_deductions_for_users_id` int(10) NOT NULL,
  `payroll_deductions_for_users_main_user_id` int(10) NOT NULL,
  `payroll_deductions_main_id` int(10) NOT NULL,
  `payroll_deductions_for_users_type` varchar(255) NOT NULL,
  `payroll_deductions_for_users_amount` int(10) NOT NULL,
  `payroll_deductions_for_users_effective_date` varchar(40) NOT NULL,
  `payroll_deductions_for_users_created_at` varchar(40) NOT NULL,
  `payroll_deductions_for_users_created_by` int(10) NOT NULL,
  `payroll_deductions_for_users_updated_at` varchar(40) NOT NULL,
  `payroll_deductions_for_users_updated_by` int(10) NOT NULL,
  `payroll_deductions_for_users_status` int(2) NOT NULL,
  `payroll_deductions_for_users_closed_at` varchar(40) NOT NULL,
  `payroll_deductions_for_users_closed_by` int(10) NOT NULL,
  `payroll_deductions_for_users_notes` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `config_pgs`
--

CREATE TABLE `config_pgs` (
  `ConfigPgId` int(100) NOT NULL,
  `ConfigPgProvider` varchar(100) NOT NULL,
  `ConfigPgMode` varchar(100) NOT NULL,
  `ConfigPgMerchantId` varchar(500) NOT NULL,
  `ConfigPgMerchantKey` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_pgs`
--

INSERT INTO `config_pgs` (`ConfigPgId`, `ConfigPgProvider`, `ConfigPgMode`, `ConfigPgMerchantId`, `ConfigPgMerchantKey`) VALUES
(1, 'RAZORAPAY', 'jhvjhdsbvj', 'jbcjhbdbfm b', 'qkjbdjkfbvjdbvkdbkjvbdkjbjkbdjkfd vjdbvgjhdfhbvdf'),
(2, 'PAYTM', 'DEV', 'HJvgh1gh3234jh4vgc3j4c3gh123', '#bkjbhv23h2v3gh232vghvc2gv3gh');

-- --------------------------------------------------------

--
-- Table structure for table `config_values`
--

CREATE TABLE `config_values` (
  `ConfigValueId` int(100) NOT NULL,
  `ConfigValueGroupId` varchar(100) NOT NULL,
  `ConfigValueDetails` varchar(100) NOT NULL,
  `ConfigReferenceId` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `config_values`
--

INSERT INTO `config_values` (`ConfigValueId`, `ConfigValueGroupId`, `ConfigValueDetails`, `ConfigReferenceId`) VALUES
(15, '5', 'Retail Shops', '0'),
(16, '5', 'Residential Plots', '0'),
(17, '5', 'Commercial Space', ''),
(18, '5', 'Farm House', ''),
(19, '5', 'Residential Villas', ''),
(21, '6', 'HIGH', ''),
(22, '6', 'MEDIUM', ''),
(23, '6', 'LOW', ''),
(33, '5', 'SCOs', ''),
(34, '1', 'BH', '0'),
(35, '1', 'TH', ''),
(36, '1', 'SM', ''),
(37, '2', 'FRESH LEAD', ''),
(38, '2', 'FOLLOW UP', ''),
(39, '2', 'JUNK', ''),
(40, '2', 'NOT INTERESTED', ''),
(41, '9', 'Facebook', ''),
(42, '9', 'Instagram', ''),
(43, '9', 'Google Ads', ''),
(44, '9', 'Trade India', ''),
(45, '9', 'India Mart', ''),
(46, '9', '99acre', ''),
(47, '9', 'Housing.in', ''),
(48, '9', 'Others', ''),
(49, '9', 'Self', '0'),
(50, '7', 'Follow Up', ''),
(51, '7', 'NOT Interested', ''),
(52, '7', 'Junk', ''),
(70, '10', 'INFORMATION SHARING', '50'),
(71, '10', 'SITE VISIT PLANNED', '50'),
(72, '10', 'CALL BACK', '50'),
(74, '10', 'SITE VISIT DONE', '50'),
(75, '10', 'LOCATION ISSUE', '51'),
(76, '10', 'BUDGET ISSUE', '51'),
(77, '10', 'JUST WANT AN INFOMRATION', '51'),
(78, '10', 'ALREADY INVESTED', '51'),
(79, '10', 'WRONG NUMBER', '52'),
(80, '10', 'NUMBER NOT UPTO THE MARK', '52'),
(81, '10', 'Others', '50'),
(82, '10', 'Others', '51'),
(83, '10', 'Others', '52'),
(84, '5', 'Residential Flats', '0'),
(85, '5', 'Residential- Low Rise', '0'),
(86, '5', 'Affordable Housing Projects', '0'),
(87, '1', 'Management', '0'),
(89, '10', 'Not Answered', '88'),
(90, '7', 'Sales Closed', '0'),
(91, '10', 'Close', '90'),
(92, '9', 'News Paper ad', '0'),
(93, '10', 'Not Picked', '50'),
(94, '7', 'Ringing', '0'),
(95, '2', 'Ringing', '0'),
(96, '10', 'Ringing', '94'),
(97, '11', 'General Enquiry', '0'),
(98, '11', 'IT Team', '0'),
(99, '11', 'Electrician', '0'),
(100, '11', 'Project Enquiry', '0'),
(101, '11', 'Site Visit', '0'),
(102, '11', 'Payment ', '0'),
(103, '11', 'Job &amp; Interview ', '0'),
(104, '11', 'Courier', '0'),
(111, '12', 'NEW', '0'),
(112, '12', 'Approved', '0'),
(113, '12', 'Please Wait', '0'),
(120, '2', 'Registration', '0'),
(121, '7', 'Registration done', '0'),
(122, '10', 'Registration done', '121'),
(123, '12', 'Selected', '0'),
(124, '12', 'Rejected', '0'),
(125, '7', 'Fresh Leads', '0'),
(126, '10', ' ', '125'),
(127, '2', 'FRESH DATA', '0'),
(128, '13', 'TEST', '0');

-- --------------------------------------------------------

--
-- Table structure for table `creatives`
--

CREATE TABLE `creatives` (
  `CreativeId` int(10) NOT NULL,
  `CreativeName` varchar(100) NOT NULL,
  `CreativeOccasion` varchar(100) NOT NULL,
  `PostedOn` varchar(100) NOT NULL,
  `UploadCreative` varchar(1000) NOT NULL,
  `CreatedOn` varchar(100) NOT NULL,
  `ExecutionDate` varchar(100) NOT NULL,
  `CreatedAt` varchar(40) NOT NULL,
  `UpdatedAt` varchar(40) NOT NULL,
  `CreatedBy` int(10) NOT NULL,
  `UpdatedBy` int(10) NOT NULL,
  `CreativeNotes` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerId` int(10) NOT NULL,
  `CustomerName` varchar(100) NOT NULL,
  `CustomerRelationName` varchar(100) NOT NULL,
  `CustomerPhoneNumber` varchar(100) NOT NULL,
  `CustomerEmailId` varchar(100) NOT NULL,
  `CustomerBirthdate` varchar(100) NOT NULL,
  `CustomerCreatedBy` varchar(10) NOT NULL,
  `CustomerUpdatedBy` varchar(10) NOT NULL,
  `CustomerCreatedAt` varchar(40) NOT NULL,
  `CustomerUpdatedAt` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_address`
--

CREATE TABLE `customer_address` (
  `CustAddressId` int(10) NOT NULL,
  `CustomerMainId` int(100) NOT NULL,
  `CustomerStreetAddress` varchar(500) NOT NULL,
  `CustomerAreaLocality` varchar(100) NOT NULL,
  `CustomerCity` varchar(100) NOT NULL,
  `CustomerState` varchar(100) NOT NULL,
  `CustomerCountry` varchar(100) NOT NULL,
  `CustomerPincode` varchar(10) NOT NULL,
  `CustAddressIfDefault` varchar(10) NOT NULL,
  `CustomerAddressType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_co_address_details`
--

CREATE TABLE `customer_co_address_details` (
  `CustomerCoAddressId` int(10) NOT NULL,
  `MainCoCustomerId` int(10) NOT NULL,
  `CoCustomerStreetAddress` varchar(1000) NOT NULL,
  `CoCustomerAreaLocality` varchar(500) NOT NULL,
  `CoCustomerCity` varchar(100) NOT NULL,
  `CoCustomerState` varchar(150) NOT NULL,
  `CoCustomerCountry` varchar(100) NOT NULL,
  `CoCustomerPincode` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_co_details`
--

CREATE TABLE `customer_co_details` (
  `CustCoId` int(10) NOT NULL,
  `MainCustomerId` varchar(100) NOT NULL,
  `CoCustomerName` varchar(100) NOT NULL,
  `CoCustomerRelationName` varchar(100) NOT NULL,
  `CoCustomerPhoneNumber` varchar(100) NOT NULL,
  `CoCustomerEmailId` varchar(100) NOT NULL,
  `CoCustomerCreatedAt` varchar(40) NOT NULL,
  `CoCustomerUpdatedAt` varchar(40) NOT NULL,
  `CuCustomerCreatedBy` varchar(40) NOT NULL,
  `CoCustomerUpdatedBy` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_co_documents`
--

CREATE TABLE `customer_co_documents` (
  `CustomerCoDocId` int(10) NOT NULL,
  `CustomerCoMainId` int(10) NOT NULL,
  `CustomerCoDocName` varchar(100) NOT NULL,
  `CustomerCoDocNo` varchar(100) NOT NULL,
  `CustomerCoFile` varchar(1000) NOT NULL,
  `CustomerCoUploadedAt` varchar(100) NOT NULL,
  `CustomerUploadedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_documents`
--

CREATE TABLE `customer_documents` (
  `CustomerDocumentId` int(10) NOT NULL,
  `CustomerMainId` varchar(10) NOT NULL,
  `CustomerDocmentType` varchar(100) NOT NULL,
  `CustomerDocumentName` varchar(100) NOT NULL,
  `CustomerDocumentNo` varchar(1000) NOT NULL,
  `CustomerDocumentAttachement` varchar(1000) NOT NULL,
  `CustomerDocUploadedAt` varchar(40) NOT NULL,
  `CustomerDocumentUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_nominees`
--

CREATE TABLE `customer_nominees` (
  `CustNomineeId` int(10) NOT NULL,
  `CustomerMainId` int(10) NOT NULL,
  `CustNomRelation` varchar(100) NOT NULL,
  `CustNomFullName` varchar(100) NOT NULL,
  `CustNomPhoneNumber` varchar(100) NOT NULL,
  `CustNomEmailId` varchar(100) NOT NULL,
  `CustNomStreetAdress` varchar(500) NOT NULL,
  `CustNomAreaLocality` varchar(100) NOT NULL,
  `CustNomCity` varchar(100) NOT NULL,
  `CustNomState` varchar(100) NOT NULL,
  `CustNomCountry` varchar(100) NOT NULL,
  `CustNomPincode` varchar(100) NOT NULL,
  `CustNomDateofbirth` varchar(100) NOT NULL,
  `CustNomCreatedAt` varchar(100) NOT NULL,
  `CustNomUpdatedAt` varchar(100) NOT NULL,
  `CustNomCreatedBy` varchar(100) NOT NULL,
  `CustNomUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customer_notifications`
--

CREATE TABLE `customer_notifications` (
  `CustomerNotificationId` int(100) NOT NULL,
  `CustomerMainId` int(10) NOT NULL,
  `CustNotificationSubject` varchar(200) NOT NULL,
  `CustNotificationDetails` longtext NOT NULL,
  `CustNotificationDate` varchar(40) NOT NULL,
  `CustNotificationStatus` varchar(40) NOT NULL,
  `CustNotificationCreatedBy` varchar(10) NOT NULL,
  `CustNotificationCreatedAt` varchar(40) NOT NULL,
  `CustNotificationUpdatedAt` varchar(40) NOT NULL,
  `CustNotificationReadAt` varchar(10) NOT NULL,
  `CustNotificationSendStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_leads`
--

CREATE TABLE `data_leads` (
  `LeadsId` int(10) NOT NULL,
  `LeadPersonFullname` varchar(100) NOT NULL,
  `LeadSalutations` varchar(10) DEFAULT NULL,
  `LeadPersonPhoneNumber` varchar(12) NOT NULL,
  `LeadPersonEmailId` varchar(100) NOT NULL,
  `LeadPersonAddress` varchar(150) NOT NULL,
  `LeadPersonCreatedAt` varchar(70) NOT NULL,
  `LeadPersonLastUpdatedAt` varchar(70) NOT NULL,
  `LeadPersonCreatedBy` varchar(10) NOT NULL,
  `LeadPersonManagedBy` varchar(10) NOT NULL,
  `LeadPersonStatus` varchar(50) NOT NULL,
  `LeadPriorityLevel` varchar(10) NOT NULL,
  `LeadPersonNotes` varchar(500) NOT NULL,
  `LeadPersonSource` varchar(100) NOT NULL,
  `LeadPersonSubStatus` varchar(70) NOT NULL,
  `LeadProjectId` varchar(5) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `data_upload_id` varchar(255) DEFAULT NULL,
  `activity_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `IndicateTableType` varchar(10) NOT NULL DEFAULT 'Data'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lead_followups`
--

CREATE TABLE `data_lead_followups` (
  `LeadFollowUpId` int(100) NOT NULL,
  `LeadFollowMainId` varchar(100) DEFAULT NULL,
  `DataUploadId` bigint(255) DEFAULT NULL,
  `LeadFollowStatus` varchar(100) NOT NULL,
  `CallStatus` varchar(255) DEFAULT NULL,
  `LeadFollowCurrentStatus` varchar(100) NOT NULL,
  `LeadFollowUpDate` varchar(100) NOT NULL,
  `LeadFollowUpTime` varchar(100) NOT NULL,
  `LeadFollowUpDescriptions` varchar(1000) NOT NULL,
  `LeadFollowUpHandleBy` varchar(100) NOT NULL,
  `LeadFollowUpCreatedAt` varchar(100) NOT NULL,
  `LeadFollowUpCallType` varchar(100) NOT NULL,
  `LeadFollowUpRemindStatus` varchar(1000) NOT NULL,
  `LeadFollowUpRemindNotes` varchar(1000) NOT NULL,
  `LeadFollowUpUpdatedAt` varchar(100) NOT NULL,
  `activity_timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lead_followup_durations`
--

CREATE TABLE `data_lead_followup_durations` (
  `leadcallId` int(10) NOT NULL,
  `LeadCallFollowUpMainId` int(10) NOT NULL,
  `leadcallstartat` varchar(45) NOT NULL,
  `leadcallendat` varchar(45) NOT NULL,
  `leadcallcreatedat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lead_requirements`
--

CREATE TABLE `data_lead_requirements` (
  `LeadRequirementID` int(10) NOT NULL,
  `LeadMainId` int(10) NOT NULL,
  `LeadRequirementDetails` varchar(200) NOT NULL,
  `LeadRequirementCreatedAt` varchar(100) NOT NULL,
  `LeadRequirementStatus` varchar(100) NOT NULL,
  `LeadRequirementNotes` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `data_lead_uploads`
--

CREATE TABLE `data_lead_uploads` (
  `leadsUploadId` int(100) NOT NULL,
  `LeadsUploadBy` varchar(100) NOT NULL,
  `LeadsUploadedfor` varchar(100) NOT NULL,
  `LeadsName` varchar(100) NOT NULL,
  `LeadsEmail` varchar(100) NOT NULL,
  `LeadsPhone` varchar(100) NOT NULL,
  `LeadsAddress` varchar(100) NOT NULL,
  `LeadsCity` varchar(100) NOT NULL,
  `LeadsProfession` varchar(100) NOT NULL,
  `LeadsSource` varchar(100) NOT NULL,
  `UploadedOn` varchar(1000) NOT NULL,
  `UpdatedAt` datetime NOT NULL DEFAULT current_timestamp(),
  `LeadStatus` varchar(100) NOT NULL,
  `LeadProjectsRef` varchar(100) NOT NULL,
  `LeadType` varchar(100) NOT NULL,
  `CallStatus` varchar(255) DEFAULT 'NotDialed',
  `activity_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `IndicateTableType` varchar(255) DEFAULT 'Data Upload'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expanses`
--

CREATE TABLE `expanses` (
  `ExpansesId` bigint(100) NOT NULL,
  `ExpanseName` varchar(200) NOT NULL,
  `ExpanseCategory` varchar(200) NOT NULL,
  `ExpanseTags` varchar(200) NOT NULL,
  `ExpanseAmount` int(10) NOT NULL,
  `ExpanseDescription` varchar(10000) NOT NULL,
  `ExpanseCreatedBy` varchar(100) NOT NULL,
  `ExpanseCreatedFor` varchar(100) NOT NULL,
  `ExpanseDate` varchar(100) NOT NULL,
  `ExpanseCreatedAt` varchar(100) NOT NULL,
  `ExpanseUpdatedAt` varchar(100) NOT NULL,
  `ExpanseUpdatedBy` varchar(100) NOT NULL,
  `ExpanseReceiptAttachment` varchar(1000) NOT NULL,
  `ExpansePaidStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leads`
--

CREATE TABLE `leads` (
  `LeadsId` int(10) NOT NULL,
  `LeadPersonFullname` varchar(100) NOT NULL,
  `LeadSalutations` varchar(10) DEFAULT NULL,
  `LeadPersonPhoneNumber` varchar(12) NOT NULL,
  `LeadPersonEmailId` varchar(100) NOT NULL,
  `LeadPersonAddress` varchar(150) NOT NULL,
  `LeadPersonCreatedAt` varchar(70) NOT NULL,
  `LeadPersonLastUpdatedAt` varchar(70) NOT NULL,
  `LeadPersonCreatedBy` varchar(10) NOT NULL,
  `LeadPersonManagedBy` varchar(10) NOT NULL,
  `LeadPersonStatus` varchar(50) NOT NULL,
  `LeadPriorityLevel` varchar(10) NOT NULL,
  `LeadPersonNotes` varchar(500) NOT NULL,
  `LeadPersonSource` varchar(100) NOT NULL,
  `LeadPersonSubStatus` varchar(70) NOT NULL,
  `LeadProjectId` varchar(5) NOT NULL,
  `companyName` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `activity_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `IndicateTableType` varchar(10) NOT NULL DEFAULT 'Lead'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_followups`
--

CREATE TABLE `lead_followups` (
  `LeadFollowUpId` int(100) NOT NULL,
  `LeadFollowMainId` varchar(100) NOT NULL,
  `LeadFollowStatus` varchar(100) NOT NULL,
  `CallStatus` varchar(255) DEFAULT NULL,
  `LeadFollowCurrentStatus` varchar(100) NOT NULL,
  `LeadFollowUpDate` varchar(100) NOT NULL,
  `LeadFollowUpTime` varchar(100) NOT NULL,
  `LeadFollowUpDescriptions` varchar(1000) NOT NULL,
  `LeadFollowUpHandleBy` varchar(100) NOT NULL,
  `LeadFollowUpCreatedAt` varchar(100) NOT NULL,
  `LeadFollowUpCallType` varchar(100) NOT NULL,
  `LeadFollowUpRemindStatus` varchar(1000) NOT NULL,
  `LeadFollowUpRemindNotes` varchar(1000) NOT NULL,
  `LeadFollowUpUpdatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_followup_durations`
--

CREATE TABLE `lead_followup_durations` (
  `leadcallId` int(10) NOT NULL,
  `LeadCallFollowUpMainId` int(10) NOT NULL,
  `leadcallstartat` varchar(45) NOT NULL,
  `leadcallendat` varchar(45) NOT NULL,
  `leadcallcreatedat` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_requirements`
--

CREATE TABLE `lead_requirements` (
  `LeadRequirementID` int(10) NOT NULL,
  `LeadMainId` int(10) NOT NULL,
  `LeadRequirementDetails` varchar(200) NOT NULL,
  `LeadRequirementCreatedAt` varchar(100) NOT NULL,
  `LeadRequirementStatus` varchar(100) NOT NULL,
  `LeadRequirementNotes` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lead_uploads`
--

CREATE TABLE `lead_uploads` (
  `leadsUploadId` int(100) NOT NULL,
  `LeadsUploadBy` varchar(100) NOT NULL,
  `LeadsUploadedfor` varchar(100) NOT NULL,
  `LeadsName` varchar(100) NOT NULL,
  `LeadsEmail` varchar(100) NOT NULL,
  `LeadsPhone` varchar(100) NOT NULL,
  `LeadsAddress` varchar(100) NOT NULL,
  `LeadsCity` varchar(100) NOT NULL,
  `LeadsProfession` varchar(100) NOT NULL,
  `LeadsSource` varchar(100) NOT NULL,
  `UploadedOn` varchar(1000) NOT NULL,
  `LeadStatus` varchar(100) NOT NULL,
  `LeadProjectsRef` varchar(100) NOT NULL,
  `LeadType` varchar(100) NOT NULL,
  `CallStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `marketing_collaterals`
--

CREATE TABLE `marketing_collaterals` (
  `MarketingCoId` int(100) NOT NULL,
  `MarketingCoProjectName` varchar(100) NOT NULL,
  `MaterialName` varchar(100) NOT NULL,
  `AllotmentDate` varchar(40) NOT NULL,
  `NumberOfMarketingMaterial` varchar(50) NOT NULL,
  `IssuedTo` varchar(100) NOT NULL,
  `Amount` varchar(100) NOT NULL,
  `NoteAndRemarks` varchar(1000) NOT NULL,
  `CreatedAt` varchar(50) NOT NULL,
  `UpdatedAt` varchar(50) NOT NULL,
  `CreatedBy` varchar(50) NOT NULL,
  `UpdatedBy` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newspapercompaigns`
--

CREATE TABLE `newspapercompaigns` (
  `NewCompaignId` int(10) NOT NULL,
  `NewsPaperName` varchar(100) NOT NULL,
  `ProjectName` varchar(100) NOT NULL,
  `CompaignDate` varchar(100) NOT NULL,
  `NewPaperEditions` varchar(100) NOT NULL,
  `NewPaperAdSize` varchar(100) NOT NULL,
  `PublicationDate` varchar(100) NOT NULL,
  `PublicationCost` varchar(100) NOT NULL,
  `UploadCreative` varchar(100) NOT NULL,
  `ContactPersonName` varchar(100) NOT NULL,
  `ContactPersonPhoneNumber` varchar(20) NOT NULL,
  `NewsPaperLink` varchar(1000) NOT NULL,
  `CreatedAt` varchar(100) NOT NULL,
  `UpdatedAt` varchar(100) NOT NULL,
  `CreatedBy` varchar(10) NOT NULL,
  `UpdatedBy` varchar(10) NOT NULL,
  `PublicationNotes` varchar(10000) NOT NULL,
  `CompaignStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationsId` bigint(100) NOT NULL,
  `NotificationRefNo` varchar(100) NOT NULL,
  `NotificationSenderId` int(10) NOT NULL,
  `NotificationReceiverId` int(10) NOT NULL,
  `NotificationDetails` varchar(10000) NOT NULL,
  `NotificationSendDateTime` varchar(30) NOT NULL,
  `NotificationStatus` varchar(10) NOT NULL,
  `NotificationReadAt` varchar(25) NOT NULL,
  `NotificationResponseModule` varchar(1000) NOT NULL,
  `NotificationName` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `od_forms`
--

CREATE TABLE `od_forms` (
  `OdFormId` int(10) NOT NULL,
  `OdReferenceId` varchar(100) NOT NULL,
  `OdMainUserId` int(10) NOT NULL,
  `OdTeamLeaderId` int(10) NOT NULL,
  `OdPermissionTimeFrom` varchar(30) NOT NULL,
  `OdPermissionTimeTo` varchar(30) NOT NULL,
  `OdRequestDate` varchar(40) NOT NULL,
  `OdBriefReason` varchar(1000) NOT NULL,
  `OdLeadMainId` int(100) NOT NULL,
  `OdLocationDetails` varchar(1000) NOT NULL,
  `OdCreatedBy` int(10) NOT NULL,
  `OdCreatedAt` varchar(40) NOT NULL,
  `OdUpdatedAt` varchar(40) NOT NULL,
  `OdUpdatedBy` varchar(40) NOT NULL,
  `ODFormStatus` varchar(100) NOT NULL DEFAULT 'NEW'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `od_form_attachements`
--

CREATE TABLE `od_form_attachements` (
  `OdFormAttachmentId` int(100) NOT NULL,
  `OdFormMainId` varchar(100) NOT NULL,
  `OdFormAttachedFile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `od_form_status`
--

CREATE TABLE `od_form_status` (
  `OdFormStatuslId` int(10) NOT NULL,
  `OdFormMainId` int(10) NOT NULL,
  `OdFormStatusAddedBy` int(10) NOT NULL,
  `OdFormStatusRemarks` varchar(1000) NOT NULL,
  `OdFormStatusAddedAt` varchar(40) NOT NULL,
  `OdFormStatus` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrolls`
--

CREATE TABLE `payrolls` (
  `payrolls_id` int(10) NOT NULL,
  `payrolls_ref_no` varchar(100) NOT NULL,
  `payrolls_from_date` varchar(40) NOT NULL,
  `payrolls_to_date` varchar(40) NOT NULL,
  `payrolls_type` varchar(100) NOT NULL,
  `payrolls_status` varchar(100) NOT NULL,
  `payrolls_created_at` varchar(40) NOT NULL,
  `payrolls_main_user_id` int(10) NOT NULL,
  `payroll_net_presents` int(2) NOT NULL,
  `payroll_short_leaves` int(2) NOT NULL,
  `payroll_holidays` int(2) NOT NULL,
  `payroll_total_presents` int(10) NOT NULL,
  `payroll_total_absants` int(10) NOT NULL,
  `payroll_total_lates` int(10) NOT NULL,
  `payroll_total_meetings` int(10) NOT NULL,
  `payroll_total_leaves` int(10) NOT NULL,
  `payroll_half_days` int(2) NOT NULL,
  `payroll_updated_at` varchar(40) NOT NULL,
  `payroll_closed_at` varchar(40) NOT NULL,
  `payroll_mail_sent_at` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_allowances`
--

CREATE TABLE `payroll_allowances` (
  `pay_allowance_id` int(10) NOT NULL,
  `payroll_main_id` int(10) NOT NULL,
  `pay_allowance_name` varchar(255) NOT NULL,
  `pay_allowance_amount` int(10) NOT NULL,
  `pay_allowance_descriptions` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll_deductions`
--

CREATE TABLE `payroll_deductions` (
  `pay_deduction_id` int(10) NOT NULL,
  `payroll_main_id` int(10) NOT NULL,
  `pay_deduction_name` varchar(255) NOT NULL,
  `pay_deduction_amount` int(10) NOT NULL,
  `pay_deduction_descriptions` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `ProjectsId` int(100) NOT NULL,
  `ProjectName` varchar(100) NOT NULL,
  `ProjectTypeId` int(10) NOT NULL,
  `ProjectDescriptions` varchar(10000) NOT NULL,
  `ProjectCreatedAt` varchar(100) NOT NULL,
  `ProjectCreatedBy` varchar(100) NOT NULL,
  `ProjectUpdatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`ProjectsId`, `ProjectName`, `ProjectTypeId`, `ProjectDescriptions`, `ProjectCreatedAt`, `ProjectCreatedBy`, `ProjectUpdatedAt`) VALUES
(7, 'Gallexie 91', 17, 'N0RwQ0tOV3ZnbkVzaGE4ck5acUVXZz09', '2022-10-01 11:10:10 AM', '1', '2022-11-15 11:11:02 AM'),
(11, 'GCC 88A', 15, 'N0RwQ0tOV3ZnbkVzaGE4ck5acUVXZz09', '2022-10-01 11:10:12 AM', '1', '2022-11-30 11:11:14 AM'),
(13, 'Oasis Grand Stand', 84, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-10-08 01:10:59 PM', '1', '2022-12-30 03:12:33 PM'),
(14, 'GH-89', 86, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-10-08 01:10:28 PM', '1', '2022-10-08 01:10:28 PM'),
(16, 'Yash Vihar- Pataudi Sector-5', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-10-14 01:10:53 PM', '1', '2022-10-14 01:10:53 PM'),
(17, 'Others', 86, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-10-14 01:10:42 PM', '1', '2023-03-10 01:24:30 PM'),
(18, 'Sohna Greens', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-11-12 06:11:38 PM', '1', '2022-11-12 06:11:38 PM'),
(19, 'M3M Sector 79', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-11-19 11:11:45 AM', '1', '2022-11-19 11:11:45 AM'),
(20, 'M3M Route 65', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-11-30 12:11:11 PM', '1', '2022-11-30 12:11:11 PM'),
(21, 'M3M Capital Walk 113', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-11-30 12:11:38 PM', '1', '2022-11-30 12:11:38 PM'),
(22, 'Aashiyara II - Sec 37C', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-14 10:12:28 AM', '1', '2022-12-14 10:12:28 AM'),
(23, 'Flora Avenue 33', 84, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-28 05:12:07 PM', '14', '2022-12-28 05:12:07 PM'),
(24, 'Signature Global City 81', 84, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-30 02:12:45 PM', '14', '2022-12-30 03:12:38 PM'),
(25, 'Ashiana Anmol', 84, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-30 02:12:13 PM', '14', '2022-12-30 02:12:13 PM'),
(26, 'Signature Global Park 4 &amp; 5', 84, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2022-12-30 03:12:24 PM', '14', '2022-12-30 03:12:24 PM'),
(27, 'Orange Prime CIty - Sector 6 (Jhajjar Plots)', 16, 'ZU1aZzNaS3BNR04xeXJnc2dtSFJlWG5zZzB6dnRPRmdMWmQ3RWJMZlFuekJNak1KOThaRnpyTHBWb0NHNzFwSQ==', '2023-01-31 12:01:05 PM', '14', '2023-02-12 09:02:07 PM'),
(28, 'Ganga Realty TATHASTU', 86, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-02-16 01:02:30 PM', '14', '2023-02-16 01:02:53 PM'),
(29, 'Yamuna City Mall', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-05-04 01:14:53 pm', '14', '2023-05-04 01:14:53 pm'),
(30, 'Saras City', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-07-05 02:19:05 pm', '14', '2023-07-05 02:19:05 pm'),
(31, 'DATA', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-07-25 10:17:03 am', '14', '2023-07-25 10:17:03 am'),
(32, 'M3M', 16, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-08-01 11:23:43 am', '14', '2023-08-01 11:23:43 am'),
(33, 'GOKULAM', 16, 'S3V2bGkvK0szRXdUV1BEOXVUbDdzUT09', '2023-08-12 04:23:26 pm', '14', '2023-08-12 04:23:26 pm'),
(34, 'GLS Elitaire', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2023-10-10 04:05:15 PM', '14', '2023-10-10 04:05:15 PM'),
(35, 'ROF Normanton Mall', 17, 'OGFlOTdySWd1M2t0WnNSRlJSc3RyOVl6dy9SRFAvQnRRNlpLWVBnSkFlST0=', '2024-01-09 01:17:25 PM', '14', '2024-01-09 01:17:25 PM'),
(36, 'Swarnim 35', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2024-01-09 02:06:50 PM', '14', '2024-01-09 02:06:50 PM'),
(37, 'Devika Sadar', 17, 'MUxURkNBKzFHSXJHMDZMMkZDaFByQT09', '2024-01-18 04:02:27 PM', '14', '2024-01-18 04:02:27 PM');

-- --------------------------------------------------------

--
-- Table structure for table `project_media_files`
--

CREATE TABLE `project_media_files` (
  `ProjectMediaFileId` int(10) NOT NULL,
  `ProjectMainId` int(10) NOT NULL,
  `ProjectMediaFileName` varchar(1000) NOT NULL,
  `ProjectMediaFileType` varchar(100) NOT NULL,
  `ProjectMediaFileDocument` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project_units`
--

CREATE TABLE `project_units` (
  `project_unit_id` int(10) NOT NULL,
  `project_main_id` int(10) NOT NULL,
  `project_unit_name` varchar(100) NOT NULL,
  `project_unit_type` varchar(100) NOT NULL,
  `project_unit_area` varchar(100) NOT NULL,
  `project_unit_area_type` varchar(100) NOT NULL,
  `project_unit_rate` varchar(50) NOT NULL,
  `project_unit_descriptions` longtext NOT NULL,
  `project_unit_status` varchar(50) NOT NULL,
  `project_unit_created_at` varchar(25) NOT NULL,
  `project_unit_updated_at` varchar(25) NOT NULL,
  `project_unit_created_by` int(10) NOT NULL,
  `project_unit_updated_by` int(10) NOT NULL,
  `project_unit_floor_no` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reception_activity`
--

CREATE TABLE `reception_activity` (
  `reception_activity_id` int(100) NOT NULL,
  `reception_activity_user_main_id` int(10) NOT NULL,
  `reception_activity_type_of_activity` varchar(200) NOT NULL,
  `reception_activity_place_of_activity_number` varchar(200) NOT NULL,
  `reception_activity_customer_email_id` varchar(150) NOT NULL,
  `reception_activity_customer_name` varchar(200) NOT NULL,
  `reception_activity_customer_mobile` int(12) NOT NULL,
  `reception_activity_customer_address` varchar(300) NOT NULL,
  `reception_activity_out_time` varchar(100) NOT NULL,
  `reception_activity_in_time` varchar(100) NOT NULL,
  `reception_activity_city` varchar(100) NOT NULL,
  `reception_activity_state` varchar(100) NOT NULL,
  `reception_activity_pincode` int(200) NOT NULL,
  `reception_activity_status` varchar(20) NOT NULL,
  `reception_activity_note_remark` mediumtext NOT NULL,
  `reception_activity_created_at` varchar(150) NOT NULL,
  `reception_activity_updated_at` varchar(150) NOT NULL,
  `reception_activity_created_by` int(100) NOT NULL,
  `reception_activity_updated_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reception_courier`
--

CREATE TABLE `reception_courier` (
  `reception_courier_id` int(100) NOT NULL,
  `reception_courier_user_main_id` int(10) NOT NULL,
  `reception_courier_name_of_party` varchar(100) NOT NULL,
  `reception_courier_party_contact_number` int(12) NOT NULL,
  `reception_courier_date` varchar(100) NOT NULL,
  `reception_courier_party_address` mediumtext NOT NULL,
  `reception_courier_city` varchar(100) NOT NULL,
  `reception_courier_state` varchar(100) NOT NULL,
  `reception_courier_pincode` int(100) NOT NULL,
  `reception_courier_sender_name` varchar(200) NOT NULL,
  `reception_courier_sender_contact_number` int(12) NOT NULL,
  `reception_courier_name` varchar(200) NOT NULL,
  `reception_courier_tracking_number` varchar(50) NOT NULL,
  `reception_courier_item_details` varchar(100) NOT NULL,
  `reception_courier_receipt_received` varchar(100) NOT NULL,
  `reception_courier_scan_hard_copy` varchar(500) NOT NULL,
  `reception_courier_status` int(15) NOT NULL,
  `reception_courier_returned_date` varchar(50) NOT NULL,
  `reception_courier_returned_reason` varchar(600) NOT NULL,
  `reception_courier_note_remark` mediumtext NOT NULL,
  `reception_courier_created_at` varchar(150) NOT NULL,
  `reception_courier_updated_at` varchar(150) NOT NULL,
  `reception_courier_created_by` int(100) NOT NULL,
  `reception_courier_updated_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reception_meeting`
--

CREATE TABLE `reception_meeting` (
  `reception_meeting_id` int(100) NOT NULL,
  `reception_meeting_user_main_id` int(10) NOT NULL,
  `reception_meeting_date` varchar(50) NOT NULL,
  `reception_Category` varchar(30) NOT NULL,
  `reception_meeting_associate_name` varchar(50) NOT NULL,
  `reception_meeting_associate_mob_no` int(12) NOT NULL,
  `reception_meeting_select_project` int(10) NOT NULL,
  `reception_meeting_descrp_of_meeting` mediumtext NOT NULL,
  `reception_meeting_customer_name` varchar(100) NOT NULL,
  `recption_meeting_customer_mobile` int(12) NOT NULL,
  `reception_meeting_customer_address` varchar(200) NOT NULL,
  `reception_meeting_city` varchar(150) NOT NULL,
  `reception_meeting_state` varchar(150) NOT NULL,
  `recption_meeting_pincode` int(100) NOT NULL,
  `reception_meeting_out_time` varchar(50) NOT NULL,
  `reception_meeting_in_time` varchar(50) NOT NULL,
  `reception_meeting_status` int(10) NOT NULL,
  `reception_meeting_note_remark` mediumtext NOT NULL,
  `reception_meeting_created_at` varchar(150) NOT NULL,
  `reception_meeting_updated_at` varchar(150) NOT NULL,
  `reception_meeting_created_by` int(100) NOT NULL,
  `reception_meeting_updated_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reception_sitevisit`
--

CREATE TABLE `reception_sitevisit` (
  `reception_sitevisit_id` int(11) NOT NULL,
  `reception_sitevisit_user_main_id` varchar(100) NOT NULL,
  `reception_sitevisit_project_to_visit` varchar(100) NOT NULL,
  `reception_sitevisit_booking_date` varchar(100) NOT NULL,
  `reception_sitevisit_associate_name` varchar(200) NOT NULL,
  `reception_sitevisit_associate_mobile_number` int(12) NOT NULL,
  `reception_sitevisit_customer_name` varchar(100) NOT NULL,
  `reception_sitevisit_customer_mobile_number` int(12) NOT NULL,
  `reception_sitevisit_approved_by` varchar(100) NOT NULL,
  `reception_sitevisit_vendor_firm_name` varchar(200) NOT NULL,
  `reception_sitevisit_driver_name` varchar(200) NOT NULL,
  `reception_sitevisit_cab_number` varchar(250) NOT NULL,
  `reception_sitevisit_type_of_vehicle` varchar(200) NOT NULL,
  `reception_sitevisit_open_km` varchar(150) NOT NULL,
  `reception_sitevisit_close_km` varchar(150) NOT NULL,
  `reception_sitevisit_total_km` varchar(150) NOT NULL,
  `reception_sitevisit_in_time` varchar(100) NOT NULL,
  `reception_sitevisit_out_time` varchar(100) NOT NULL,
  `reception_sitevisit_total_hours` varchar(100) NOT NULL,
  `reception_sitevisit_status` varchar(20) NOT NULL,
  `reception_sitevisit_note_remark` mediumtext NOT NULL,
  `reception_sitevisit_created_at` varchar(150) NOT NULL,
  `reception_sitevisit_updated_at` varchar(150) NOT NULL,
  `reception_sitevisit_created_by` int(100) NOT NULL,
  `reception_sitevisit_updated_by` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registrations`
--

CREATE TABLE `registrations` (
  `RegistrationId` int(10) NOT NULL,
  `RegMainCustomerId` varchar(100) NOT NULL,
  `RegCustomRefId` varchar(100) NOT NULL,
  `RegAcknowledgeCode` varchar(100) NOT NULL,
  `RegProjectId` varchar(100) NOT NULL,
  `RegUnitCost` int(100) NOT NULL,
  `RegAllotmentPhase` varchar(100) NOT NULL,
  `RegUnitSizeApplied` varchar(100) NOT NULL,
  `RegProjectCost` int(100) NOT NULL,
  `RegistrationDate` varchar(100) NOT NULL,
  `RegPossessionStatus` varchar(100) NOT NULL,
  `RegTeamHead` varchar(100) NOT NULL,
  `RegDirectSale` varchar(100) NOT NULL,
  `RegBusHead` varchar(100) NOT NULL,
  `RegMailSentStatus` varchar(10) NOT NULL DEFAULT 'false',
  `RegAutoMailSentStatus` varchar(10) NOT NULL DEFAULT 'false',
  `RegStatus` varchar(10) NOT NULL DEFAULT 'Active',
  `RegUnitAlloted` varchar(10) NOT NULL,
  `RegNotes` varchar(10000) NOT NULL,
  `RegCreatedAt` varchar(30) NOT NULL,
  `RegUpdatedAt` varchar(30) NOT NULL,
  `RegCreatedby` int(10) NOT NULL,
  `RegUpdatedBy` int(10) NOT NULL,
  `RegUnitMeasureType` varchar(100) NOT NULL,
  `RegUnitRate` varchar(100) NOT NULL,
  `RegNetCharge` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_activities`
--

CREATE TABLE `registration_activities` (
  `RegActivityId` int(100) NOT NULL,
  `RegMainId` int(10) NOT NULL,
  `RegActivityType` varchar(100) NOT NULL,
  `RegActivityDetails` mediumtext NOT NULL,
  `RegActivityRemindDate` varchar(100) NOT NULL,
  `RegActivityRemindTime` varchar(100) NOT NULL,
  `RegActivityStatus` varchar(100) NOT NULL,
  `RegActivityManagedBy` varchar(10) NOT NULL,
  `RegActivityCreatedBy` varchar(100) NOT NULL,
  `RegActivityCreatedAt` varchar(100) NOT NULL,
  `RegActivityUpdatedAt` varchar(100) NOT NULL,
  `RegActivityUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_charges`
--

CREATE TABLE `registration_charges` (
  `RegChargeId` int(100) NOT NULL,
  `RegistrationMainId` varchar(100) NOT NULL,
  `RegChargeName` varchar(50) NOT NULL,
  `RegChargeType` varchar(15) NOT NULL,
  `RegChargePercentage` varchar(10) NOT NULL,
  `RegChargeAmount` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_members`
--

CREATE TABLE `registration_members` (
  `RegMemberId` int(100) NOT NULL,
  `RegMainId` varchar(100) NOT NULL,
  `RegMemberRole` varchar(100) NOT NULL,
  `RegMemberMainId` varchar(100) NOT NULL,
  `RegMemberNotes` varchar(1000) NOT NULL,
  `RegMemberCreatedAt` varchar(100) NOT NULL,
  `RegMemberUpatedAt` varchar(100) NOT NULL,
  `RegMemUpdatedBy` varchar(100) NOT NULL,
  `RegMemCreatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_nominee_docs`
--

CREATE TABLE `registration_nominee_docs` (
  `RegNomDocId` int(10) NOT NULL,
  `RegMainNomId` int(10) NOT NULL,
  `RegNomDocName` varchar(100) NOT NULL,
  `RegNomDocNo` varchar(100) NOT NULL,
  `RegNomDocFile` varchar(1000) NOT NULL,
  `RegNomDocUploadedAt` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_nom_transfer`
--

CREATE TABLE `registration_nom_transfer` (
  `RegNomTransferId` int(100) NOT NULL,
  `RegMainId` int(100) NOT NULL,
  `RegNomTransferReason` varchar(1000) NOT NULL,
  `RegNomTransferDate` varchar(10000) NOT NULL,
  `RegNomCreatedBy` varchar(100) NOT NULL,
  `RegNomUpdatedBy` varchar(100) NOT NULL,
  `RegNomCreatedAt` varchar(100) NOT NULL,
  `RegNomUpdatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_nom_transfer_docs`
--

CREATE TABLE `registration_nom_transfer_docs` (
  `RegNomTranDocId` int(10) NOT NULL,
  `RegMainTransferId` varchar(10) NOT NULL,
  `RegNomTranDocName` varchar(100) NOT NULL,
  `RegNomDocNo` varchar(100) NOT NULL,
  `RegNomDocFile` varchar(1000) NOT NULL,
  `RegDocUploadedAt` varchar(100) NOT NULL,
  `RegDocUploadedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_payments`
--

CREATE TABLE `registration_payments` (
  `RegPaymentId` int(100) NOT NULL,
  `RegPayCustRefId` varchar(100) NOT NULL,
  `RegMainId` varchar(100) NOT NULL,
  `RegPayMode` varchar(100) NOT NULL,
  `RegPayTotalAmount` int(50) NOT NULL,
  `RegPayTaxPercentage` int(50) NOT NULL,
  `RegPaySourceName` varchar(100) NOT NULL,
  `RegPaySourceNo` varchar(100) NOT NULL,
  `RegPayReferenceNo` varchar(100) NOT NULL,
  `RegPayChequeDDNo` varchar(100) NOT NULL,
  `RegPayOtherDetails` varchar(10000) NOT NULL,
  `RegPaymentStatus` varchar(20) NOT NULL,
  `RegPaymentCreatedAt` varchar(30) NOT NULL,
  `RegPayCashReceivedBy` varchar(10) NOT NULL,
  `RegPaymentReceivedBy` varchar(100) NOT NULL,
  `RegPaymentUpdatedAt` varchar(30) NOT NULL,
  `RegPaymentUploadReceipt` varchar(10) NOT NULL,
  `RegPaymentCreatedBy` varchar(10) NOT NULL,
  `RegPayClearedAt` varchar(30) NOT NULL,
  `RegPaymentDate` varchar(30) NOT NULL,
  `RegPaymentFailedAt` varchar(30) NOT NULL,
  `RegPatmentBounceAt` varchar(30) NOT NULL,
  `RegChequePayIssueBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_payment_activities`
--

CREATE TABLE `registration_payment_activities` (
  `RegPayActivityId` int(100) NOT NULL,
  `RegPayId` varchar(100) NOT NULL,
  `RegPayActivityDate` varchar(50) NOT NULL,
  `RegPayPreviousDetails` varchar(1000) NOT NULL,
  `RegPayRecordUpdatedBy` varchar(50) NOT NULL,
  `RegLastPayStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_refunds`
--

CREATE TABLE `registration_refunds` (
  `RegRefundId` int(10) NOT NULL,
  `RegMainId` int(10) NOT NULL,
  `RegRefundCustomRefId` varchar(100) NOT NULL,
  `RegRefundReason` varchar(500) NOT NULL,
  `RegRefundMode` varchar(200) NOT NULL,
  `RegRefundNotes` mediumtext NOT NULL,
  `RegRefundCreateDate` varchar(100) NOT NULL,
  `RegRefundStatus` varchar(20) NOT NULL,
  `RegRefundDate` varchar(100) NOT NULL,
  `RegRefundCreatedAt` varchar(100) NOT NULL,
  `RegRefundUpdatedAt` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `registration_refund_documents`
--

CREATE TABLE `registration_refund_documents` (
  `RegRefundDocId` int(10) NOT NULL,
  `RegMainRefundId` int(10) NOT NULL,
  `RegRefundDocName` varchar(100) NOT NULL,
  `RegRefundDoNo` varchar(100) NOT NULL,
  `RegRefundDocFile` varchar(200) NOT NULL,
  `RegRefundCreatedOn` varchar(100) NOT NULL,
  `RegRefundUpdatedOn` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `systemlogs`
--

CREATE TABLE `systemlogs` (
  `LogsId` int(100) NOT NULL,
  `logTitle` varchar(200) NOT NULL,
  `logdesc` varchar(1000) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `systeminfo` varchar(1000) NOT NULL,
  `logtype` varchar(100) NOT NULL,
  `logenv` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE `trainings` (
  `TrainingId` int(10) NOT NULL,
  `TrainingName` varchar(100) NOT NULL,
  `TrainingStartDate` varchar(100) NOT NULL,
  `TrainingEndDate` varchar(25) NOT NULL,
  `TrainingStartTime` varchar(25) NOT NULL,
  `TrainingEndTime` varchar(100) NOT NULL,
  `TrainingDetails` longtext NOT NULL,
  `TrainingDescriptions` varchar(100) NOT NULL,
  `TrainingCreatedAt` varchar(40) NOT NULL,
  `TrainingUpdatedAt` varchar(40) NOT NULL,
  `TrainingCreatedBy` varchar(50) NOT NULL,
  `TrainingUpdatedBy` varchar(50) NOT NULL,
  `TrainingMode` varchar(100) NOT NULL,
  `TrainingStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_members`
--

CREATE TABLE `training_members` (
  `TrainingMemberId` int(10) NOT NULL,
  `TrainingMainId` int(10) NOT NULL,
  `TrainingUserId` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserId` int(100) NOT NULL,
  `UserSalutation` varchar(1000) NOT NULL,
  `UserFullName` varchar(500) NOT NULL,
  `UserPhoneNumber` varchar(100) NOT NULL,
  `UserEmailId` varchar(1000) NOT NULL,
  `UserPassword` varchar(500) NOT NULL,
  `UserCreatedAt` varchar(25) NOT NULL DEFAULT 'current_timestamp(6)',
  `UserUpdatedAt` varchar(25) NOT NULL DEFAULT 'current_timestamp(6)',
  `UserStatus` tinyint(1) NOT NULL DEFAULT 1,
  `UserNotes` longtext NOT NULL,
  `UserCompanyName` varchar(1000) NOT NULL,
  `UserDepartment` varchar(1000) NOT NULL,
  `UserDesignation` varchar(1000) NOT NULL,
  `UserWorkFeilds` varchar(1000) NOT NULL,
  `UserProfileImage` varchar(1000) NOT NULL DEFAULT 'default.png',
  `UserType` varchar(1000) NOT NULL,
  `UserDateOfBirth` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserId`, `UserSalutation`, `UserFullName`, `UserPhoneNumber`, `UserEmailId`, `UserPassword`, `UserCreatedAt`, `UserUpdatedAt`, `UserStatus`, `UserNotes`, `UserCompanyName`, `UserDepartment`, `UserDesignation`, `UserWorkFeilds`, `UserProfileImage`, `UserType`, `UserDateOfBirth`) VALUES
(1, 'Mr.', 'PROPUSERS ADMIN', '9876543210', 'admin@propusers.com', '9810', '0000-00-00 00:00:00.00000', '19 Mar, 2024', 1, 'YkVYdnY2YmtTdHBSRVkxbW95bFEyWTl6L2YxNUhpQ1NRK0FFR1BMRnpDN0JnUEdFTzNwb0NJaUptK2V6WDJUTQ==', 'Navix Consultancy Services', 'Sales &amp; Marketing', 'Sales Head', 'Information Technology', 'Profile_Photo__UID_1__19_Mar_2024_12_03_30_51865188552_.jpg', 'Admin', '2022-11-02'),
(3, 'Mr.', 'Gaurav Singh', '+919625454982', 'navix365@gmail.com', '9810', '0000-00-00 00:00:00.00000', '2022-10-16 05:17:06.03825', 1, '', '', '', '', '', 'default.png', 'TeamMember', '1983-04-03');

-- --------------------------------------------------------

--
-- Table structure for table `user_access`
--

CREATE TABLE `user_access` (
  `UserAccessId` int(100) NOT NULL,
  `UserAccessUserId` int(100) NOT NULL,
  `UserAccessName` varchar(100) NOT NULL,
  `UserAccessCreatedAt` datetime(6) NOT NULL,
  `UserAccessUpdatedAt` datetime(6) NOT NULL,
  `UserAccessStatus` varchar(10) DEFAULT 'true',
  `UserAccessNotes` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_access`
--

INSERT INTO `user_access` (`UserAccessId`, `UserAccessUserId`, `UserAccessName`, `UserAccessCreatedAt`, `UserAccessUpdatedAt`, `UserAccessStatus`, `UserAccessNotes`) VALUES
(1, 1, 'Admin', '2023-09-13 10:55:24.000000', '0000-00-00 00:00:00.000000', '1', ''),
(2, 3, 'TeamMember', '2023-09-13 10:55:24.000000', '0000-00-00 00:00:00.000000', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_addresses`
--

CREATE TABLE `user_addresses` (
  `UserAddressId` int(100) NOT NULL,
  `UserAddressUserId` int(100) NOT NULL,
  `UserStreetAddress` varchar(10000) NOT NULL,
  `UserLocality` varchar(200) NOT NULL,
  `UserCity` varchar(200) NOT NULL,
  `UserState` varchar(200) NOT NULL,
  `UserCountry` varchar(200) NOT NULL,
  `UserPincode` varchar(200) NOT NULL,
  `UserAddressType` varchar(100) NOT NULL,
  `UserAddressContactPerson` varchar(1000) NOT NULL,
  `UserAddressNotes` varchar(1000) NOT NULL,
  `UserAddressMapUrl` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_allowed_leaves`
--

CREATE TABLE `user_allowed_leaves` (
  `UserAllowedLeaveId` int(10) NOT NULL,
  `UserALMainUserId` int(10) NOT NULL,
  `UserAllowedLeaveYear` varchar(20) NOT NULL,
  `UserAllowedLeaveCreatedAt` varchar(25) NOT NULL,
  `UserAllowedLeaveCreatedBy` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_appraisals`
--

CREATE TABLE `user_appraisals` (
  `UserAppraisalId` int(10) NOT NULL,
  `UserAppraisalRefNo` varchar(100) NOT NULL,
  `UserAppraisalName` varchar(200) NOT NULL,
  `UserAppraisalMainUserId` int(10) NOT NULL,
  `UserAppraisalMessage` varchar(1000) NOT NULL,
  `UserAppraisalCreatedBy` varchar(10) NOT NULL,
  `UserAppraisalDate` varchar(40) NOT NULL,
  `UserAppraisalCreatedAt` varchar(40) NOT NULL,
  `UserAppraisalViewAt` varchar(100) NOT NULL,
  `UserAppraisalStatus` varchar(100) NOT NULL,
  `UserAppraisalUpdatedAt` varchar(100) NOT NULL,
  `UserAppraisalUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_attandance_check_in`
--

CREATE TABLE `user_attandance_check_in` (
  `check_in_id` int(100) NOT NULL,
  `check_in_main_user_id` int(10) NOT NULL,
  `check_in_location_longitude` varchar(50) NOT NULL,
  `check_in_location_latitude` varchar(50) NOT NULL,
  `check_in_date_time` varchar(50) NOT NULL,
  `check_in_ip_address` varchar(500) NOT NULL,
  `check_in_device_mac_address` varchar(500) NOT NULL,
  `check_in_device_info` varchar(10000) NOT NULL,
  `check_in_created_at` varchar(25) NOT NULL,
  `check_in_created_by` int(10) NOT NULL,
  `check_in_updated_at` varchar(25) NOT NULL,
  `check_in_update_by` int(10) NOT NULL,
  `check_in_status` varchar(100) NOT NULL,
  `check_in_distance` varchar(100) NOT NULL,
  `check_in_time_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_attandance_check_out`
--

CREATE TABLE `user_attandance_check_out` (
  `check_out_id` int(100) NOT NULL,
  `check_out_main_check_in_id` int(10) NOT NULL,
  `check_out_main_user_id` int(10) NOT NULL,
  `check_out_location_longitude` varchar(50) NOT NULL,
  `check_out_location_latitude` varchar(50) NOT NULL,
  `check_out_date_time` varchar(50) NOT NULL,
  `check_out_ip_address` varchar(255) NOT NULL,
  `check_out_device_mac_address` varchar(255) NOT NULL,
  `check_out_device_info` varchar(500) NOT NULL,
  `check_out_created_at` varchar(25) NOT NULL,
  `check_out_created_by` int(10) NOT NULL,
  `check_out_updated_at` varchar(25) NOT NULL,
  `check_out_updated_by` int(10) NOT NULL,
  `check_out_status` varchar(50) NOT NULL,
  `check_out_distance` varchar(50) NOT NULL,
  `check_out_time_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `UserBankDetailsId` int(100) NOT NULL,
  `UserMainId` varchar(100) NOT NULL,
  `UserBankName` varchar(100) NOT NULL,
  `UserBankAccountNo` varchar(100) NOT NULL,
  `UserBankIFSC` varchar(100) NOT NULL,
  `UserBankAccoundHolderName` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_day_breaks`
--

CREATE TABLE `user_day_breaks` (
  `day_break_id` int(100) NOT NULL,
  `day_break_main_user_id` int(10) NOT NULL,
  `day_break_location_longitude` varchar(50) NOT NULL,
  `day_break_location_latitude` varchar(50) NOT NULL,
  `day_break_start_date_time` varchar(80) NOT NULL,
  `day_break_end_date_time` varchar(80) NOT NULL,
  `day_break_ip_address` varchar(255) NOT NULL,
  `day_break_device_info` varchar(1055) NOT NULL,
  `day_break_created_at` varchar(25) NOT NULL,
  `day_break_updated_at` varchar(25) NOT NULL,
  `day_break_created_by` int(11) NOT NULL,
  `day_break_updated_by` int(11) NOT NULL,
  `day_break_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_documents`
--

CREATE TABLE `user_documents` (
  `UserDocsId` int(100) NOT NULL,
  `UserMainId` varchar(100) NOT NULL,
  `UserDocumentNo` varchar(100) NOT NULL,
  `UserDocumentName` varchar(100) NOT NULL,
  `UserDocumentFile` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_employment_details`
--

CREATE TABLE `user_employment_details` (
  `UserEmpDetailsId` int(100) NOT NULL,
  `UserMainUserId` varchar(10) NOT NULL,
  `UserEmpBackGround` varchar(100) NOT NULL,
  `UserEmpTotalWorkExperience` varchar(100) NOT NULL,
  `UserEmpPreviousOrg` varchar(100) NOT NULL,
  `UserEmpBloodGroup` varchar(100) NOT NULL,
  `UserEmpReraId` varchar(100) NOT NULL,
  `UserEmpReportingMember` varchar(100) NOT NULL,
  `UserEmpJoinedId` varchar(100) NOT NULL,
  `UserEmpCRMStatus` varchar(100) NOT NULL,
  `UserEmpVisitingCard` varchar(100) NOT NULL,
  `UserEmpWorkEmailId` varchar(100) NOT NULL,
  `UserEmpGroupName` varchar(100) NOT NULL,
  `UserEmpType` varchar(100) NOT NULL,
  `UserEmpLocations` varchar(100) NOT NULL,
  `UserEmpRoleStatus` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_family_members`
--

CREATE TABLE `user_family_members` (
  `UserFamilyMemberId` int(10) NOT NULL,
  `UserFMMainUserId` int(10) NOT NULL,
  `UserFamilyMemberName` varchar(50) NOT NULL,
  `UserFamilyMemberRelation` varchar(50) NOT NULL,
  `UserFamilyMemberPhoneNumber` varchar(15) NOT NULL,
  `UserFamilyMemberDateOfBirth` varchar(25) NOT NULL,
  `UserFamilyMemberCreatedAt` varchar(25) NOT NULL,
  `UserFamilyMemberUpdatedBy` int(10) NOT NULL,
  `UserFamilyUpdatedAt` varchar(25) NOT NULL,
  `UserFamilyMemberStatus` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_in_out`
--

CREATE TABLE `user_in_out` (
  `user_in_out_id` int(100) NOT NULL,
  `user_main_id` int(10) NOT NULL,
  `user_in_out_date` varchar(100) NOT NULL,
  `user_in_time` varchar(50) NOT NULL,
  `user_out_time` varchar(50) NOT NULL,
  `user_in_out_status` varchar(10) NOT NULL,
  `user_in_out_approved_by` int(10) NOT NULL,
  `user_in_out_created_by` int(10) NOT NULL,
  `user_in_out_updated_by` int(10) NOT NULL,
  `user_in_out_created_at` varchar(100) NOT NULL,
  `user_in_out_updated_at` varchar(100) NOT NULL,
  `user_in_out_remarks` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_leaves`
--

CREATE TABLE `user_leaves` (
  `UserLeaveId` int(10) NOT NULL,
  `UserMainId` int(10) NOT NULL,
  `UserLeaveFromDate` varchar(40) NOT NULL,
  `UserLeaveToDate` varchar(40) NOT NULL,
  `UserLeaveReJoinDate` varchar(40) NOT NULL,
  `UserLeaveReason` varchar(1000) NOT NULL,
  `UserLeaveCreatedAt` varchar(40) NOT NULL,
  `UserLeaveCreatedBy` varchar(40) NOT NULL,
  `UserLeaveStatus` varchar(10) NOT NULL,
  `UserLeaveType` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_attachments`
--

CREATE TABLE `user_leave_attachments` (
  `UserLeaveFileId` int(10) NOT NULL,
  `UserLeaveMainId` int(10) NOT NULL,
  `UserLeaveAttachedFile` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_contact_nos`
--

CREATE TABLE `user_leave_contact_nos` (
  `UserLeaveContactId` int(10) NOT NULL,
  `UserLeaveMainId` int(10) NOT NULL,
  `UserLeaveContactPersonName` varchar(50) NOT NULL,
  `UserLeaveContactPersonPhoneNumber` varchar(15) NOT NULL,
  `UserLeaveContactPersonAddress` varchar(255) NOT NULL,
  `UserLeaveContactPersonRelation` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_leave_status`
--

CREATE TABLE `user_leave_status` (
  `UserLeaveStatusId` int(10) NOT NULL,
  `UserLeaveMainId` int(10) NOT NULL,
  `UserLeaveStatus` varchar(30) NOT NULL,
  `UserLeaveStatusAddedBy` int(10) NOT NULL,
  `UserLeaveStatusAddedAt` varchar(40) NOT NULL,
  `UserLeaveStatusRemarks` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_meetings`
--

CREATE TABLE `user_meetings` (
  `user_meeting_id` int(10) NOT NULL,
  `user_main_user_id` int(10) NOT NULL,
  `user_meeting_check_in_id` int(10) NOT NULL,
  `user_meeting_person_name` varchar(1000) NOT NULL,
  `user_meeting_phone_number` varchar(20) NOT NULL,
  `user_meeting_remarks` longtext NOT NULL,
  `user_meeting_date` varchar(40) NOT NULL,
  `user_meeting_created_at` varchar(40) NOT NULL,
  `user_meeting_created_by` int(10) NOT NULL,
  `user_meeting_updated_at` varchar(40) NOT NULL,
  `user_meeting_updated_by` int(10) NOT NULL,
  `user_meeting_status` varchar(10) NOT NULL,
  `user_meeting_start_at` varchar(50) NOT NULL,
  `user_meeting_ended_at` varchar(50) NOT NULL,
  `user_meeting_email_id` varchar(400) NOT NULL,
  `user_meeting_response` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_password_change_requests`
--

CREATE TABLE `user_password_change_requests` (
  `PasswordChangeReqId` int(100) NOT NULL,
  `UserIdForPasswordChange` varchar(1000) NOT NULL,
  `PasswordChangeToken` varchar(1000) NOT NULL,
  `PasswordChangeTokenExpireTime` varchar(1000) NOT NULL,
  `PasswordChangeDeviceDetails` varchar(10000) NOT NULL,
  `PasswordChangeRequestStatus` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_password_change_requests`
--

INSERT INTO `user_password_change_requests` (`PasswordChangeReqId`, `UserIdForPasswordChange`, `PasswordChangeToken`, `PasswordChangeTokenExpireTime`, `PasswordChangeDeviceDetails`, `PasswordChangeRequestStatus`) VALUES
(1, '3', 'Mnpac1VyUDMzaWN0YTh6QWJCa05ZRFBNSTB1S3hkWWlvRE54ajZkVnUyZk9SM1AxeXBnTkxtdGdiTXBVVEd3MkpkY2R2NDVtQU54V2V6YlM5TzVkd0E9PQ==', '21-03-2024 16:13', 'ZTJEanRHQ0JZTjExY09OcGRUMERDaU43SWptT2gzUmFwK1p3cWNqVnMwd05nd3VpbkRXZ2hremk4YWdGekZ6ZDBycTdXeE5hOVNUYTFBZWo1YUJ5NHNGTWxUdktqenVaMVpUeDR4cTUyVmYwRG5CSlk4bENFTGc3MHhlOUVPcGw3VmY5NStyRzlzcWJPSHFIeVh3cWRnUThoVTI1UFVQR01Oazd6Yk45UXVSRmhycXNRRmhCb2cvNGo3emRENFVoMTVISDlCZ1BDOTZCMmkrUEZyMVN6aktuZmRBQUJXdXpSR1FvSVluOWxYMFRMSUdCWlV2MzJmc250eWI2TVNzeVYxQmNiU2loNVk0SXphUitvOWNWaXJRZHZ2MWRhdXRBZzgzb0JiUDR5YW5IRW5GNW5vRGNEelhWS003RmpoOHg5R3dVZmF0K3VZTmVjREliYmg3RFNNMHlLL1djQkNKUUZtQnBuMHZwZTB5cHM3Q09BWlZ2YStFK0pyK2QwVG9nYTlIaFlBcFlEMndFUkVqY3RxbytlVzdNeXBZZmF0WmIrc0xraXBSbWtrVE8wS3ZrMmwrTFgzMFFkWE44V3hJUml0MVFZQTlXR3ZPcWk3RHZldFdBcEJjQkR4NGphRUxLUE1pS0xRUjFZMTEzTEN4bi9ldDlOZXR6YmhONWpTWFJMY3VTeGlXd3l4N3V4VU9tbmlob3hWeEpyTVlWTytBSklydU5VRHRZMVFFS2pFaXpNemFoOUIreUNyRW1YY2RQNnoyaDF1ZE9xYzFEU2M1cXcvOEhQTUlZYzdIdU1IaEVoZEtYYTFOMFpmVGNvcGpVam4zY24wUGh4MWVqRTcrMlJPRHpOU0hYOUxnTHVpeXhXQkNpMXlHMzdudjI5RE1CLzBpSVVaR2dVVTZFUzNIUUl0ZU1JaSt3WWZOZk8zTG5xczBQRjJpTnowT280ZXVjQkdKNUVhaVZNMW1qZHYzZ3VxMVY1dXhOU0E1UnZRMW1pQU1OYVBjYmtMSWhlbktKdXozWGRtMHdPR09Qd1ducW92SGVIN2xBeVNLai9EMGdZcXl5STY2K0NXMVA3QVdoZUh2TzJZYSt0UW1tVVI2SFJlM1lvcktaTUlRcWZPWTc5VVFqelNRclpwZ1g1WkFxaHVXRkhsNWJVNERWRFQwQ2V0ZjF1cWppUHA0NFNBSTloUFJ6WmhHRzVMdmZGUjRqV3lFeGRGSTIvMkNDRklZOUNUQ1JXRm1OQk5KWS9tSmZuTDdhMnZPMllpWXBNUVpSczhCSnh2SXhWTllFdHpwSy9XcDd2c1NJbCtmckU1QytnNkZIeXN2M3ZvZlJSd254QU1COCtMdExhbzJHL29pb3pIaUQza0JwRllDSm5zSEtRWkZiem9WbDlJdThwRGZNS290NXNCN0dXL1AyMm1CcGljSEFTdnRuTkl6MEQzYUdiZEVpRGlSVUJrSXB0Q2R0c3FDZnFWM3RhbE5sMVVBSzduRjdpMXhjbU10ckRIQWNNTEZvcDRYSk83N0JPVDBaRjlnUEY0ZlhmSFcwdlVFVVQ1WmJjMHpCV2tod2NQUjZWMzZ0NXU4TDZrZVpFemEwdGZCNVNzUzhtVDdUcFFHenJpRm5ZTlJXZTJXQ2lWUVZhbkpneDl1RFRoU2FrZy81eEV6a1B0Ty9lYkdnZ2lJZXRpbTZCRU1lSGF2STlPaXZ5Q01MYkxGZno4UjV4aHMzbzhENFFobmhwUUdhbm5BbkY3aE84bUwyNzV6NEF0UWhNZWZjUjVkY3ZpYzlpYVZx', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `UserPermissionsId` int(100) NOT NULL,
  `UserPermissionUserId` int(100) NOT NULL,
  `UserPermissionForAccess` varchar(500) NOT NULL,
  `UserPermissions` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_pips`
--

CREATE TABLE `user_pips` (
  `UserPipId` int(10) NOT NULL,
  `UserPIPRefNo` varchar(100) NOT NULL,
  `UserPIPMainUserId` varchar(10) NOT NULL,
  `UserPIPSubjectName` varchar(255) NOT NULL,
  `UserPIPMessage` longtext NOT NULL,
  `UserPIPCreatedAt` varchar(40) NOT NULL,
  `UserPIPUpdatedAt` varchar(40) NOT NULL,
  `UserPIPCreatedBy` varchar(10) NOT NULL,
  `UserPIPEmailStatus` varchar(10) NOT NULL,
  `UserPIPUpdatedBy` varchar(10) NOT NULL,
  `UserPipStatus` varchar(10) NOT NULL,
  `UserPIPReadAt` varchar(25) NOT NULL,
  `UserPipDocuments` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_rewards`
--

CREATE TABLE `user_rewards` (
  `RewardsId` int(10) NOT NULL,
  `RewardRefNo` varchar(100) NOT NULL,
  `RewardName` varchar(1000) NOT NULL,
  `RewardMainUserId` int(10) NOT NULL,
  `RewardAttachedCreative` varchar(1000) NOT NULL,
  `RewardCreatedAt` varchar(40) NOT NULL,
  `RewardReceiveDate` varchar(40) NOT NULL,
  `RewardCreatedBy` varchar(10) NOT NULL,
  `RewardStatus` varchar(10) NOT NULL,
  `RewardMessage` longtext NOT NULL,
  `RewardUpdatedAt` varchar(100) NOT NULL,
  `RewardUpdatedBy` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `VisitorId` int(100) NOT NULL,
  `VisitorPersonName` varchar(100) NOT NULL,
  `VisitorPersonPhone` varchar(100) NOT NULL,
  `VisitorPersonEmailId` varchar(100) NOT NULL,
  `VisitPurpose` varchar(100) NOT NULL,
  `VisitPesonMeetWith` varchar(100) NOT NULL,
  `VisitPersonType` varchar(100) NOT NULL,
  `VisitPeronsDescription` varchar(10000) NOT NULL,
  `VisitPersonCreatedAt` varchar(100) NOT NULL,
  `VisitPersonUpdatedAt` varchar(100) NOT NULL,
  `VisitEnquiryStatus` varchar(50) NOT NULL,
  `VisitEntryCreatedBy` varchar(50) NOT NULL,
  `VisitorOutTime` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `app_quotes`
--
ALTER TABLE `app_quotes`
  ADD PRIMARY KEY (`AppQuotesId`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`AssetsId`);

--
-- Indexes for table `assets_issued`
--
ALTER TABLE `assets_issued`
  ADD PRIMARY KEY (`AssetsMoveId`);

--
-- Indexes for table `assets_returned`
--
ALTER TABLE `assets_returned`
  ADD PRIMARY KEY (`AssetsReturnedId`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`bookingId`);

--
-- Indexes for table `booking_refunds`
--
ALTER TABLE `booking_refunds`
  ADD PRIMARY KEY (`BookingRefundId`);

--
-- Indexes for table `booking_refund_documents`
--
ALTER TABLE `booking_refund_documents`
  ADD PRIMARY KEY (`BookingRefundDocId`);

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`ChatId`);

--
-- Indexes for table `chat_attachements`
--
ALTER TABLE `chat_attachements`
  ADD PRIMARY KEY (`ChatAttachId`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`ChatMessageId`);

--
-- Indexes for table `circulars`
--
ALTER TABLE `circulars`
  ADD PRIMARY KEY (`CircularId`);

--
-- Indexes for table `circular_files`
--
ALTER TABLE `circular_files`
  ADD PRIMARY KEY (`CircularFileId`);

--
-- Indexes for table `circular_status`
--
ALTER TABLE `circular_status`
  ADD PRIMARY KEY (`CircularStatusId`);

--
-- Indexes for table `comaigns`
--
ALTER TABLE `comaigns`
  ADD PRIMARY KEY (`ComaignId`);

--
-- Indexes for table `company_policies`
--
ALTER TABLE `company_policies`
  ADD PRIMARY KEY (`PolicyId`);

--
-- Indexes for table `company_policy_applicable_on`
--
ALTER TABLE `company_policy_applicable_on`
  ADD PRIMARY KEY (`ApplicableId`);

--
-- Indexes for table `configs`
--
ALTER TABLE `configs`
  ADD PRIMARY KEY (`ConfigsId`);

--
-- Indexes for table `configurations`
--
ALTER TABLE `configurations`
  ADD PRIMARY KEY (`configurationsid`);

--
-- Indexes for table `config_holidays`
--
ALTER TABLE `config_holidays`
  ADD PRIMARY KEY (`ConfigHolidayid`);

--
-- Indexes for table `config_locations`
--
ALTER TABLE `config_locations`
  ADD PRIMARY KEY (`config_location_id`);

--
-- Indexes for table `config_mail_sender`
--
ALTER TABLE `config_mail_sender`
  ADD PRIMARY KEY (`config_mail_sender_id`);

--
-- Indexes for table `config_modules`
--
ALTER TABLE `config_modules`
  ADD PRIMARY KEY (`ConfigModuleId`);

--
-- Indexes for table `config_payroll_allowances`
--
ALTER TABLE `config_payroll_allowances`
  ADD PRIMARY KEY (`payroll_allowance_id`);

--
-- Indexes for table `config_payroll_allowance_for_users`
--
ALTER TABLE `config_payroll_allowance_for_users`
  ADD PRIMARY KEY (`payroll_allowance_for_emps_id`);

--
-- Indexes for table `config_payroll_deductions`
--
ALTER TABLE `config_payroll_deductions`
  ADD PRIMARY KEY (`payroll_deduction_id`);

--
-- Indexes for table `config_payroll_deductions_for_users`
--
ALTER TABLE `config_payroll_deductions_for_users`
  ADD PRIMARY KEY (`payroll_deductions_for_users_id`);

--
-- Indexes for table `config_pgs`
--
ALTER TABLE `config_pgs`
  ADD PRIMARY KEY (`ConfigPgId`);

--
-- Indexes for table `config_values`
--
ALTER TABLE `config_values`
  ADD PRIMARY KEY (`ConfigValueId`);

--
-- Indexes for table `creatives`
--
ALTER TABLE `creatives`
  ADD PRIMARY KEY (`CreativeId`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerId`);

--
-- Indexes for table `customer_address`
--
ALTER TABLE `customer_address`
  ADD PRIMARY KEY (`CustAddressId`);

--
-- Indexes for table `customer_co_address_details`
--
ALTER TABLE `customer_co_address_details`
  ADD PRIMARY KEY (`CustomerCoAddressId`);

--
-- Indexes for table `customer_co_details`
--
ALTER TABLE `customer_co_details`
  ADD PRIMARY KEY (`CustCoId`);

--
-- Indexes for table `customer_co_documents`
--
ALTER TABLE `customer_co_documents`
  ADD PRIMARY KEY (`CustomerCoDocId`);

--
-- Indexes for table `customer_documents`
--
ALTER TABLE `customer_documents`
  ADD PRIMARY KEY (`CustomerDocumentId`);

--
-- Indexes for table `customer_nominees`
--
ALTER TABLE `customer_nominees`
  ADD PRIMARY KEY (`CustNomineeId`);

--
-- Indexes for table `customer_notifications`
--
ALTER TABLE `customer_notifications`
  ADD PRIMARY KEY (`CustomerNotificationId`);

--
-- Indexes for table `data_leads`
--
ALTER TABLE `data_leads`
  ADD PRIMARY KEY (`LeadsId`);

--
-- Indexes for table `data_lead_followups`
--
ALTER TABLE `data_lead_followups`
  ADD PRIMARY KEY (`LeadFollowUpId`),
  ADD KEY `idx_LeadFollowUpHandleBy` (`LeadFollowUpHandleBy`),
  ADD KEY `idx_LeadFollowMainId` (`LeadFollowMainId`),
  ADD KEY `idx_LeadFollowUpDate` (`LeadFollowUpDate`),
  ADD KEY `idx_LeadFollowUpTime` (`LeadFollowUpTime`);

--
-- Indexes for table `data_lead_followup_durations`
--
ALTER TABLE `data_lead_followup_durations`
  ADD PRIMARY KEY (`leadcallId`);

--
-- Indexes for table `data_lead_requirements`
--
ALTER TABLE `data_lead_requirements`
  ADD PRIMARY KEY (`LeadRequirementID`);

--
-- Indexes for table `data_lead_uploads`
--
ALTER TABLE `data_lead_uploads`
  ADD PRIMARY KEY (`leadsUploadId`);

--
-- Indexes for table `expanses`
--
ALTER TABLE `expanses`
  ADD PRIMARY KEY (`ExpansesId`);

--
-- Indexes for table `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`LeadsId`);

--
-- Indexes for table `lead_followups`
--
ALTER TABLE `lead_followups`
  ADD PRIMARY KEY (`LeadFollowUpId`);

--
-- Indexes for table `lead_followup_durations`
--
ALTER TABLE `lead_followup_durations`
  ADD PRIMARY KEY (`leadcallId`);

--
-- Indexes for table `lead_requirements`
--
ALTER TABLE `lead_requirements`
  ADD PRIMARY KEY (`LeadRequirementID`);

--
-- Indexes for table `lead_uploads`
--
ALTER TABLE `lead_uploads`
  ADD PRIMARY KEY (`leadsUploadId`);

--
-- Indexes for table `marketing_collaterals`
--
ALTER TABLE `marketing_collaterals`
  ADD PRIMARY KEY (`MarketingCoId`);

--
-- Indexes for table `newspapercompaigns`
--
ALTER TABLE `newspapercompaigns`
  ADD PRIMARY KEY (`NewCompaignId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationsId`);

--
-- Indexes for table `od_forms`
--
ALTER TABLE `od_forms`
  ADD PRIMARY KEY (`OdFormId`);

--
-- Indexes for table `od_form_attachements`
--
ALTER TABLE `od_form_attachements`
  ADD PRIMARY KEY (`OdFormAttachmentId`);

--
-- Indexes for table `od_form_status`
--
ALTER TABLE `od_form_status`
  ADD PRIMARY KEY (`OdFormStatuslId`);

--
-- Indexes for table `payrolls`
--
ALTER TABLE `payrolls`
  ADD PRIMARY KEY (`payrolls_id`);

--
-- Indexes for table `payroll_allowances`
--
ALTER TABLE `payroll_allowances`
  ADD PRIMARY KEY (`pay_allowance_id`);

--
-- Indexes for table `payroll_deductions`
--
ALTER TABLE `payroll_deductions`
  ADD PRIMARY KEY (`pay_deduction_id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`ProjectsId`);

--
-- Indexes for table `project_media_files`
--
ALTER TABLE `project_media_files`
  ADD PRIMARY KEY (`ProjectMediaFileId`);

--
-- Indexes for table `project_units`
--
ALTER TABLE `project_units`
  ADD PRIMARY KEY (`project_unit_id`);

--
-- Indexes for table `reception_activity`
--
ALTER TABLE `reception_activity`
  ADD PRIMARY KEY (`reception_activity_id`);

--
-- Indexes for table `reception_courier`
--
ALTER TABLE `reception_courier`
  ADD PRIMARY KEY (`reception_courier_id`);

--
-- Indexes for table `reception_meeting`
--
ALTER TABLE `reception_meeting`
  ADD PRIMARY KEY (`reception_meeting_id`);

--
-- Indexes for table `reception_sitevisit`
--
ALTER TABLE `reception_sitevisit`
  ADD PRIMARY KEY (`reception_sitevisit_id`);

--
-- Indexes for table `registrations`
--
ALTER TABLE `registrations`
  ADD PRIMARY KEY (`RegistrationId`);

--
-- Indexes for table `registration_activities`
--
ALTER TABLE `registration_activities`
  ADD PRIMARY KEY (`RegActivityId`);

--
-- Indexes for table `registration_charges`
--
ALTER TABLE `registration_charges`
  ADD PRIMARY KEY (`RegChargeId`);

--
-- Indexes for table `registration_members`
--
ALTER TABLE `registration_members`
  ADD PRIMARY KEY (`RegMemberId`);

--
-- Indexes for table `registration_nominee_docs`
--
ALTER TABLE `registration_nominee_docs`
  ADD PRIMARY KEY (`RegNomDocId`);

--
-- Indexes for table `registration_nom_transfer`
--
ALTER TABLE `registration_nom_transfer`
  ADD PRIMARY KEY (`RegNomTransferId`);

--
-- Indexes for table `registration_nom_transfer_docs`
--
ALTER TABLE `registration_nom_transfer_docs`
  ADD PRIMARY KEY (`RegNomTranDocId`);

--
-- Indexes for table `registration_payments`
--
ALTER TABLE `registration_payments`
  ADD PRIMARY KEY (`RegPaymentId`);

--
-- Indexes for table `registration_payment_activities`
--
ALTER TABLE `registration_payment_activities`
  ADD PRIMARY KEY (`RegPayActivityId`);

--
-- Indexes for table `registration_refunds`
--
ALTER TABLE `registration_refunds`
  ADD PRIMARY KEY (`RegRefundId`);

--
-- Indexes for table `registration_refund_documents`
--
ALTER TABLE `registration_refund_documents`
  ADD PRIMARY KEY (`RegRefundDocId`);

--
-- Indexes for table `systemlogs`
--
ALTER TABLE `systemlogs`
  ADD PRIMARY KEY (`LogsId`);

--
-- Indexes for table `trainings`
--
ALTER TABLE `trainings`
  ADD PRIMARY KEY (`TrainingId`);

--
-- Indexes for table `training_members`
--
ALTER TABLE `training_members`
  ADD PRIMARY KEY (`TrainingMemberId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `user_access`
--
ALTER TABLE `user_access`
  ADD PRIMARY KEY (`UserAccessId`);

--
-- Indexes for table `user_addresses`
--
ALTER TABLE `user_addresses`
  ADD PRIMARY KEY (`UserAddressId`);

--
-- Indexes for table `user_allowed_leaves`
--
ALTER TABLE `user_allowed_leaves`
  ADD PRIMARY KEY (`UserAllowedLeaveId`);

--
-- Indexes for table `user_appraisals`
--
ALTER TABLE `user_appraisals`
  ADD PRIMARY KEY (`UserAppraisalId`);

--
-- Indexes for table `user_attandance_check_in`
--
ALTER TABLE `user_attandance_check_in`
  ADD PRIMARY KEY (`check_in_id`);

--
-- Indexes for table `user_attandance_check_out`
--
ALTER TABLE `user_attandance_check_out`
  ADD PRIMARY KEY (`check_out_id`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`UserBankDetailsId`);

--
-- Indexes for table `user_day_breaks`
--
ALTER TABLE `user_day_breaks`
  ADD PRIMARY KEY (`day_break_id`);

--
-- Indexes for table `user_documents`
--
ALTER TABLE `user_documents`
  ADD PRIMARY KEY (`UserDocsId`);

--
-- Indexes for table `user_employment_details`
--
ALTER TABLE `user_employment_details`
  ADD PRIMARY KEY (`UserEmpDetailsId`);

--
-- Indexes for table `user_family_members`
--
ALTER TABLE `user_family_members`
  ADD PRIMARY KEY (`UserFamilyMemberId`);

--
-- Indexes for table `user_in_out`
--
ALTER TABLE `user_in_out`
  ADD PRIMARY KEY (`user_in_out_id`);

--
-- Indexes for table `user_leaves`
--
ALTER TABLE `user_leaves`
  ADD PRIMARY KEY (`UserLeaveId`);

--
-- Indexes for table `user_leave_attachments`
--
ALTER TABLE `user_leave_attachments`
  ADD PRIMARY KEY (`UserLeaveFileId`);

--
-- Indexes for table `user_leave_contact_nos`
--
ALTER TABLE `user_leave_contact_nos`
  ADD PRIMARY KEY (`UserLeaveContactId`);

--
-- Indexes for table `user_leave_status`
--
ALTER TABLE `user_leave_status`
  ADD PRIMARY KEY (`UserLeaveStatusId`);

--
-- Indexes for table `user_meetings`
--
ALTER TABLE `user_meetings`
  ADD PRIMARY KEY (`user_meeting_id`);

--
-- Indexes for table `user_password_change_requests`
--
ALTER TABLE `user_password_change_requests`
  ADD PRIMARY KEY (`PasswordChangeReqId`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`UserPermissionsId`);

--
-- Indexes for table `user_pips`
--
ALTER TABLE `user_pips`
  ADD PRIMARY KEY (`UserPipId`);

--
-- Indexes for table `user_rewards`
--
ALTER TABLE `user_rewards`
  ADD PRIMARY KEY (`RewardsId`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`VisitorId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `app_quotes`
--
ALTER TABLE `app_quotes`
  MODIFY `AppQuotesId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `AssetsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_issued`
--
ALTER TABLE `assets_issued`
  MODIFY `AssetsMoveId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assets_returned`
--
ALTER TABLE `assets_returned`
  MODIFY `AssetsReturnedId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `bookingId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_refunds`
--
ALTER TABLE `booking_refunds`
  MODIFY `BookingRefundId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_refund_documents`
--
ALTER TABLE `booking_refund_documents`
  MODIFY `BookingRefundDocId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `ChatId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_attachements`
--
ALTER TABLE `chat_attachements`
  MODIFY `ChatAttachId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `ChatMessageId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `circulars`
--
ALTER TABLE `circulars`
  MODIFY `CircularId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `circular_files`
--
ALTER TABLE `circular_files`
  MODIFY `CircularFileId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `circular_status`
--
ALTER TABLE `circular_status`
  MODIFY `CircularStatusId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comaigns`
--
ALTER TABLE `comaigns`
  MODIFY `ComaignId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_policies`
--
ALTER TABLE `company_policies`
  MODIFY `PolicyId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `company_policy_applicable_on`
--
ALTER TABLE `company_policy_applicable_on`
  MODIFY `ApplicableId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `configs`
--
ALTER TABLE `configs`
  MODIFY `ConfigsId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `configurations`
--
ALTER TABLE `configurations`
  MODIFY `configurationsid` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `config_holidays`
--
ALTER TABLE `config_holidays`
  MODIFY `ConfigHolidayid` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_locations`
--
ALTER TABLE `config_locations`
  MODIFY `config_location_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `config_mail_sender`
--
ALTER TABLE `config_mail_sender`
  MODIFY `config_mail_sender_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `config_modules`
--
ALTER TABLE `config_modules`
  MODIFY `ConfigModuleId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_payroll_allowances`
--
ALTER TABLE `config_payroll_allowances`
  MODIFY `payroll_allowance_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_payroll_allowance_for_users`
--
ALTER TABLE `config_payroll_allowance_for_users`
  MODIFY `payroll_allowance_for_emps_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_payroll_deductions`
--
ALTER TABLE `config_payroll_deductions`
  MODIFY `payroll_deduction_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_payroll_deductions_for_users`
--
ALTER TABLE `config_payroll_deductions_for_users`
  MODIFY `payroll_deductions_for_users_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `config_pgs`
--
ALTER TABLE `config_pgs`
  MODIFY `ConfigPgId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `config_values`
--
ALTER TABLE `config_values`
  MODIFY `ConfigValueId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `creatives`
--
ALTER TABLE `creatives`
  MODIFY `CreativeId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_address`
--
ALTER TABLE `customer_address`
  MODIFY `CustAddressId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_co_address_details`
--
ALTER TABLE `customer_co_address_details`
  MODIFY `CustomerCoAddressId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_co_details`
--
ALTER TABLE `customer_co_details`
  MODIFY `CustCoId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_co_documents`
--
ALTER TABLE `customer_co_documents`
  MODIFY `CustomerCoDocId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_documents`
--
ALTER TABLE `customer_documents`
  MODIFY `CustomerDocumentId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_nominees`
--
ALTER TABLE `customer_nominees`
  MODIFY `CustNomineeId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customer_notifications`
--
ALTER TABLE `customer_notifications`
  MODIFY `CustomerNotificationId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_leads`
--
ALTER TABLE `data_leads`
  MODIFY `LeadsId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lead_followups`
--
ALTER TABLE `data_lead_followups`
  MODIFY `LeadFollowUpId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lead_followup_durations`
--
ALTER TABLE `data_lead_followup_durations`
  MODIFY `leadcallId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lead_requirements`
--
ALTER TABLE `data_lead_requirements`
  MODIFY `LeadRequirementID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `data_lead_uploads`
--
ALTER TABLE `data_lead_uploads`
  MODIFY `leadsUploadId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expanses`
--
ALTER TABLE `expanses`
  MODIFY `ExpansesId` bigint(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leads`
--
ALTER TABLE `leads`
  MODIFY `LeadsId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_followups`
--
ALTER TABLE `lead_followups`
  MODIFY `LeadFollowUpId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_followup_durations`
--
ALTER TABLE `lead_followup_durations`
  MODIFY `leadcallId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_requirements`
--
ALTER TABLE `lead_requirements`
  MODIFY `LeadRequirementID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lead_uploads`
--
ALTER TABLE `lead_uploads`
  MODIFY `leadsUploadId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `marketing_collaterals`
--
ALTER TABLE `marketing_collaterals`
  MODIFY `MarketingCoId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `newspapercompaigns`
--
ALTER TABLE `newspapercompaigns`
  MODIFY `NewCompaignId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationsId` bigint(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `od_forms`
--
ALTER TABLE `od_forms`
  MODIFY `OdFormId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `od_form_attachements`
--
ALTER TABLE `od_form_attachements`
  MODIFY `OdFormAttachmentId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `od_form_status`
--
ALTER TABLE `od_form_status`
  MODIFY `OdFormStatuslId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrolls`
--
ALTER TABLE `payrolls`
  MODIFY `payrolls_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_allowances`
--
ALTER TABLE `payroll_allowances`
  MODIFY `pay_allowance_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll_deductions`
--
ALTER TABLE `payroll_deductions`
  MODIFY `pay_deduction_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `ProjectsId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `project_media_files`
--
ALTER TABLE `project_media_files`
  MODIFY `ProjectMediaFileId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project_units`
--
ALTER TABLE `project_units`
  MODIFY `project_unit_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reception_activity`
--
ALTER TABLE `reception_activity`
  MODIFY `reception_activity_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reception_courier`
--
ALTER TABLE `reception_courier`
  MODIFY `reception_courier_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reception_meeting`
--
ALTER TABLE `reception_meeting`
  MODIFY `reception_meeting_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reception_sitevisit`
--
ALTER TABLE `reception_sitevisit`
  MODIFY `reception_sitevisit_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrations`
--
ALTER TABLE `registrations`
  MODIFY `RegistrationId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_activities`
--
ALTER TABLE `registration_activities`
  MODIFY `RegActivityId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_charges`
--
ALTER TABLE `registration_charges`
  MODIFY `RegChargeId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_members`
--
ALTER TABLE `registration_members`
  MODIFY `RegMemberId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_nominee_docs`
--
ALTER TABLE `registration_nominee_docs`
  MODIFY `RegNomDocId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_nom_transfer`
--
ALTER TABLE `registration_nom_transfer`
  MODIFY `RegNomTransferId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_nom_transfer_docs`
--
ALTER TABLE `registration_nom_transfer_docs`
  MODIFY `RegNomTranDocId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_payments`
--
ALTER TABLE `registration_payments`
  MODIFY `RegPaymentId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_payment_activities`
--
ALTER TABLE `registration_payment_activities`
  MODIFY `RegPayActivityId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_refunds`
--
ALTER TABLE `registration_refunds`
  MODIFY `RegRefundId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registration_refund_documents`
--
ALTER TABLE `registration_refund_documents`
  MODIFY `RegRefundDocId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `systemlogs`
--
ALTER TABLE `systemlogs`
  MODIFY `LogsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `trainings`
--
ALTER TABLE `trainings`
  MODIFY `TrainingId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_members`
--
ALTER TABLE `training_members`
  MODIFY `TrainingMemberId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT for table `user_access`
--
ALTER TABLE `user_access`
  MODIFY `UserAccessId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=539;

--
-- AUTO_INCREMENT for table `user_addresses`
--
ALTER TABLE `user_addresses`
  MODIFY `UserAddressId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_allowed_leaves`
--
ALTER TABLE `user_allowed_leaves`
  MODIFY `UserAllowedLeaveId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_appraisals`
--
ALTER TABLE `user_appraisals`
  MODIFY `UserAppraisalId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_attandance_check_in`
--
ALTER TABLE `user_attandance_check_in`
  MODIFY `check_in_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_attandance_check_out`
--
ALTER TABLE `user_attandance_check_out`
  MODIFY `check_out_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `UserBankDetailsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_day_breaks`
--
ALTER TABLE `user_day_breaks`
  MODIFY `day_break_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_documents`
--
ALTER TABLE `user_documents`
  MODIFY `UserDocsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_employment_details`
--
ALTER TABLE `user_employment_details`
  MODIFY `UserEmpDetailsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_family_members`
--
ALTER TABLE `user_family_members`
  MODIFY `UserFamilyMemberId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_in_out`
--
ALTER TABLE `user_in_out`
  MODIFY `user_in_out_id` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_leaves`
--
ALTER TABLE `user_leaves`
  MODIFY `UserLeaveId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_leave_attachments`
--
ALTER TABLE `user_leave_attachments`
  MODIFY `UserLeaveFileId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_leave_contact_nos`
--
ALTER TABLE `user_leave_contact_nos`
  MODIFY `UserLeaveContactId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_leave_status`
--
ALTER TABLE `user_leave_status`
  MODIFY `UserLeaveStatusId` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_meetings`
--
ALTER TABLE `user_meetings`
  MODIFY `user_meeting_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_password_change_requests`
--
ALTER TABLE `user_password_change_requests`
  MODIFY `PasswordChangeReqId` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `UserPermissionsId` int(100) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_pips`
--
ALTER TABLE `user_pips`
  MODIFY `UserPipId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_rewards`
--
ALTER TABLE `user_rewards`
  MODIFY `RewardsId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `VisitorId` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
