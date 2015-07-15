CREATE TABLE IF NOT EXISTS `gf_user` (
`id` int(16) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` varchar(20) NOT NULL,
  `sessionid` varchar(1024) NOT NULL,
  `autowish` tinyint(1) NOT NULL,
  `autorand` tinyint(1) NOT NULL,
  `lastjoin` int(32) NOT NULL,
  `wins` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

ALTER TABLE `gf_user`
 ADD PRIMARY KEY (`id`);
