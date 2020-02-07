
--
-- Database: `parkingdb`
--

-- --------------------------------------------------------

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`u_first`, `u_last`, `u_email`, `u_password`, `u_role`, `u_id`) VALUES
('Александър', 'Гълъбов', 'admin@abv.bg', '$2y$10$36PFZVtgrbPgrznEhcA.M.Kn9clEk966F6fkh4hp9a42flHJApo1m', 'admin', 1),
('Невена', 'Гаджева', 'temp@abv.bg', '$2y$10$u.wQ9zr0Es/TRTdgweM/mOi1LM36/IS1RnIxBccTuj/uPChaRwz7q', 'temporary', 6),
('Трифон', 'Трифонов', 'trifonFMI@gmail.com', '$2y$10$uljynZe3M9uI7NCPZCbbDOMZcCn7bVp/wPsHKdu0/PK1qb5tV0X1G', 'permanent', 7),
('Милен', 'Петров', 'm.petrovFMI@abv.bg', '$2y$10$B8v5YexEH6TcVMW0cpL7o.AUk9aHgEgL8cC6nC6sUZifTBruwYuqS', 'permanent', 28);

-- --------------------------------------------------------

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_title`, `teacher_id`, `course_day`, `course_from`, `course_to`) VALUES
(4, 'ФП', 6, 'Wednesday', '09:15:00', '12:00:00'),
(6, 'УЗ', 7, 'Monday', '10:15:00', '12:00:00'),
(7, 'АЕ', 7, 'Monday', '10:00:00', '12:00:00'),
(8, 'Алгебра', 6, 'Thursday', '16:15:00', '18:00:00'),
(9, 'ЛП', 7, 'Friday', '12:15:00', '15:00:00');


