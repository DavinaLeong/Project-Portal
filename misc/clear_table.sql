DELETE FROM `user` WHERE `username` != 'admin';

ALTER TABLE `user` AUTO_INCREMENT = 2;